@extends('layout.main')

@section('content')
    <button class="btn btn-danger float-end mb-4 me-3" data-bs-toggle="modal" data-bs-target="#create-cate">Create new category</button>
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
            @foreach ($Categories as $Category)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td class="col-10">{{$Category->name}}</td>
                        <td class="col-1">
                        
                            <a type="button" data-bs-toggle="modal" data-bs-target="#edit-cate-{{$Category->id}}">
                                <span class="material-symbols-outlined">
                                    edit
                                </span>
                              </a>
                        </td>
                        <td>
                            <a type="button" class="text-danger" data-bs-toggle="modal" data-bs-target="#delete-cate-{{$Category->id}}">
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
                            </a>
                            
                        </td>
                    </tr>               
            @endforeach
        </tbody>
    </table>
    @foreach ($Categories as $Category)
         <!-- Modal Edit Cate -->
         <div class="modal fade" id="edit-cate-{{$Category->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit {{$Category->name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('cate.edit',$Category->id)}}">
                        @csrf
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" placeholder="Enter category name" class="form-control" value="{{$Category->name}}" required>
                        <button type="submit" class="btn btn-primary mt-4 float-end">Edit</button>
                    </form>
                </div>
            </div>
            </div>
        </div>

        <!-- Modal Delete Cate -->
        <div class="modal fade" id="delete-cate-{{$Category->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete {{$Category->name}}?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete {{$Category->name}}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    <a href="{{route('cate.delete',$Category->id)}}" class="btn btn-success text-white">Yes</a>
                </div>
            </div>
            
            </div>
        </div>
    @endforeach

    <!-- Modal Create Cate -->
    <div class="modal fade" id="create-cate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create new category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('cate.new')}}">
                    @csrf
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" placeholder="Enter category name" class="form-control" required>
                    <button type="submit" class="btn btn-success mt-4 float-end">Create</button>
                </form>
            </div>
        </div>
        </div>
    </div>

        
@endsection