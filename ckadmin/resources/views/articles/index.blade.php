@extends('layouts.app')
@section('breadcrumb')
<!-- leftside content header -->
<div class="content-header">
	<div class="leftside-content-header">
	    <ul class="breadcrumbs">
	        <li><i class="fa fa-pie-chart" aria-hidden="true"></i><a href="{{ route('dashboard') }}">Dashboard</a></li>
	        <li><a href="{{ route('articles.index') }}"> Articles Lists</a></li>
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
			<b> Article Lists </b>
		</h4>
		<span class="pull-right">
			<a href="{{ route('articles.create')}}" class="btn btn-success btn-right-side"><i class="fa fa-plus"></i></a>
		</span>
		 <div class="panel">
            <div class="panel-content">
				 <div class="table-responsive">
                    <table id="basic-table" class="data-table table table-striped nowrap table-hover" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th> # </th>
                            <th> Ttilte </th>
                            <th> Img </th>
                            <th> Status </th>
                           	<th> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach ($article as $data)
                        	<tr>
                                <td> {{ $i }} </td>
                                <td> {{ str_limit($data->title, 35) }} </td>
                            	<td> <img src="{{ $data->image }}" alt="No Image" width="50" height="50"> </td>
                                <td> {{ $data->status == "1" ? "Active" : "In-Active" }} </td>
                                <td> 
                                <a class="btn btn-transparent" title="" data-original-title="Edit" href="{{ route('articles.edit',$data->id) }}"><i class="fa fa-pencil"></i></a>
                                 {!! Form::open(['method' => 'DELETE','route' => ['articles.destroy', $data->id],'style'=>'display:inline']) !!}
                                    <button class="btn btn-transparent" title="" data-original-title="Delete"><i class="fa fa-times"></i></button>
                                {!! Form::close() !!}
                                </td>
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
@section('script')
    <!--dataTable-->
    <script src="{{ asset('vendor/data-table/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/data-table/media/js/dataTables.bootstrap.min.js') }}"></script>
    <!--Examples-->
    <script src="{{ asset('js/examples/tables/data-tables.js') }}"></script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/data-table/media/css/dataTables.bootstrap.min.css') }}">
@stop