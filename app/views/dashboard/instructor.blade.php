@section('title', 'Welcome ' . Auth::user()->first_name)

@section('content')

	<a href="{{ URL::route('activities.create') }}" class="btn btn-success">Add Activity</a>

	<a href="{{ URL::route('users.show', Auth::user()->id) }}" class="btn btn-success">My Profile</a>

	<a href="{{ URL::route('profile.edit') }}" class="btn btn-success">Edit Profile</a>

@stop