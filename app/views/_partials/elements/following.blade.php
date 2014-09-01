@if( !$user->following->isEmpty() )

	@foreach( $user->following as $following )

		@include('_partials.users.excerpt', ['user' => $following])

	@endforeach

@endif