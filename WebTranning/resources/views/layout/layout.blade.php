<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('name-page')

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
    
    <!-- DataTables
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}../../">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}"> -->
    <!-- Theme style -->
    <!-- <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}"> -->
    <link href="{{asset('assets/css/index.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>
</head>

<body>
    <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding:0; margin-left:300px ;">
            <div class="container-fluid" style="padding-left:0;background-color:lightgrey ;">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#NavCollapse" aria-controls="NavCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="NavCollapse" style="padding-left: 0;">
                    <ul class="navbar-nav">
                        <li class="nav-item d-none d-sm-inline-block" id="{{ (request()->segment(1) == 'product') ? 'active' : '' }}">
                            <a href="{{route('list-product')}}" class="nav-link">Sản phẩm</a>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block" id="{{ (request()->segment(1) == 'customer') ? 'active' : '' }}">
                            <a href="{{route('list-customer')}}" class="nav-link">Khách hàng</a>
                        </li>
                        <li class="nav-item d-none d-sm-inline-block" id="{{ (request()->segment(1) == 'user') ? 'active' : '' }}">
                            <a href="{{route('list-user')}}" class="nav-link">Users </a>
                        </li>
                    </ul>

                    <div class="me-auto"></div>
                    <ul class="navbar-nav" style="position: absolute;right: 0;margin-right: 20px;">
                        <li class="nav-item">
                            <a class="nav-link menutext active" href="#"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menutext" href="{{route('logout')}}">{{Auth()->user()->name}}</a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
        <div class="row" style="margin:5px ;">
            <div class="col">
                @yield('name-content')
            </div>
            <div class="col-1">
                <a href="">{{ ucfirst(request()->segment(1)) }}</a>
            </div>
        </div>
        
        <div style="height:10px;background-color:lightblue ;"></div>
        
        <div style="margin: 20px;">
            @yield('main-content')
        </div>
    </div>
</body>

@yield('js-content')
<script src="//cdn.ckeditor.com/4.20.0/basic/ckeditor.js"></script>