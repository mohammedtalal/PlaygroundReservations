@extends('master')

@section('contents')
	
	<div class="col-md-12" style="margin-top: 20px">
		@include('panel/partials.flashMessage')
		<a href="{{ route('users.create') }}" class="btn btn-primary btn-flat">Add New User</a>	
		<hr>
		<!-- <input class="form-control" style="float:right; width: 35%" type="text" id="search" placeholder="Searching.."> -->
	</div>

	<table class="table table-responsive" id="categories-table">
	    <thead>
	        <th>#</th>
	        <th>name</th>
	        <th>email</th>
	        <th>Type</th>
	        <th colspan="3">Action</th>
	    </thead>
	    <tbody>
	    
	   <!-- foreach -->
	   @foreach($users as $key => $user)
	        <tr>
	            <td>{{ ++$key }}</td>
	            <td>{{ $user->name }}</td>
	            <td>{{ $user->email }}</td>
	            <td>{{ $user->role ? $user->role->name : '-'  }}</td>

	            <td>
	                
	               <div class='btn btn-group'>
	                    
	                    <a href="{{ route('users.edit',$user->id) }}" class='btn btn-info btn-xs'>
	                    	<span>Edit</span>
	                    </a>

	                    <form  method="post" action="{{ route('users.destroy') }}">
							{{ csrf_field() }}
	                    	<button type="submit" class='btn btn-danger btn-xs'>
	                    		<span>Delete</span>
	                    	</button >
	                    	<input type="hidden" name="_method" value="DELETE">
	                	</form>
	                </div>
	               
	            </td>
	        </tr>
			@endforeach
			<!-- endforeach -->
	    </tbody>
	</table>
@endsection