<article class="user-excerpt">
	@if($user->avatar)
		<a href="{{ URL::route('users.show', $user->id) }}"><img src="{{ URL::asset($user->avatar) }}" alt="" /></a>
	@else
		<img src="http://placehold.it/150" alt="" />
	@endif
	<h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
	<h4>{{ $user->email }}</h4>
	<a href="{{ URL::route('users.show', $user->id) }}" class="btn btn-success">View</a>
	@if( Auth::user()->isAdmin() )
		@if( $user->isSuspended() )
			<a href="{{ URL::route('user.unsuspend', $user->id) }}" class="btn btn-danger">Unsuspend</a>
		@else
			<a href="{{ URL::route('users.suspend', $user->id) }}" class="btn btn-danger">Suspend</a>
		@endif
	@endif
</article>