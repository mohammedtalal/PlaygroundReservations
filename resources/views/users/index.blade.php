@extends('master')
@section('header')
<h2>asda</h2>
@endsection

@section('contents')
	
	<div class="col-md-12" style="margin-top: 20px">
		<a href="" class="btn btn-primary btn-flat">Add New User</a>	
		<hr>
		<!-- <input class="form-control" style="float:right; width: 35%" type="text" id="search" placeholder="Searching.."> -->
	</div>

	<table class="table table-responsive" id="categories-table">
	    <thead>
	        <th>#</th>
	        <th>Address</th>
	        <th>Phone</th>
	        <th>Company Name</th>
	        <th>Latitude</th>
	        <th>Longtude</th>
	        <th colspan="3">Action</th>
	    </thead>
	    <tbody>
	    
	   <!-- foreach -->
	        <tr>
	            <td>2</td>
	            <td>asdfasdf</td>
	            <td>asdf</td>
	            <td>safsadf</td>
	            <td>fsgdsf</td>
	            <td>fgsdfgsdf</td>

	            <td>
	                
	               <div class='btn btn-group'>
	                    <!-- <a href="" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> -->
	                    <a href="" class='btn btn-info btn-xs'><i class="glyphicon glyphicon-edit"></i></a>

	                    <form  method="post" action="">
							{{ csrf_field() }}
	                    	<button type="submit" class='btn btn-danger btn-xs'>
	                    		<i class="glyphicon glyphicon-trash"></i>
	                    	</button >
	                    	<input type="hidden" name="_method" value="DELETE">
	                	</form>
	                </div>
	               
	            </td>
	        </tr>
			
			<!-- endforeach -->
	    </tbody>
	</table>
@endsection