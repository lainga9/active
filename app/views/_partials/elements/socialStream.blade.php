@if( $user->socialStream() )
	@foreach( $user->socialStream() as $action )
		@include('_partials.elements.action')
	@endforeach
@endif