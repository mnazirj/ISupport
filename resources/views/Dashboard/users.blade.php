@extends('layout.main')

@section('content')
    <table class="table table-hover">
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>email</th>
            <th>Role</th>
            <th>created at</th>
        </thead>
        <tbody>
            @foreach ($Users as $User)
                @if($User->id == session('UserId'))
                    <tr class="fst-italic fw-normal text-secondary">
                        <td>>>You</td>
                        <td>{{$User->name}}</td>
                        <td>{{$User->email}}</td>
                        <td>{{$User->Role->name}}</td>
                        <td>{{$User->created_at}}</td>
                    </tr>
                @else
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$User->name}}</td>
                        <td>{{$User->email}}</td>
                        <td>{{$User->Role->name}}</td>
                        <td>{{$User->created_at}}</td>
                    </tr>
                @endif
               
            @endforeach
        </tbody>
    </table>
@endsection