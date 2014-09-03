@if( !$user->followers->isEmpty() )

	@foreach( $user->followers as $follower )

		@include('_partials.users.excerpt', ['user' => $follower])

	@endforeach

@else

	<div class="alert alert-info">No one is following {{ $user->getName() }} yet</div>

@endif