@extends('layouts.app')
@section('breadcrumb')
<!-- leftside content header -->
<div class="content-header">
	<div class="leftside-content-header">
	    <ul class="breadcrumbs">
	        <li><i class="fa fa-pie-chart" aria-hidden="true"></i><a href="{{ route('dashboard') }}">Dashboard</a></li>
	        <li><a href="{{ route('infograph.index') }}"> Add Infograph </a></li>
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
			<b>Add Infograph </b>
		</h4>
		<span class="pull-right">
			<a href="{{ route('infograph.index')}}" class="btn btn-success btn-right-side"><i class="fa fa-list"></i></a>
		</span>
		 <div class="panel">
            <div class="panel-content">
				<form action="{{ route('infograph.store') }}" method="post" class="form-horizontal form-stripe" enctype="multipart/form-data">
					{{ csrf_field() }}
					 @include('infograph._form')
                </form>
            </div>
        </div>
	</div>
</div>
@stop