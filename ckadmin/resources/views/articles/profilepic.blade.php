@extends('layouts.app')
@section('breadcrumb')
<!-- leftside content header -->
<div class="content-header">
	<div class="leftside-content-header">
	    <ul class="breadcrumbs">
	        <li><i class="fa fa-pie-chart" aria-hidden="true"></i><a href="{{ route('dashboard') }}">Dashboard</a></li>
	        <li><a href="{{ route('user.page') }}"> Add Profile Pic </a></li>
	    </ul>
	</div>
</div>
@stop
@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-git">
       <!--SUCCESS-->
        @if (Session::has('success'))           
        <div class="alert alert-success fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
             {!! Session::get('success') !!}
        </div>
        @endif 
    </div>
</div>

<div class="row">
	<div class="col-sm-12">
		<h4 class="section-subtitle">
			<b> Add Profile Pic </b>
		</h4>
		<span class="pull-right">
			<a href="{{ route('user.page')}}" class="btn btn-success btn-right-side"><i class="fa fa-list"></i></a>
		</span>
		 <div class="panel">
            <div class="panel-content">
				<form action="{{ route('save-profilepic.page') }}" method="post" enctype="multipart/form-data" class="form-horizontal form-stripe">
					{{ csrf_field() }}
					 <div class="form-group">
					    <label for="catname" class="col-sm-2 control-label"> Profile Image </label>
					    <div class="col-sm-4">
					        <input type="file" class="form-control" name="profile_image">
					        @if ($errors->has('profile_image'))
					            <label id="profile_image-error" class="error" for="profile_image"> {{ $errors->first('profile_image') }}</label>
					        @endif
					    </div>
					</div>

					<div class="form-group">
					    <div class="col-md-6 col-md-offset-2">
					        <button type="submit" class="btn btn-primary">
					            Upload
					        </button>
					    </div>
					</div>
                </form>
            </div>
        </div>
	</div>
</div>
@stop