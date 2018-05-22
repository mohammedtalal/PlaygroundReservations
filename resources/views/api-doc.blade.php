@extends('panel.index')

@section('header')
 <h1>End-Points Doc</h1>
@stop

@section('contents')
<div class="table-responsive">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered pull-left">
        <tr>
            <td width="25%" class="align-left">Title</td>
            <td width="75%" class="align-left">
                User Login
            </td>
        </tr>
        <tr>
            <td width="25%" class="align-left">URL</td>
            <td width="75%" class="align-left">
                api/login
            </td>
        </tr>
        <tr>
            <td width="25%" class="align-left">Method Type</td>
            <td width="75%" class="align-left">GET</td>
        </tr>
        <tr>
            <td width="25%" class="align-left"> URL Params </td>
            <td width="75%" class="align-left">
                NULL
            </td>
        </tr>
        <tr>
            <td width="25%" class="align-left">Data Params</td>
            <td width="75%" class="align-left">
                <li>success message</li>
                <li>Data</li>
            </td>
        </tr>
         <tr>
            <td width="25%" class="align-left"> Success Response </td>
            <td width="75%" class="align-left">
                <li>success: true</li>
                <li>Data</li>
            </td>
        </tr>
        <tr>
            <td width="25%" class="align-left">Error Response</td>
            <td width="75%" class="align-left">
                <li>success: false</li>
                <li>Data</li>
            </td>
        </tr>
    </table>
</div>
@endsection