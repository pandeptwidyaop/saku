@php
  $name = '';
  $role = '';
  $config = Auth::user()->config();
  if (Auth::user()->role == 'root') {
    $name = Auth::user()->username;
    $role = 'root';
  }else {
    $name = Auth::user()->Profile()->name;
    $role = Auth::user()->Position();
  }
@endphp
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('saku.title')}}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{url('bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  @yield('css')
  <link rel="stylesheet" href="{{url('dist/css/AdminLTE.min.css')}}">

  <link rel="stylesheet" href="{{url('dist/css/skins/_all-skins.min.css')}}">
  <link rel="icon" href="{{asset(config('saku.default.logo'))}}">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition {{$config != null ? $config->theme : config('saku.default.theme')}} sidebar-top-nav">
<div class="wrapper">

  <header class="main-header">
    <a href="{{Help::url()}}" class="logo">
      <span class="logo-mini"><b>SA</b>KU</span>
      <span class="logo-lg"><b>{{config('saku.name')}}</b> <small>{{config('saku.version')}}</small></span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          {{-- <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the messages -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <!-- User Image -->
                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <!-- Message title and timestamp -->
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <!-- The message -->
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                </ul>
                <!-- /.menu -->
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- /.messages-menu -->

          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- Inner Menu: contains the notifications -->
                <ul class="menu">
                  <li><!-- start notification -->
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <!-- end notification -->
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks Menu -->
          <li class="dropdown tasks-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- Inner menu: contains the tasks -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <!-- Task title and progress text -->
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <!-- The progress bar -->
                      <div class="progress xs">
                        <!-- Change the css width attribute to simulate progress -->
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li> --}}
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{Help::img(Auth::user()->picture)}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{$name}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="{{Help::img(Auth::user()->picture)}}" class="img-circle" alt="User Image">
                <p>
                  {{Auth::user()->username}} - {{ucfirst($role)}}
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{Help::url('akun')}}" class="btn btn-default btn-flat">Akun</a>
                </div>
                <div class="pull-right">
                  <a href="{{Help::js()}}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">Logout</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
              </li>
            </ul>
          </li>
          {{-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> --}}
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{Help::img(Auth::user()->picture)}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{$name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> {{ucfirst($role)}}</a>
        </div>
      </div>
      @include('layouts.sidebar')
    </section>
  </aside>
  @yield('content')
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      {{config('saku.version')}}
    </div>
    <strong>Copyright &copy; 2016 - {{date('Y',strtotime(\Carbon\Carbon::now()))}} <a href="https://himaprodisi.or.id">Himaprodi SI</a>.</strong> All rights reserved. Design by AdminLTE
  </footer>
  <div class="control-sidebar-bg"></div>
</div>
<script src="{{url('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<script src="{{url('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{url('dist/js/app.min.js')}}"></script>
@stack('js')
</body>
</html>
