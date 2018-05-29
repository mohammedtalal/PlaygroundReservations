@extends('panel.index')
@section('header')
 <h1>All Playgrounds</h1>
@stop
@section('contents')
    
    <div class="col-md-12" style="margin-top: 20px">
        <a href="{{ route('playgrounds.create') }}" class="btn btn-primary btn-flat">Add New Playground</a> 
        <hr>
    </div>

    <table class="table table-responsive" id="categories-table">
        <thead>
            <th>#</th>
            <th>name</th>
            <th>address</th>
            <th>Hour Cost</th>
            <th>Owner name</th>
            <th>Owner phone</th>
            <th colspan="3" style="padding-left: 85px">Action</th>
        </thead>

        <tbody>
       @foreach($playgrounds as $key => $playground)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $playground->name }}</td>
                <td>{{ $playground->address }}</td>
                <td>{{ $playground->cost }}</td>
                <td>{{ $playground->user->name }}</td>
                <td>{{ $playground->user->phone }}</td>

                <td>
                   <div class='btn btn-group'>
                        <a href="{{ route('playgrounds.edit',$playground->id) }}" class='btn btn-info btn-xs'>
                            <span>Edit</span>
                        </a>
                        <a href="{{ route('playgrounds.view',$playground->id) }}" class='btn btn-primary btn-xs'>
                            <span>View</span>
                        </a>
                        <a href="{{ route('playgroundSchedule.create',$playground->id) }}" class='btn btn-primary btn-xs'>
                            <span>Schedule</span>
                        </a>
                        <a href="{{ route('playground.reserved',$playground->id) }}" class='btn btn-primary btn-xs'>
                            <span>Reservations</span>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
            <!-- endforeach -->
        </tbody>
    </table>
@endsection