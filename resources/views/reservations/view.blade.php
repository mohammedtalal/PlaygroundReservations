
@extends('panel.index')

@section('header')
 <h1>{{ ucfirst($playground->name) }} Reservations Details</h1>
<a href="" class="btn btn-danger">
    <i class="fa fa-backward">Go Back</i> 
</a>
@stop

@section('contents')
<div class="table-responsive">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered pull-left">
        <tr>
            <td width="25%" class="align-left">Name</td>
            <td width="75%" class="align-left">{{ $playground->name }}</td>
        </tr>
        <tr>
            <td width="25%" class="align-left">Address</td>
            <td width="75%" class="align-left">{{ $playground->address }}</td>
        </tr>
        <tr>
            <td width="25%" class="align-left">Address</td>
            <td width="75%" class="align-left">{{ $playground->cost }}</td>
        </tr>
        <tr>
            <td width="25%" class="align-left">Details</td>
            <td width="75%" class="align-left">{{ $playground->details }}</td>
        </tr>
        @if($playground->image)
        <tr>
            <td width="25%" class="align-left"> Playground Image </td>
            <td width="75%" class="align-left">
                <img src="{{ asset('uploads/'.$playground->image) }}" style="width: 50px;height: 60px;">
            </td>
        </tr>
        @endif
        <tr>
            <td width="25%" class="align-left">Owner name</td>
            <td width="75%" class="align-left">{{ $playground->user->name }}</td>
        </tr>
        <tr>
            <td width="25%" class="align-left">Owner phone</td>
            <td width="75%" class="align-left">{{ $playground->user->phone }}</td>
        </tr>
        <tr>
            <td width="25%" class="align-left">Owner phone</td>
            <td width="75%" class="align-left"> {{ $playground->user->phone }}</td>
        </tr>
        <tr>
            <td width="25%" class="align-left">Reservation Times</td>
            <td width="75%" class="align-left">
            	<ul>
	   
                        @foreach($usersHasReserve as $slot)
                                {{-- {{ dD($playground->slots) }} --}}
						  <li class="col-md-6">{{ $slot->from ." ". $slot->to ." ". strtoupper($slot->status) }}</li>                
                        @endforeach
                
				</ul>
            </td>
        </tr>
    </table>
</div>
@endsection