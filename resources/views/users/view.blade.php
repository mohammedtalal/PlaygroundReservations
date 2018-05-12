@extends('panel.index')

@section('header')
 <h1>All Users</h1>
<a href="{{route('users.index')}}" class="btn btn-danger">
    <i class="fa fa-backward">Go Back</i> 
</a>
@stop

@section('contents')
<div class="table-responsive">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered pull-left">
        <tr>
            <td width="25%" class="align-left">Name</td>
            <td width="75%" class="align-left">{{ $user->name }}</td>
        </tr>
        <tr>
            <td width="25%" class="align-left">Email</td>
            <td width="75%" class="align-left">{{ $user->email }}</td>
        </tr>
        <tr>
            <td width="25%" class="align-left">Phone</td>
            <td width="75%" class="align-left">{{ $user->phone }}</td>
        </tr>
        <tr>
            <td width="25%" class="align-left">Type</td>
            <td width="75%" class="align-left">{{ $user->role->name }}</td>
        </tr>

    </table>
</div>
@endsection