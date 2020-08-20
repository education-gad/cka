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