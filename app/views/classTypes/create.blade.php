@section('title', 'Add a Class Type')

@section('content')

	<div class="row">
		<div class="col-md-3">
			<h4>Current Class Types</h4>
			{{ ClassType::printHTML() }}
		</div>
		<div class="col-md-9">
			<h4>Add a Class Type</h4>
			{{ Form::open([
				'route' => 'classTypes.store'
			]) }}

				<div>Name</div>
				<p>
					{{ Form::text(
						'name', Input::old('name')
					) }}			
				</p>

				<div>Parent</div>
				<p>
					{{ Form::select(
						'parent_id',
						Base::toSelect($classTypes, 'name', 'Select'),
						Input::old('parent_id')
					) }}
				</p>

				{{ Form::submit(
					'Add Class Type', 
					['class' => 'btn btn-success']
				) }}

			{{ Form::close() }}
		</div>
	</div>

@stop