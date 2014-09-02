@if( $classTypes )
	<select name="class_type_id[]" multiple class="form-control class-types">
		@foreach( $classTypes as $classType)
			@if( !$classType->children->isEmpty() )
				<optgroup label="{{ $classType->name }}">
					@foreach( $classType->children as $child)
						<option value="{{ $child->id }}" {{ $child->isSelected() }}>{{ $child->name }}</option>
					@endforeach
				</optgroup>
			@endif
		@endforeach
	</select>
@endif