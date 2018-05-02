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
				<form class="form-horizontal" method="POST" action="{{ route('playgroundSlot.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="col-md-12">
                            <label for="user_id" class="">Playground Name</label>
                             <select class="form-control " name="playground_id" id="playground_id" required>
                                @foreach($playgrounds as $key => $playground)
                                    <option value="{{ $playground->id }}"> {{ $playground->name }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                        <hr>

                            @foreach($slots as $key => $slot)
                                <div class="col-md-4">
                                  <input class="form-check-input" type="checkbox" name="slots[]"  value="{{ $slot->id }}" >
                                  <label class="form-check-label" for="defaultCheck"> {{ $slot->from ." : ".  $slot->to ." ". $slot->status }} </label>
                                </div>
                            @endforeach
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