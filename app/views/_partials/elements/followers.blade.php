@if( !$user->followers->isEmpty() )

	@foreach( $user->followers as $follower )

		@include('_partials.users.excerpt', ['user' => $follower])

	@endforeach

@endif