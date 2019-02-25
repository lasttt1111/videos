@includeIf("admin/{$module}_{$function}")
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ $title }}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('/admin/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/admin/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/admin/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/admin/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/admin/css/_all-skins.min.css') }}">
  <link rel="icon" href="{{ asset('favicon.png') }}">
  @yield('css-file')
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <a href="{{ route('site.index') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>{{ __('VSS') }}</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{{ __('Video') }}</b> {{ __('sharing site') }}</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">{{ __('Điều hướng') }}</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ Auth::user()->avatar }}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="{{ Auth::user()->avatar }}" class="img-circle" alt="User Image">

                  <p>
                   {{ Auth::user()->name }}
                    <small>{{ Auth::user()->created_at->format('Y-m-d') }}</small>
                  </p>
                </li>
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{ route('site.user.profile', ['alias' => Auth::user()->alias]) }}" class="btn btn-default btn-flat">{{ __('Thông tin') }}</a>
                  </div>
                  <div class="pull-right">
                    <a href="{{ route('site.logout') }}" class="btn btn-default btn-flat">{{ __('Thoát') }}</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    @includeIf('admin/menu')
    <div class="content-wrapper">
      <section class="content-header">
        <h1>@yield('module')<small>@yield('function')</small>
        </h1>
      </section>
      <section class="content">
        @yield('content')
      </section>

    </div>

    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
      </div>
      <strong>Copyright &copy; {{ date('Y') }}</strong>
    </footer>

  </div>
  @yield('custom-style')
  <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
  <script src="{{ asset('admin/js/jquery-ui.min.js') }}"></script>
  @yield('js-file')
  <script>
    $.widget.bridge('uibutton', $.ui.button);
    $(document).ready(function(){
      @yield('ready-script')
      $('li[data-module="{{ $module }}"]').addClass('active');
      $('li[data-module="{{ $module }}"]').find('li[data-function="{{ $function }}"]').addClass('active');
    })
  </script>
  <script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('admin/js/adminlte.min.js') }}"></script>
</body>
</html>
