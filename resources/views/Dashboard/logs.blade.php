@extends('layout.main')

@section('content')
    @foreach ($Logs as $Log)
        <div class="card border-0">
            <div class="card-body">
                <div class="py-3">
                    <i @class([
                        'float-start',
                        'fas',
                        'fa-plus text-success'=>$Log->Action == 'Create',
                        'fa-wrench text-warning'=>$Log->Action == 'Edited',
                        'fa-comment text-danger '=>$Log->Action == 'Replied',
                        'fa-times text-danger '=>$Log->Action == 'Closed',
                        'mt-1'
                    ])></i>
                    <p class="float-start ms-3"> <span class="fst-italic text-primary me-1">{{$Log->User->name}}</span> {{$Log->Action}} <span class="text-secondary ms-1">{{$Log->Ticket->title}} </span>Ticket</p>
                    <p class="float-end fst-italic text-secondary">
                        <i class="fas fa-clock text-danger"></i>
                        {{date_format($Log->created_at,'Y-m-d h:i A')}}</p>
                </div>
                
            </div>
        </div>
    @endforeach
@endsection