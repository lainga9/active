@if( Auth::user()->isFollowing($user) )
	<a href="{{ URL::route('user.unfollow', $user->id) }}" class="btn btn-danger">Unfollow</a>
@else
	<a href="{{ URL::route('user.follow', $user->id) }}" class="btn btn-success">Follow</a>
@endif