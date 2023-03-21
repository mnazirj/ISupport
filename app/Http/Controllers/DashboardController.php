<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\CreateLabelRequest;
use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\EditCategoryRequest;
use App\Http\Requests\EditLabelRequest;
use App\Http\Requests\EditTicketRequest;
use App\Models\Category;
use App\Models\category_ticket;
use App\Models\Comment;
use App\Models\Label;
use App\Models\label_ticket;
use App\Models\Ticket;
use App\Models\User;
use App\Models\UserLog;

class DashboardController extends Controller
{
    public function Index()
    {
        $User = User::find(session('UserId'));

        if($User->Role->name == 'Administrator'){
            return view('Dashboard.welcome')->with([
                'PageTitle' =>'Dashboard',
                'User' => $User,
                'Tickets'=>Ticket::count(),
            ]);
        }
        elseif($User->Role->name == 'Agent'){
            return view('Dashboard.welcome')->with([
                'PageTitle' =>'Dashboard',
                'User' => $User,
                'Tickets'=>Ticket::where('assigned_user_id',$User->id)->count(),
            ]);
        }
        else{
            return view('Dashboard.welcome')->with([
                'PageTitle' =>'Dashboard',
                'User' => $User,
                'Tickets'=>Ticket::where('userId',$User->id)->count(),
            ]);
        }
        
    }
    

    public function TicketIndex()
    {
        $User = User::find(session('UserId'));
        if($User->Role->name == 'Regular'){
            return view('Dashboard.ticket')->with([
                'PageTitle' =>'Dashboard Tickets',
                'User' => $User,
                'Labels'=> Label::all(),
                'Categories'=>Category::all(),
            ]);
        }
        elseif($User->Role->name == 'Agent'){
            return view('Dashboard.ticket')->with([
                'PageTitle' =>'Dashboard Tickets',
                'User' => $User,
                'Tickets'=>Ticket::where('assigned_user_id',$User->id)->get(),
            ]);
        }
        elseif ($User->Role->name == 'Administrator'){
            return view('Dashboard.ticket')->with([
                'PageTitle' =>'Dashboard Tickets',
                'User' => $User,
                'AssignUser'=> User::where('Role',2)->get(),
                'Tickets'=>Ticket::all(),
                'Labels'=> Label::all(),
                'Categories'=>Category::all(),
            ]);
        }
        
    }

    public function CreateTicket(CreateTicketRequest $request)
    {
        if($request->has('file') && sizeof($request->file) == 1){
            
           $fileName = time() .'.'. $request->file[0]->getClientOriginalExtension();
           $request->file[0]->move(public_path('/test'),$fileName);
           if(sizeof($request->label) == 1 && sizeof($request->category) == 1){
            $Ticket = Ticket::create([
                'title'=>$request->title,
                'description'=>$request->description,
                'priority'=>$request->priority,
                'status'=>'Open',
                'userId'=>session('UserId'),
                'file'=>$fileName,
               ]);
            $LabelId = Label::where('name',$request->label[0])->first('id');
            label_ticket::Create([
                'ticketId'=>$Ticket->id,
                'labelId'=> $LabelId->id,
            ]);
            $CategoryId = Category::where('name',$request->category[0])->first('id');
            category_ticket::Create([
                'tickedId'=> $Ticket->id,
                'categroyId'=> $CategoryId,
            ]);
            UserLog::Create([
                'userId'=>session('UserId'),
                'Action'=>'Create Ticket',
                'ticketId'=>$Ticket->id,
            ]);
              return redirect()->back()->with('success','ticket sent');
           }
           
        }
        else if(sizeof($request->file)> 1 && $request->file != NULL || sizeof($request->label) > 1 || sizeof($request->category) > 1){
            $Files = array();
            for ($i=0; $i < sizeof($request->file); $i++) { 
                    $fileName = time() .'.'. $request->file[$i]->getClientOriginalExtension();
                    $request->file[$i]->move(public_path('/test'),$fileName);
                    $Files += array($i => $fileName);
            }
            $Ticket = Ticket::create([
                'title'=>$request->title,
                'description'=>$request->description,
                'priority'=>$request->priority,
                'status'=>'Open',
                'userId'=>session('UserId'),
                'file'=>json_encode($Files),
            ]);
            for($i=0; $i< sizeof($request->label); $i++){
                $LabelId = Label::where('name',$request->label[$i])->first('id');
                label_ticket::Create([
                'ticketId'=>$Ticket->id,
                'labelId'=> $LabelId->id,
                ]);
            }
            for($i=0; $i< sizeof($request->category); $i++){
                $CategoryId = Category::where('name',$request->category[$i])->first('id');
                category_ticket::Create([
                'ticketId'=> $Ticket->id,
                'categoryId'=> $CategoryId->id,
                ]);
            }
            UserLog::Create([
                'userId'=>session('UserId'),
                'Action'=>'Create',
                'ticketId'=>$Ticket->id,
            ]);
            return redirect()->back()->with('success','ticket sent');
        }
        else{
            $Ticket = Ticket::create([
                'title'=>$request->title,
                'description'=>$request->description,
                'priority'=>$request->priority,
                'status'=>'Open',
                'userId'=>session('UserId'),
                'file'=>null,
               ]);
               UserLog::Create([
                'userId'=>session('UserId'),
                'Action'=>'Create',
                'ticketId'=>$Ticket->id,
                ]);
               for($i=0; $i< sizeof($request->label); $i++){
                $LabelId = Label::where('name',$request->label[$i])->first('id');
                label_ticket::Create([
                'ticketId'=>$Ticket->id,
                'labelId'=> $LabelId->id,
                ]);
            }
            for($i=0; $i< sizeof($request->category); $i++){
                $CategoryId = Category::where('name',$request->category[$i])->first('id');
                category_ticket::Create([
                'tickedId'=> $Ticket->id,
                'categroyId'=> $CategoryId,
                ]);
            }
              return redirect()->back()->with('success','ticket sent');
        }
    }

