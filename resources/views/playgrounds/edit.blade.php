@extends('panel.index')
@section('header')
<a href="{{route('ownerPlaygrounds.index',$playground->id)}}" class="btn btn-danger">
    <i class="fa fa-backward">Go Back</i> 
</a>
@endsection
@section('contents')

	<div class="row">
	<div class="col-md-12 ">
	<!-- general form elements disabled -->
		<div class="box box-warning">
			<div class="box-header with-border">
			  <h3 class="box-title">Update Playground</h3>
			</div>
			<div class="box-body">
				<form class="form-horizontal" method="POST" action="{{ route('playgrounds.update',$playground->id) }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Playground name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $playground->name }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Playground address</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ $playground->address }}" required>
                            </div>
                        </div>

                        <div class="form-group" >
                            <label for="details" class="col-md-4 control-label">Playground details</label>
                            <div class="col-md-6">
                                <textarea name="details" id="details" cols="72" rows="10">{{ $playground->details }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_id" class="col-md-4 control-label">Owner name</label>
                            <div class="col-md-6">
                                <select class="form-control" name="user_id" id="type">
                                    @foreach($users as $key => $user)
                                        <option @if($playground->user->name == $user->name) {!! 'selected' !!} @endif value="{{ $user->id }}"  > {{ $user->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                   
                        <div class="form-group">
                            <label for="image" class="col-md-4 control-label">Image</label>
                            <div class="col-md-6">
                                <img src="{{ asset('uploads/'.$playground->image) }}" style="width: 50px;height: 60px;">
                                <input id="image" type="file" class="form-control" name="image" accept="image/*" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            @foreach($slots as $key => $slot)
                                <div class="col-md-4">
                                   <input type="checkbox" name="slots[]" {{ $playground->slots->contains($slot->id) ? 'checked' : '' }} value="{{ $slot->id }}">
                                  <label class="form-check-label" for="defaultCheck"> {{ $slot->from ." : ".  $slot->to ." ". $slot->status }} </label>
                                </div>
                            @endforeach
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
		</div>
	</div>	
</div>
@endsection