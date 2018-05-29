@extends('panel.index')
@section('header')
 <h1>Our Reserved Hours</h1>
@stop
@section('contents')
    <div class="col-md-12" style="margin-top: 20px">
        <a href="{{ route('ownerPlaygrounds.index') }}" class="btn btn-info btn-flat">Back</a> 
        <hr>
    </div>

    <table class="table table-responsive" id="categories-table">
        <thead>
            <th>#</th>
            <th>User</th>
            <th>Playground Name</th>
            <th>Hour</th>
            <th>Playground Cost</th>
            <th>Payment Type</th>
            <th>Date</th>
        </thead>
        <tbody>
        @if(isset($reservations))
       <!-- foreach -->
       @foreach($reservations as $key => $reserve)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ ($reserve->users == null ? 'Reserve by owner' : $reserve->users->name) }}</td>
                <td>{{ $reserve->playground->name }}</td>
                <td>{{ $reserve->slots->from .' : '. $reserve->slots->to .' '. $reserve->slots->status   }}</td>
                <td>{{ $reserve->playground->cost }}</td>
                <td>{{ ($reserve->payment_type == 0 ? 'Manual Payment' : 'Online Payment') }}</td>
                <td>{{ $reserve->date }}</td>
            </tr>
            @endforeach
            <!-- endforeach -->
        @else
        <h4>No Found Reservations</h4>
        @endif
        </tbody>
    </table>
    {{ $reservations->links()  }}
@endsection

@section('extra-script')
{{-- <script>
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
</script> --}}
@endsection