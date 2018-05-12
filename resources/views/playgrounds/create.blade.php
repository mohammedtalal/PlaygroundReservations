@extends('panel.index')


@section('contents')

	<div class="row">
	<div class="col-md-12 ">
	<!-- general form elements disabled -->
		<div class="box box-warning">
			<div class="box-header with-border">
			  <h3 class="box-title">Create Playground</h3>
			</div>
			<div class="box-body">
				<form class="form-horizontal" method="POST" action="{{ route('playgrounds.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Playground name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name"  required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">Playground address</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address"  required>
                            </div>
                        </div>

                        <div class="form-group" >
                            <label for="details" class="col-md-4 control-label">Playground details</label>
                            <div class="col-md-6">
                                <textarea name="details" id="details" cols="72" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cost" class="col-md-4 control-label">Playground Hour Cost</label>
                            <div class="col-md-6">
                                <input id="cost" type="number" class="form-control" name="cost" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_id" class="col-md-4 control-label">Owner name</label>
                            <div class="col-md-6">
                                <select class="form-control" name="user_id" id="type">
                                        <option value="{{ auth()->id() }}"> {{ auth()->user()->name }} </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image" class="col-md-4 control-label">Image</label>
                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control" name="image" accept="image/*" >
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
		</div>
	</div>	
</div>
@endsection