<!doctype html>
<html lang="en" class="fixed right-sidebar-opened">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title> Quizard Admin </title>
    @include('common.favicon')
    <!--load progress bar-->
    <script src="{{ asset('vendor/pace/pace.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('vendor/pace/pace-theme-minimal.css') }}"/>

    <!--BASIC css-->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- ========================================================= -->
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/animate.css/animate.css') }}">
    <!--SECTION css-->
    <!-- ========================================================= -->
    <!--Notification msj-->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
    <!--Magnific popup-->
    <link rel="stylesheet" href="{{ asset('vendor/magnific-popup/magnific-popup.css') }}">
    <!--TEMPLATE css-->
    <!-- ========================================================= -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @yield('css')
     <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>
    </script>
</head>

<body>
    <div class="wrap" id="app" data-host="{{url('/')}}" ref="host" data-value="sdfsas">
        <!-- page HEADER -->
        <!-- ========================================================= -->
        @include('common.page_header')
        <!-- page BODY -->
        <!-- ========================================================= -->
        <div class="page-body">
            <!-- LEFT SIDEBAR -->
            <!-- ========================================================= -->
            @include('common.left_sidebar')
            <!-- CONTENT -->
            <!-- ========================================================= -->
            <div class="content">
                <!--for validation error start-->
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('flash_' . $msg))
                        <div class="row" id="alert-container">
                            <div class="col-sm-12">
                                <div class="panel">
                                    <div class="panel-content">
                                        <div id="custom-alert" class="alert alert-{{ $msg }} m-none">
                                            <a href="#" class="close" data-dismiss="alert"><i class="fa fa-close mr-sm text-md"></i></a>
                                            {{ Session::get('flash_' . $msg) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <!--for validation error end-->
              @yield('content')
            </div>
            <!-- RIGHT SIDEBAR -->
            <!-- ========================================================= -->
             {{-- @include('common.right_sidebar') --}}
            <!--scroll to top-->
            <a href="#" class="scroll-to-top"><i class="fa fa-angle-double-up"></i></a>
        </div>
    </div>
    <!--BASIC scripts-->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <!-- ========================================================= -->
    <script src="{{ asset('vendor/nano-scroller/nano-scroller.js') }}"></script>
    <!--TEMPLATE scripts-->
    <!-- ========================================================= -->
    <script src="{{ asset('js/template-script.min.js') }}"></script>
    <script src="{{ asset('js/template-init.min.js') }}"></script>
    <!-- SECTION script and examples-->
    <!-- =========================================================  -->
    <!--Notification msj-->
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
    <!--morris chart-->
    <script src="{{ asset('vendor/chart-js/chart.min.js') }}"></script>
    <!--Gallery with Magnific popup-->
    <script src="{{ asset('vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <!--Examples-->
     @yield('script')
</body>
</html>