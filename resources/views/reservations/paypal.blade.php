@extends('panel.index')
@section('header')
 <h1>New Reservation</h1>
@stop
@section('contents')
    <div class="col-md-12">
		<form method="POST" action="{{ route('reservation.postPaypal') }}">
			{{ csrf_field() }}

			{{-- left div --}}
			<div class="col-md-10">
				<div class="form-group">
		    		<label class="form-input-label">Please choose playground Name</label>
		    		<select class="form-control" name="playground_id" id="my-playgrounds" >
		    			<option value="#">Playground name..	</option>
		    			@foreach($playgrounds as $playground)
		    				<option value="{{ $playground->id }}">{{ ucfirst($playground->name) }}</option>
		    			@endforeach
		    		</select>
				</div>

				<div class="form-group" id="costDiv">	
		    		<label class="form-input-label">Playground Hour Cost</label>
					<input class="form-control" type="number" name="playground_cost" id="playground_cost" placeholder="playground cost.." readonly="readonly">
				</div>

				<div class="form-group">
			    	<input class="form-control" type="hidden" name="payment_type" id="payment_type" value="1">
		    	</div>
				
				<div class="form-group">	
		    		<label class="form-input-label">Please Select Day to know available times</label>
					<input class="form-control" type="date" name="date" id="date" min="{{ date("Y-m-d") }}">
				</div>
			</div>

	      <div class="col-md-12" style="margin-top:25px " id="slotsDiv">
         	<ul id="slots">
         		{{-- pushe items here --}}
         	</ul>
	      </div>

	        <div class="form-group">
	            <div class="col-md-6">
	                <button type="submit" class="btn btn-primary">
	                    Save 
	                </button>
	            </div>
	        </div>
		</form>
    </div>
@endsection

@section('extra-script')
<script>
$(document).ready(function () {

	// trigger cost of playground based on choosing playground
	$('#my-playgrounds').on('change', function (id) { 
		var id = $(this).val();
		$.get('/admin/cost/'+id, function(data) {
			$('#costDiv').empty();
			$('#costDiv').append('<label class="form-input-label">Playground Hour Cost</label> <input class="form-control" type="number" name="playground_cost" id="playground_cost" value="'+data.cost+'" readonly="readonly">');
		});
	});


	$('#date').on('change', function (id) { 
		var date = $(this).val();
		var id = $('#my-playgrounds  option:selected').val();

		$.get('/admin/available/'+id+'?date='+date, function(data){
			// empty slots with each request 
			$('#slots').empty();
				if (data.length == 0 ) {
					$('#slots').append('<h3 class=""> There is no available hours to reserve it </h3>');
				}
				$.each(data, function(index,slotObj){
					$('#slots').append('<li class="col-md-4"><input class="form-radio-input" type="radio" id="slot_id" name="slot_id"               value="'+slotObj.id+'" /> <label class="form-check-label" id="mm" for="defaultCheck"> '+slotObj.from+ " : " +  slotObj.to + " "+ slotObj.status+' </label> </li>');
				});
		});
	});
});
</script>
@endsection