@extends('panel.index')
@section('header')
 <h1>{{ strtoupper($playground->name) }} Playground</h1>
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
	          	<div class="" >
	             	<ul id="slot" class="">
	             		{{-- write here pushed items --}}
	             	</ul>
                </div>
	        </div>
	        <div class="form-group">
	            <div class="col-md-6 col-md-offset-4">
	                <button type="submit" class="btn btn-primary">
	                    Submit 
	                </button>
	            </div>
	        </div>
		</form>
    </div>
@endsection

@section('extra-script')
<script>
$(document).ready(function () {
	$('#date').on('change', function () { 
		var date = $(this).val();
		var id = $('#pid').val();
		$.get('/admin/pl/?date='+date+'?id='+id, function(data){
			// empty slots each request 
			$('#slot').empty();
			// check if has any slots in DB based on Date to retrieve it
			if (data.checkedSlots !="" && data.nonCheckedSlots !="") {
				$.each(data.checkedSlots, function(index,slotObj){
					$('#slot').append('<li class="col-md-4"><input class="form-check-input" type="checkbox" name="slots[]"               value="'+slotObj.id+'" checked/> <label class="form-check-label" id="mm" for="defaultCheck"> '+slotObj.from+ " : " +  slotObj.to + " "+ slotObj.status+' </label> </li>');
				});
				$.each(data.nonCheckedSlots, function(index,slotObj){
					$('#slot').append('<li class="col-md-4"><input class="form-check-input" type="checkbox" name="slots[]"               value="'+slotObj.id+'" /> <label class="form-check-label" id="mm" for="defaultCheck"> '+slotObj.from+ " : " +  slotObj.to + " "+ slotObj.status+' </label> </li>');
				});
			} else { // return all slots if Date not found in DB
				$.each(data.allSlots, function(index,slotObj){
					$('#slot').append('<li class="col-md-4"><input class="form-check-input" type="checkbox" name="slots[]"               value="'+slotObj.id+'" /> <label class="form-check-label" id="mm" for="defaultCheck"> '+slotObj.from+ " : " +  slotObj.to + " "+ slotObj.status+' </label> </li>');
				});
			}
		});
	});
});
</script>
@endsection