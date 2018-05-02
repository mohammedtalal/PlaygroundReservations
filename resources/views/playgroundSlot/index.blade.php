@extends('panel.index')
@section('header')
 <h1>All Schedules</h1>
@stop
@section('contents')
	
	<div class="col-md-12" style="margin-top: 20px">
		<a href="{{ route('playgrounds.create') }}" class="btn btn-primary btn-flat">Add New Playground</a>	
		<hr>
	</div>

	

@endsection