    public function ViewTicket($id)
    {
        $Ticket = Ticket::find($id);
        if($Ticket == null)
            return redirect()->back();
        return view('Dashboard.view_ticket')->with([
            'PageTitle'=>'View Ticket'. $Ticket->title,
            'Ticket'=>$Ticket,
            'User' => User::find(session('UserId')),
        ]);
    }

    public function EditTicket(EditTicketRequest $request ,$TicketId)
    {
        Ticket::find($TicketId)->update([
            'status'=>$request->status,
            'assigned_user_id'=>$request->support,
        ]);
        UserLog::Create([
            'userId'=>session('UserId'),
            'Action'=>'Edited',
            'ticketId'=>$TicketId,
        ]);
        return redirect()->back()->with('success','changes saved');
    }

    public function DeleteTicket($TicketId)
    {
        label_ticket::where('ticketId',$TicketId)->delete();
        category_ticket::where('ticketId',$TicketId)->delete();
        Comment::where('ticketId',$TicketId)->delete();
        Ticket::destroy($TicketId);
        UserLog::Create([
            'userId'=>session('UserId'),
            'Action'=>'Deleted',
            'ticketId'=>$TicketId,
        ]);
        return redirect()->back()->with('success','changes saved');
    }

    public function CloseTicket($TicketId)
    {
        Ticket::find($TicketId)->update(['status'=>'Closed']);
        UserLog::Create([
            'userId'=>session('UserId'),
            'Action'=>'Closed',
            'ticketId'=>$TicketId,
        ]);
        return redirect(route('dash.post.tickets'))->with('success','Ticket Closed');
    }
    
    public function AddComment(AddCommentRequest $request, $TicketId)
    {
        $User = User::find(session('UserId'));
        if($User->Role->name == 'Regular'){
            Comment::Create(
                [
                    'ticketId'=>$TicketId,
                    'userId'=>session('UserId'),
                    'comment'=>$request->comment,
                ]
            );
            Ticket::find($TicketId)->update(['status' =>'Pending']);
        }
        else{
            Comment::Create(
                [
                    'ticketId'=>$TicketId,
                    'userId'=>session('UserId'),
                    'comment'=>$request->comment,
                ]
            );
            Ticket::find($TicketId)->update(['status'=>'Answered']);
        }
        UserLog::Create([
            'userId'=>session('UserId'),
            'Action'=>'Replied',
            'ticketId'=>$TicketId,
        ]);
        return redirect()->back();
    }
    public function UsersIndex()
    {
        return view('Dashboard.users')->with([
            'PageTitle'=>'List Users',
            'Users'=> User::all(),
        ]);
    }
    public function CateIndex()
    {
        return view('Dashboard.categories')->with([
            'PageTitle'=>'List Categories',
            'Categories'=> Category::all(),
            'User' => User::find(session('UserId')),
        ]);
    }

    public function CreateCategory(CreateCategoryRequest $request)
    {
        Category::Create([
            'name'=>$request->name,
        ]);
        return redirect()->back()->with('success',$request->name.' successfully created !');
    }
    public function EditCategory(EditCategoryRequest $request , $CateId)
    {
        Category::find($CateId)->update([
            'name'=>$request->name,
        ]);

        return redirect()->back()->with('success','Changes saved !');
    }
    public function DeleteCategory($CateId)
    {
        Category::destroy($CateId);
        return redirect()->back()->with('success','Changes saved !');
    }

    public function LabelIndex()
    {
        return view('Dashboard.labels')->with([
            'PageTitle'=>'List Labels',
            'Labels'=> Label::all(),
            'User' => User::find(session('UserId')),
        ]);
    }

    public function CreateLabel(CreateLabelRequest $request)
    {
        Label::Create([
            'name'=>$request->name,
        ]);
        return redirect()->back()->with('success',$request->name.' successfully created !');
    }
    public function EditLabel(EditLabelRequest $request , $LabelId)
    {
        Label::find($LabelId)->update([
            'name'=>$request->name,
        ]);

        return redirect()->back()->with('success','Changes saved !');
    }
    public function DeleteLabel($LabelId)
    {
        Label::destroy($LabelId);
        return redirect()->back()->with('success','Changes saved !');
    }
    public function LogsIndex()
    {
        return view('Dashboard.logs')->with([
            'User'=>User::find(session('UserId')),
            'PageTitle'=>'View Logs',
            'Logs'=>UserLog::all(),
        ]);
    }
}
