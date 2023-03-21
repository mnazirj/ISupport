@extends('layout.main')

@section('body')
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-off-white">
        <div class="card border-0 w-25 py-3">
            <div class="card-header bg-white border-0">
                <h5 class="text-center">{{env('APP_NAME')}}</h5>
            </div>
            <div class="card-body">
                @if (session('LoginError'))
                <p class="alert alert-danger">
                    {{session('LoginError')}}
                </p>
                @endif
                
                <form method="POST" action="{{route('login')}}">
                    @csrf
                        <label class="mb-1 text-red">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                        <label class="mb-1 mt-3 fs-6 text-red">Password</label>
                        <input type="password" name="password" class="form-control" required>
                        <button type="submit" class="btn btn-danger mt-3 w-100">Login</button>
                </form>
            </div>
            <div class="card-footer bg-white border-0">
                <a class="float-end text-decoration-none fs-6" href="#">Forget password?</a>
            </div>
        </div>
    </div>
@endsection