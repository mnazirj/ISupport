@extends('layout.main')

@section('content')
    <h4 class="fst-italic fw-light">Viewing Ticket {{$Ticket->title}}</h4>
    @if($Ticket->status != 'Closed' && $Ticket->userId == session('UserId') || $Ticket->assigned_user_id == session('UserId'))
    <a href="{{route('dash.ticket.close',$Ticket->id)}}" class="btn btn-danger text-white float-end">Close Ticket</a>
    <div class="bg-dots-darker rounded-start rounded-end d-flex justify-content-start align-items-center">
        
        <img class="img-fluid rounded-circle ms-4 me-4" src="{{asset('img/user.jpg')}}" width="100">
        <p class="mt-5 w-100">
            @php
                echo nl2br($Ticket->description);
            @endphp
            <br>
            <small class="float-end me-3 fw-light fst-italic">created at : {{date_format($Ticket->created_at,'Y/m/d h:i a')}}</small>
        </p>
        
    </div>
    @foreach ($Ticket->Comments as $Comment)
        @if($Comment->userId != session('UserId'))
            <div class="bg-dots-darker d-flex justify-content-start align-items-center">
                <img class="img-fluid rounded-circle ms-4 me-4" src="{{asset('img/support.jpg')}}" width="100">
                <p class="mt-5 w-100">
                    @php
                        echo nl2br($Comment->comment);
                    @endphp
                    <br>
                    <small class="float-end me-3 fw-light fst-italic">replaied at : {{date_format($Comment->created_at,'Y/m/d h:i a')}}</small><br>
                    <small class="float-end me-3 fw-normal fst-italic">{{$Comment->User->name}}</small>
                </p>
                
            </div>
            @else
            <div class="bg-white d-flex mt-2 rounded shadow justify-content-start align-items-center">
                <img class="img-fluid rounded-circle ms-4 me-4" src="{{asset('img/user.jpg')}}" width="100">
                <p class="mt-5 w-100">
                    @php
                        echo nl2br($Comment->comment);
                    @endphp
                    <br>
                    <small class="float-end me-3 fw-light fst-italic">replaied at : {{date_format($Comment->created_at,'Y/m/d h:i a')}}</small><br>
                    <small class="float-end me-3 fw-normal fst-italic">{{$User->name}}</small>
                </p>
                
            </div>
        @endif
        
    @endforeach
    <div class="mt-5">
        
        <form method="POST" action="{{route('dash.replay',$Ticket->id)}}" enctype="multipart/form-data">
            @csrf
            <textarea class="form-control" name="comment" rows="5" placeholder="Write your replay"></textarea>
            <input type="file" name="file" multiple class="form-control mt-3">
            <button type="submit" class="mt-3 btn btn-primary float-end">Replay</button>
        </form>
    
    </div> 
    @else
    <div class="bg-dots-darker rounded-start rounded-end d-flex justify-content-start align-items-center">
        
        <img class="img-fluid rounded-circle ms-4 me-4" src="{{asset('img/user.jpg')}}" width="100">
        <p class="mt-5 w-100">
            @php
                echo nl2br($Ticket->description);
            @endphp
            <br>
            <small class="float-end me-3 fw-light fst-italic">created at : {{date_format($Ticket->created_at,'Y/m/d h:i a')}}</small>
        </p>
        
    </div>
    @foreach ($Ticket->Comments as $Comment)
        @if($Comment->userId != session('UserId'))
            <div class="bg-dots-darker d-flex justify-content-start align-items-center">
                <img class="img-fluid rounded-circle ms-4 me-4" src="{{asset('img/support.jpg')}}" width="100">
                <p class="mt-5 w-100">
                    @php
                        echo nl2br($Comment->comment);
                    @endphp
                    <br>
                    <small class="float-end me-3 fw-light fst-italic">replaied at : {{date_format($Comment->created_at,'Y/m/d h:i a')}}</small><br>
                    <small class="float-end me-3 fw-normal fst-italic">{{$Comment->User->name}}</small>
                </p>
                
            </div>
            @else
            <div class="bg-white d-flex mt-2 rounded shadow justify-content-start align-items-center">
                <img class="img-fluid rounded-circle ms-4 me-4" src="{{asset('img/user.jpg')}}" width="100">
                <p class="mt-5 w-100">
                    @php
                        echo nl2br($Comment->comment);
                    @endphp
                    <br>
                    <small class="float-end me-3 fw-light fst-italic">replaied at : {{date_format($Comment->created_at,'Y/m/d h:i a')}}</small><br>
                    <small class="float-end me-3 fw-normal fst-italic">{{$User->name}}</small>
                </p>
                
            </div>
        @endif

        
        
    @endforeach
   
    @endif
    @if ($User->Role->name == 'Administrator')
        <div class="mt-5">
            
            <form method="POST" action="{{route('dash.replay',$Ticket->id)}}" enctype="multipart/form-data">
                @csrf
                <textarea class="form-control" name="comment" rows="5" placeholder="Write your replay"></textarea>
                <input type="file" name="file" multiple class="form-control mt-3">
                <button type="submit" class="mt-3 btn btn-primary float-end">Replay</button>
            </form>
        
        </div> 
        @endif
       
@endsection