@extends('layout.main')

@section('content')
    @if($User->Role->name == 'Regular')

        <button type="button" class="btn btn-danger mb-5 float-end" data-bs-toggle="modal" data-bs-target="#create">
            Create new ticket
          </button>
        @if (session('success'))
            <div class=" alert alert-success float-start w-100 text-center">
                <p>{{session('success')}}</p>
            </div>
        @endif
        <table class="table table-hover table-borderless bg-white">
            <thead>
                <th>#</th>
                <th>Title</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Category</th>
                <th>Label</th>
                <th>Date</th>
            </thead>
            <tbody>
                @if(sizeof($User->Tickets) > 0)
                    @foreach ($User->Tickets as $Ticket)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>
                                <a href="{{route('dash.view_ticket',$Ticket->id)}}" class="text-decoration-none">
                                    {{$Ticket->title}}
                                </a>
                        </td>
                            <td>
                                <span @class([
                                    'text-success fw-bold'=> $Ticket->status == 'Open',
                                    'text-warning fw-bold'=> $Ticket->status == 'Pending',
                                    'text-secondary fw-bold'=> $Ticket->status == 'Closed',
                                    'text-info fw-bold'=> $Ticket->status == 'Answered',
                                ])>
                                    {{$Ticket->status}}
                                </span>
                            </td>
                            <td>
                                <span @class([
                                    'text-secondary fw-bold'=>$Ticket->priority =='LOW',
                                    'text-warning fw-bold'=>$Ticket->priority == 'MEDIUM',
                                    'text-danger fw-bold'=>$Ticket->priority == 'HIGH',
                                ])>
                                    {{$Ticket->priority}}
                                </span>
                            </td>
                            <td>
                                @foreach ($Ticket->Category as $Category)
                                <span class="text-success">{{$Category->name}}</span> <br>
                                @endforeach
                                
                            </td>
                            <td>
                                @foreach ($Ticket->Label as $Label)
                                <span class="text-secondary">{{$Label->name}}</span> <br>
                                @endforeach
                            </td>
                            <td>{{date_format($Ticket->created_at,'Y-m-d h:i a')}}</td>
                        </tr>
                    @endforeach
                @endif
                
            </tbody>
        </table>
        @if (sizeof($User->Tickets) == 0)
            <p class="alert alert-secondary text-center fw-bold w-25 mx-auto">There is no tickers</p>
        @endif

        <!-- Modal -->
        <div class="modal fade" id="create" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create new ticket</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('dash.post.tickets')}}" enctype="multipart/form-data">
                            @csrf
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter ticket title" required>
                            <label class="mt-2">Message</label>
                            <textarea name="description" class="form-control" rows="5" required></textarea>
                            <label class="mt-2">Labels</label>
                            <select class="form-select form-select-md mb-3" name="label[]" multiple required>
                                <option selected disabled>Select label</option>
                                @foreach ($Labels as $Label)
                                <option value="{{$Label->name}}">{{$Label->name}}</option>
                            @endforeach
                              </select>
                            <label>Categories</label>
                            <select class="form-select form-select-md mb-3" name="category[]" multiple required>
                                <option selected disabled>Select category</option>
                                @foreach ($Categories as $Category)
                                    <option value="{{$Category->name}}">{{$Category->name}}</option>
                                @endforeach
                            </select>
                            <label>Proiority</label>
                            <select class="form-select form-select-md mb-3" name="priority" required>
                                <option selected value="LOW">LOW</option>
                                <option value="MEDIUM">MEDIUM</option>
                                <option value="HIGH">HIGH</option>
                            </select>
                            <label class="form-label">File/s</label>
                            <input class="form-control" type="file" name="file[]" multiple>
                            <button type="submit" class="btn btn-success mt-3 w-100">Send</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    @elseif($User->Role->name == 'Agent')
        <table class="table table-hover table-borderless bg-white">
            <thead>
                <th>#</th>
                <th>Title</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Category</th>
                <th>Label</th>
                <th>Date</th>
            </thead>
            <tbody>
                @if(sizeof($Tickets) > 0)
                    @foreach ($Tickets as $Ticket)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>
                                <a href="{{route('dash.view_ticket',$Ticket->id)}}" class="text-decoration-none">
                                    {{$Ticket->title}}
                                </a>
                        </td>
                            <td>
                                <span @class([
                                    'text-success fw-bold'=> $Ticket->status == 'Open',
                                    'text-warning fw-bold'=> $Ticket->status == 'Pending',
                                    'text-secondary fw-bold'=> $Ticket->status == 'Closed',
                                    'text-info fw-bold'=> $Ticket->status == 'Answered',
                                ])>
                                    {{$Ticket->status}}
                                </span>
                            </td>
                            <td>
                                <span @class([
                                    'text-secondary fw-bold'=>$Ticket->priority =='LOW',
                                    'text-warning fw-bold'=>$Ticket->priority == 'MEDIUM',
                                    'text-danger fw-bold'=>$Ticket->priority == 'HIGH',
                                ])>
                                    {{$Ticket->priority}}
                                </span>
                            </td>
                            <td>
                                @foreach ($Ticket->Category as $Category)
                                <span class="text-success">{{$Category->name}}</span> <br>
                                @endforeach
                                
                            </td>
                            <td>
                                @foreach ($Ticket->Label as $Label)
                                <span class="text-secondary">{{$Label->name}}</span> <br>
                                @endforeach
                            </td>
                            <td>{{date_format($Ticket->created_at,'Y-m-d h:i a')}}</td>
                        </tr>
                    @endforeach
                @endif
                
            </tbody>
        </table>
        @if (sizeof($User->Tickets) == 0)
            <p class="alert alert-secondary text-center fw-bold w-25 mx-auto">There is no tickers</p>
        @endif
    @elseif ($User->Role->name == 'Administrator')
        <table class="table table-hover table-borderless bg-white">
            <thead>
                <th>#</th>
                <th>Title</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Category</th>
                <th>Label</th>
                <th>Date</th>
                <th>Sender</th>
                <th>Assigned To</th>
                <th colspan="2">Options</th>
            </thead>
            <tbody>
                @if(sizeof($Tickets) > 0)
                    @foreach ($Tickets as $Ticket)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>
                                <a href="{{route('dash.view_ticket',$Ticket->id)}}" class="text-decoration-none">
                                    {{$Ticket->title}}
                                </a>
                        </td>
                            <td>
                                <span @class([
                                    'text-success fw-bold'=> $Ticket->status == 'Open',
                                    'text-warning fw-bold'=> $Ticket->status == 'Pending',
                                    'text-secondary fw-bold'=> $Ticket->status == 'Closed',
                                    'text-info fw-bold'=> $Ticket->status == 'Answered',
                                ])>
                                    {{$Ticket->status}}
                                </span>
                            </td>
                            <td>
                                <span @class([
                                    'text-secondary fw-bold'=>$Ticket->priority =='LOW',
                                    'text-warning fw-bold'=>$Ticket->priority == 'MEDIUM',
                                    'text-danger fw-bold'=>$Ticket->priority == 'HIGH',
                                ])>
                                    {{$Ticket->priority}}
                                </span>
                            </td>
                            <td>
                                @foreach ($Ticket->Category as $Category)
                                <span class="text-success">{{$Category->name}}</span> <br>
                                @endforeach
                                
                            </td>
                            <td>
                                @foreach ($Ticket->Label as $Label)
                                <span class="text-secondary">{{$Label->name}}</span> <br>
                                @endforeach
                            </td>
                            <td>{{date_format($Ticket->created_at,'Y-m-d h:i a')}}</td>
                            <td><span class="fst-italic">{{$Ticket->User->name}}</span></td>
                            <td>
                                @if($Ticket->assigned_user_id == NULL)
                                <span class="fst-italic text-secondary">Not assigend</span>
                                @else
                                <span class="fst-italic">{{$Ticket->Assigned->name}}</span>
                                @endif
                                
                            </td>
                            <td>
                                <a type="button" data-bs-toggle="modal" data-bs-target="#edit-ticket-{{$Ticket->id}}">
                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                  </a>
                            </td>
                            <td>
                                <a type="button" class="text-danger" data-bs-toggle="modal" data-bs-target="#delete-ticket-{{$Ticket->id}}">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </a>
                                
                            </td>
                        </tr>
                    @endforeach
                @endif
                
            </tbody>
        </table>
        @if (sizeof($Tickets) == 0)
            <p class="alert alert-secondary text-center fw-bold w-25 mx-auto">There is no tickers</p>
        @else
            @foreach ($Tickets as $Ticket)
                <!-- Modal Edit Cate -->
                <div class="modal fade" id="edit-ticket-{{$Ticket->id}}" tabindex="-1"  aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit {{$Ticket->title}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('dash.ticket.edit',$Ticket->id)}}">
                                @csrf
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    @if($Ticket->status == 'Open')
                                    <option value="Open" selected disabled>Open</option>
                                    @elseif ($Ticket->status == 'Closed')
                                    <option value="Close" selected disabled>Closed</option>
                                    @elseif ($Ticket->status == 'Pending')
                                    <option value="Pending" selected disabled>Pending</option>
                                    @else
                                    <option value="Answered" selected disabled>Answered</option>
                                    @endif
                                    <option value="Open">Open</option>
                                    <option value="Close">Closed</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Answered">Answered</option>
                                    
                                    
                                </select>
                                <label class="form-label">Assign To</label>
                                <select class="form-select" name="support">
                                    @foreach ($AssignUser as $Support)
                                        <option value="{{$Support->id}}">{{$Support->name}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary mt-4 float-end">Edit</button>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Modal Delete Cate -->
                <div class="modal fade" id="delete-ticket-{{$Ticket->id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete {{$Ticket->title}}?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete {{$Ticket->title}}?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                            <a href="{{route('dash.ticket.delete',$Ticket->id)}}" class="btn btn-success text-white">Yes</a>
                        </div>
                    </div>
                    
                    </div>
                </div>
            @endforeach
        @endif
    @endif
    
    
@endsection