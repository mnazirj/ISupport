@extends('layout.main')

@section('content')
<div class="row">
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
        <div class="card border-0">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="mt-2">
                            <p class="text-sm-start mb-0 text-capitalize fw-bold">
                                Total Tickets
                            </p>
                            <h5 class="fw-bold mb-0 text-danger">{{$Tickets}}</h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                         <img src="{{asset('img/ticket.png')}}" width="64" height="64">
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <a class="btn float-end fw-bold">View All</a>
            </div>
        </div>
    </div>

</div>

@endsection