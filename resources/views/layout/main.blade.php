<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$PageTitle}} - {{env('APP_NAME')}}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    @vite(['resources/css/bootstrap.css','resources/css/app.css','resources/js/bootstrap.js'])
    <script src="https://kit.fontawesome.com/cb4e5ea134.js" crossorigin="anonymous"></script>
    
    
</head>
<body>
    @if(session('UserId'))
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 ">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-5 shadow min-vh-100">
                        <a href="/" class="d-flex align-items-center pb-3  mx-auto text-decoration-none">
                            <span class="fs-5 d-none d-sm-inline text-black fw-bold">{{env('APP_NAME')}}</span>
                        </a>
                        
                        <img src="{{asset('img/user.jpg')}}" class="rounded-circle mx-auto" width="150" height="150">
                        
                        <h4 class="mx-auto mt-4">{{$User->name}}</h4>
                        <small class="mx-auto mb-5">{{$User->Role->name}}</small>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start fw-bolder" id="menu">
                            @if($User->Role->name == 'Regular' || $User->Role->name == 'Agent')
                                <li class="nav-item">
                                    <a href="{{route('dash.home')}}" class="nav-link align-middle  px-0">
                                        <span class="material-symbols-outlined">
                                            home_app_logo
                                        </span>
                                        <span class="ms-2 d-none d-sm-inline position-absolute">Home</span>
                                        
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('dash.tickets')}}" class="nav-link px-0 align-middle">
                                        <span class="material-symbols-outlined">
                                            local_activity
                                        </span>
                                        <span class="ms-2 d-none d-sm-inline position-absolute">Tickets</span></a>
                                </li>
                            @elseif ($User->Role->name == 'Administrator')
                                <li class="nav-item">
                                    <a href="{{route('dash.home')}}" class="nav-link align-middle  px-0">
                                        <span class="material-symbols-outlined">
                                            home_app_logo
                                        </span>
                                        <span class="ms-2 d-none d-sm-inline position-absolute">Home</span>
                                        
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('dash.tickets')}}" class="nav-link px-0 align-middle">
                                        <span class="material-symbols-outlined">
                                            local_activity
                                        </span>
                                        <span class="ms-2 d-none d-sm-inline position-absolute">Tickets</span></a>
                                </li>
                                <li>
                                    <a href="{{route('dash.users')}}" class="nav-link px-0 align-middle">
                                        <span class="material-symbols-outlined">
                                            supervisor_account
                                        </span>
                                        <span class="ms-2 d-none d-sm-inline position-absolute">Users</span> </a>
                                </li>
                                <li>
                                    <a href="{{route('dash.logs')}}" class="nav-link px-0 align-middle">
                                        <span class="material-symbols-outlined">
                                            unknown_document
                                        </span>
                                        <span class="ms-2 d-none d-sm-inline position-absolute">Ticket Logs</span> </a>
                                </li>
                                <li>
                                    <a href="{{route('dash.categories')}}" class="nav-link px-0 align-middle">
                                        <span class="material-symbols-outlined">
                                            category
                                        </span>
                                        <span class="ms-2 d-none d-sm-inline position-absolute">Categories</span> </a>
                                </li>
                                <li>
                                    <a href="{{route('dash.labels')}}" class="nav-link px-0 align-middle">
                                        <span class="material-symbols-outlined">
                                            bookmark
                                        </span>
                                        <span class="ms-2 d-none d-sm-inline position-absolute">Labels</span> </a>
                                </li>
                            @endif
                            
                            
                        </ul>
                        
                    </div>
                </div>
                <div class="col py-5 bg-off-white">
                    @yield('content')
                </div>
            </div>
        </div>
        @else
        @yield('body')
    @endif
    
</body>
</html>