<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta-header')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/bower_dev/fontawesome-free/all.min.css')}} ">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('plugins/bower_dev/admin/css/ionicons.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/bower_dev/admin/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="{{ asset('plugins/bower_dev/admin/css/fontSansPro.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    @yield('style')

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.home.index') }}" class="nav-link">Home</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.logout') }}">
                    {{ trans('custome.sign_out') }}
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="" class="brand-link text-center">
            <h3 class="font-weight-bold">
                <b class="brand-text font-weight-bold">{{ trans('custome.admin_lte_3') }}</b>
            </h3>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel my-2 d-flex justify-content-center">
                <div class="info ">
                    <h4><a href="#" class="d-block">{{ auth()->user()->name }}</a></h4>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link text-capitalize">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                {{ trans('custome.manage') }} {{ trans('custome.user') }}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="" class="nav-link text-capitalize">
                            <i class="fab fa-audible nav-icon"></i>
                            <p>
                                {{ trans('custome.manage') }} {{ trans('custome.category') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>{{ trans('custome.list') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categories.create') }}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>{{ trans('custome.create') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="" class="nav-link text-capitalize">
                            <i class="nav-icon fas fa-tshirt"></i>
                            <p>
                                {{ trans('custome.manage') }} {{ trans('custome.products') }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('products.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-list-alt"></i>
                                    <p>{{ trans('custome.list') }} {{ trans('custome.products') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products.create') }}" class="nav-link">
                                    <i class="nav-icon fas fa-plus"></i>
                                    <p>{{ trans('custome.create') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('orders.index') }}" class="nav-link text-capitalize">
                            <i class="nav-icon fab fa-accusoft"></i>
                            <p>
                                {{ trans('custome.manage') }} {{ trans('custome.order') }}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('suggests.index') }}" class="nav-link text-capitalize">
                            <i class="nav-icon fas fa-lightbulb"></i>
                            <p>
                                {{ trans('custome.manage') }} {{ trans('custome.suggest') }}
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.0.2-pre
        </div>
        <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('plugins/bower_dev/admin/js/adminlte.min.js') }}"></script>
<script src="{{ asset('plugins/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('js/admin/admin.js') }}"></script>

@yield('scripts')

</body>
</html>
