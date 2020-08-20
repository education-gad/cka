@extends('layouts.app')
@section('breadcrumb')
<!-- leftside content header -->
<div class="content-header">
	<div class="leftside-content-header">
	    <ul class="breadcrumbs">
	        <li><i class="fa fa-pie-chart" aria-hidden="true"></i><a href="{{ route('dashboard') }}">Dashboard</a></li>
	        <li><a href="{{ route('user.page') }}"> Add User </a></li>
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
			<b>Add User </b>
		</h4>
		<span class="pull-right">
			<a href="{{ route('user.list')}}" class="btn btn-success btn-right-side"><i class="fa fa-list"></i></a>
		</span>
		 <div class="panel">
            <div class="panel-content">
				<form action="{{ route('user.register') }}" method="post" class="form-horizontal form-stripe">
					{{ csrf_field() }}
					 @include('articles.user_form')
                </form>
            </div>
        </div>
	</div>
</div>
@stop