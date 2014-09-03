@if( !$user->following->isEmpty() )

	@foreach( $user->following as $following )

		@include('_partials.users.excerpt', ['user' => $following])

	@endforeach

@else

	<div class="alert alert-info">{{ $user->getName() }} {{ $user->getIs() }} not yet following anyone</div>

@endif