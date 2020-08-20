@include('layouts.head')
    <div class="wrap" id="app">
        <!-- page HEADER -->
        <!-- ========================================================= -->
        <div class="page-header">
            @include('layouts.header')
        </div>
        <!-- page BODY -->
        <!-- ========================================================= -->
        <div class="page-body">
            <!-- LEFT SIDEBAR -->
            <!-- ========================================================= -->
            @include('layouts.sidebar')
            <!-- CONTENT -->
            <!-- ========================================================= -->
            <div class="content">
                @include('common.notification')

                @yield('breadcrumb')

                @yield('content')

                @include('layouts.footer')
            </div>
            <!-- CONTENT END-->

        </div>
        <!-- page BODY END-->
    </div>

    @include('layouts.foot')