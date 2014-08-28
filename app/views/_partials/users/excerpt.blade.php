<article class="user-excerpt">
	<h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
	<h4>{{ $user->email }}</h4>
	<a href="{{ URL::route('users.show', $user->id) }}" class="btn btn-success">View</a>
</article>