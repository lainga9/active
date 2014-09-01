@if($user->avatar)
	<a href="{{ URL::route('users.show', $user->id) }}"><img src="{{ URL::asset($user->avatar) }}" alt="" /></a>
@else
	<img src="http://placehold.it/150" alt="" />
@endif
<h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
@if( Auth::user()->isFollowing($user) )
	<a href="{{ URL::route('user.unfollow', $user->id) }}" class="btn btn-danger">Unfollow</a>
@else
	<a href="{{ URL::route('user.follow', $user->id) }}" class="btn btn-success">Follow</a>
@endif
@include('_partials.elements.sendMessage', compact('user'))
@if( $user->isInstructor() )
	<p>
		Average Rating:
		@include('_partials.elements.averageRating', ['instructor' => $user])
	</p>
@endif
<p>Followers:
	<span class="text-info">
		<a href="{{ URL::route('user.followers', $user->id) }}">{{ count($user->followers) }}</a>
	</span>
</p>
<p>Following: 
	<span class="text-info">
		<a href="{{ URL::route('user.following', $user->id) }}">{{ count($user->following) }}</a>
	</span>
</p>
@if( $user->isInstructor() )
	profile views
	<hr />
	@include('_partials.elements.leaveFeedback', ['instructor' => $user])
@endif
<hr />
@if( $website = $user->userable->website )
	<p><a href="{{ $website }}">{{ $website }}</a></p>
@endif
@if( $facebook = $user->userable->facebook )
	<p><a href="{{ $facebook }}">{{ $website }}</a></p>
@endif
@if( $twitter = $user->userable->twitter )
	<p><a href="{{ $twitter }}">{{ $twitter }}</a></p>
@endif
@if( $youtube = $user->userable->youtube )
	<p><a href="{{ $youtube }}">{{ $youtube }}</a></p>
@endif
@if( $instagram = $user->userable->instagram )
	<p><a href="{{ $instagram }}">{{ $instagram }}</a></p>
@endif
<hr />
<h4>Activities</h4>
<hr />
@if( $bio = $user->userable->bio )
	<h4>Bio</h4>
	{{ $bio }}
@endif