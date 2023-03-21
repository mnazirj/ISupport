@extends('layout.main')

@section('content')
    <button class="btn btn-danger float-end mb-4 me-3" data-bs-toggle="modal" data-bs-target="#create-label">Create new label</button>
    @if (session('success'))
            <div class=" alert alert-success float-start w-100 text-center">
                <span>{{session('success')}}</span>
            </div>
        @endif
    <table class="table table-hover">
        <thead>
            <th>#</th>
            <th>Name</th>
            <th colspan="2">Option</th>
            
        </thead>
        <tbody>
            @foreach ($Labels as $Label)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td class="col-10">{{$Label->name}}</td>
                        <td class="col-1">
                        
                            <a type="button" data-bs-toggle="modal" data-bs-target="#edit-label-{{$Label->id}}">
                                <span class="material-symbols-outlined">
                                    edit
                                </span>
                              </a>
                        </td>
                        <td>
                            <a type="button" class="text-danger" data-bs-toggle="modal" data-bs-target="#delete-label-{{$Label->id}}">
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
                            </a>
                            
                        </td>
                    </tr>               
            @endforeach
        </tbody>
    </table>
    @foreach ($Labels as $Label)
         <!-- Modal Edit Label -->
         <div class="modal fade" id="edit-label-{{$Label->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit {{$Label->name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('label.edit',$Label->id)}}">
                        @csrf
                        <label class="form-label">Label Name</label>
                        <input type="text" name="name" placeholder="Enter label name" class="form-control" value="{{$Label->name}}" required>
                        <button type="submit" class="btn btn-primary mt-4 float-end">Edit</button>
                    </form>
                </div>
            </div>
            </div>
        </div>

        <!-- Modal Delete Label -->
        <div class="modal fade" id="delete-label-{{$Label->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete {{$Label->name}}?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete {{$Label->name}}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <a href="{{route('label.delete',$Label->id)}}" class="btn btn-success text-white">Yes</a>
                </div>
            </div>
            
            </div>
        </div>
    @endforeach

    <!-- Modal Create Label -->
    <div class="modal fade" id="create-label" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create new label</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('label.new')}}">
                    @csrf
                    <label class="form-label">Label Name</label>
                    <input type="text" name="name" placeholder="Enter label name" class="form-control" required>
                    <button type="submit" class="btn btn-success mt-4 float-end">Create</button>
                </form>
            </div>
        </div>
        </div>
    </div>

        
@endsection