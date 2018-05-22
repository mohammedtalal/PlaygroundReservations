@extends('panel.index')
@section('header')
 <h1>{{ ucfirst($playground->name) }} Playground</h1>
 <hr>
@stop
@section('contents')
    <div class="col-md-12">
		<form method="POST" action="{{ route('playgroundSchedule.store',$playground->id) }}">
			{{ csrf_field() }}
			<div class="col-md-5 form-group">
				<input type="hidden" name="pid" id="pid" value="{{ $playground->id }}">
	    		<label class="form-input-label">Please Select Day to know available times</label>
				<input class="form-control" type="date" name="date" id="date" min="{{ date("Y-m-d") }}">
			</div>
	        <div class="col-md-12">
	             	<ul id="slots">
	             		{{-- pushe items here --}}
	             	</ul>
	        </div>
	        <div class="form-group">
	            <div class="col-md-6 col-md-offset-4">
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

	$('#date').on('change', function (id) { 
		var date = $(this).val();

		var id = $('#pid').val();
		$.get('/admin/PL/'+id+'?date='+date, function(data){
			// empty slots each request 
			$('#slots').empty();
			// check if has any slots in DB based on Date to retrieve it
			if (data.checkedSlots !== 'undefined' && data.nonCheckedSlots !== 'undefined') {
				$.each(data.checkedSlots, function(index,slotObj){
					// $("#hour option:checked").removeAttr("checked");
					$('#slots').append('<li class="col-md-4"><input class="form-check-input" type="checkbox" name="slots[]"               value="'+slotObj.id+'" checked/> <label class="form-check-label" id="mm" for="defaultCheck"> '+slotObj.from+ " : " +  slotObj.to + " "+ slotObj.status+' </label> </li>');
					// $('#hour').prop('checked', false);
				});
				$.each(data.nonCheckedSlots, function(index,slotObj){
					$('#slots').append('<li class="col-md-4"><input class="form-check-input" type="checkbox" name="slots[]"               value="'+slotObj.id+'" /> <label class="form-check-label" id="mm" for="defaultCheck"> '+slotObj.from+ " : " +  slotObj.to + " "+ slotObj.status+' </label> </li>');
				});
			} else { // return all slots if Date not found in DB
				$.each(data.allSlots, function(index,slotObj){
					$('#slots').append('<li class="col-md-4"><input class="form-check-input" type="checkbox" name="slots[]"               value="'+slotObj.id+'" /> <label class="form-check-label" id="mm" for="defaultCheck"> '+slotObj.from+ " : " +  slotObj.to + " "+ slotObj.status+' </label> </li>');
				});
			} 
		});

	});
});
</script>
@endsection