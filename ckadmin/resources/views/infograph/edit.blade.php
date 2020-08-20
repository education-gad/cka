@extends('layouts.app')
@section('breadcrumb')
<!-- leftside content header -->
<div class="content-header">
	<div class="leftside-content-header">
		<ul class="breadcrumbs">
			<li><i class="fa fa-pie-chart" aria-hidden="true"></i><a href="{{ route('dashboard') }}">Dashboard</a></li>
			<li><a href="{{ route('infograph.index') }}">Edit InfoGraph</a></li>
		</ul>
	</div>
</div>
@stop
@section('content')

<div class="row">
	<div class="col-md-8 col-md-offset-2">
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
			<b> Edit InfoGraph </b>
		</h4>
		<span class="pull-right">
			<a href="{{ route('infograph.index')}}" class="btn btn-success btn-right-side"><i class="fa fa-list"></i></a>
		</span>
		<div class="panel">
			<div class="panel-content">
			{!! Form::model($infograph, ['route'=>['infograph.update', $infograph->id], 'method' => 'PUT', 'class' => 'form-horizontal form-stripe', 'enctype' => 'multipart/form-data']) !!}
					<div class="form-group">
						<label for="catname" class="col-sm-2 control-label"> Title </label>
						<div class="col-sm-4">
							{{Form::text('title',null,array('class' => 'form-control'))}}
						</div>
					</div>

					<div class="form-group">
						<label for="catname" class="col-sm-2 control-label"> Description </label>
						<div class="col-sm-4">
							{{Form::textarea('description',null,array('class' => 'form-control', 'rows' => '3'))}}
						</div>
					</div>

						<div class="form-group">
					    <label class="col-sm-2 control-label"> Image </label>
					    <div class="col-sm-4">
					    	
				            <div class="panel panel-default">
				                <div class="file-tab panel-body">
				                	<img id="output" src="{{ $infograph->image }}" alt="No Image" width="150" height="150">
				                </div>
				            </div>
				            <div class="image">
								<input type="file" name="image" onchange="return previewImage(event)" value="{{ $infograph->image }}"> 
								<input type="hidden" name="image_hidden" value="{{ $infograph->image }}">
					    	</div>
					    </div>
					</div>

					<div class="form-group">
						<label for="status" class="col-sm-2 control-label"> Articles Status </label>
						<div class="col-sm-4">
							<select name="status" id="select2-example-basic" class="form-control" style="width: 100%">
								<option value=""> Select Status </option>
								<option value="1" selected=""> Active </option>
								<option value="0"> In-Active </option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-2">
							<button type="submit" class="btn btn-primary">
								Update
							</button>
						</div>
					</div>
			{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@stop

@section('script')

 <script>
 	function previewImage(event) {
 		var output = document.getElementById('output');
 		output.src = URL.createObjectURL(event.target.files[0]);
 	};
</script>

@stop