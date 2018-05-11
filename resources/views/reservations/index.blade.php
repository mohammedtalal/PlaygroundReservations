@extends('panel.index')
@section('header')
 <h1>My Playgrounds</h1>
@stop
@section('contents')
	
	<div class="col-md-12" style="margin-top: 20px">
		<a href="{{ route('reservation.create') }}" class="btn btn-primary btn-flat">New Reservation</a>	
		<hr>
	</div>

	<table class="table table-responsive" id="categories-table">
	    <thead>
	        <th>#</th>
	        <th>name</th>
	        <th>address</th>
	        <th>Owner name</th>
	        <th>Owner phone</th>
	        <th colspan="3">Action</th>
	    </thead>
	    <tbody>
	    
	   <!-- foreach -->
	   @foreach($playgrounds as $key => $playground)
	        <tr>
	            <td>{{ ++$key }}</td>
	            <td>{{ $playground->name }}</td>
	            <td>{{ $playground->address }}</td>
	            <td>{{ $playground->user->name }}</td>
	            <td>{{ $playground->user->phone }}</td>

	            <td>
	               <div class='btn btn-group'>
	                    

	                    <a href="{{ route('reservation.view',$playground->id) }}" class='btn btn-primary btn-xs'>
	                    	<span>View Reservations</span>
	                    </a>

	                </div>
	            </td>
	        </tr>
			@endforeach
			<!-- endforeach -->
	    </tbody>
	</table>
@endsection