@extends('layouts.app')
@section('breadcrumb')
<div class="content-header">
    <!-- leftside content header -->
    <div class="leftside-content-header">
        <ul class="breadcrumbs">
            <li><i class="fa fa-home" aria-hidden="true"></i><a href="#">Dashboard</a></li>
        </ul>
    </div>
</div>
@stop
@section('content')
<div class="row animated fadeInUp">
    <div class="col-sm-12 col-lg-9">
        <div class="row">
            <!-- =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= -->
            <!--WIDGETBOX-->
            <div class="col-sm-12 col-md-4">
                <div class="panel widgetbox wbox-2 bg-scale-0">
                    <a href="#">
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-xs-4">
                                    <span class="icon fa fa-globe color-darker-1"></span>
                                </div>
                                <div class="col-xs-8">
                                    <h4 class="subtitle color-darker-1">Views</h4>
                                    <h1 class="title color-primary"> 154.609</h1>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-sm-12 col-md-4">
                <div class="panel widgetbox wbox-2 bg-lighter-2 color-light">
                    <a href="#">
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-xs-4">
                                    <span class="icon fa fa-user color-darker-2"></span>
                                </div>
                                <div class="col-xs-8">
                                    <h4 class="subtitle color-darker-2">New Users</h4>
                                    <h1 class="title color-w"> 105</h1>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
{{--             <div class="col-sm-12 col-md-4">
                <div class="panel widgetbox wbox-2 bg-darker-2 color-light">
                <a href="#">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-xs-4">
                                <span class="icon fa fa-envelope color-lighter-1"></span>
                            </div>
                            <div class="col-xs-8">
                                <h4 class="subtitle color-lighter-1">New Messages</h4>
                                <h1 class="title color-light"> 124</h1>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            </div> --}}
        </div>
    </div>

</div>
@endsection
@section('script')
 <script src="{{ asset('js/examples/dashboard.js') }}"></script>
@stop