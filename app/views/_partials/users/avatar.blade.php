<a href="{{ $user->getLink() }}">
	@if($user->avatar)
		<img src="{{ URL::asset($user->avatar) }}" alt="{{ $user->getName() }}" />
	@else
		<img src="http://placehold.it/150" alt="{{ $user->getName() }}" />
	@endif
</a>