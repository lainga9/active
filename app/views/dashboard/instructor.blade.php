@section('title', 'Welcome ' . Auth::user()->first_name)

@section('content')

	<a href="{{ URL::route('activities.create') }}" class="btn btn-success">Add Activity</a>

	<a href="{{ URL::route('activities.index') }}" class="btn btn-success">My Activities</a>

	<a href="{{ URL::route('account') }}" class="btn btn-success">My Account</a>

	<a href="{{ URL::route('messages.index') }}" class="btn btn-success">Inbox</a>

	<a href="{{ URL::route('feedback.index') }}" class="btn btn-success">Feedback</a>

	<a href="{{ URL::route('marketing.index') }}" class="btn btn-success">Marketing Material</a>

	<a href="{{ URL::route('users.show', Auth::user()->id) }}" class="btn btn-success">My Profile</a>

	<a href="{{ URL::route('profile.edit') }}" class="btn btn-success">Edit Profile</a>

@stop