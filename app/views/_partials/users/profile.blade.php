<!-- User Avatar -->
@include('_partials.users.avatar', compact('user'))

<!-- Name -->
<h3>{{ $user->first_name }} {{ $user->last_name }}</h3>

@if( !$user->isSelf() )

	<!-- Follow Button -->
	@include('_partials.elements.followButton', compact('user'))

	<!-- Send Message -->
	@include('_partials.elements.sendMessage', compact('user'))

@endif

<!-- Average Rating -->
@if( $user->isInstructor() )
	<p>
		Average Rating:
		@include('_partials.elements.averageRating', ['instructor' => $user])
	</p>
@endif

<!-- Followers -->
<p>Followers:
	<span class="text-info">
		<a href="{{ URL::route('user.followers', $user->id) }}">{{ count($user->followers) }}</a>
	</span>
</p>

<!-- Following -->
<p>Following: 
	<span class="text-info">
		<a href="{{ URL::route('user.following', $user->id) }}">{{ count($user->following) }}</a>
	</span>
</p>

<!-- Profile Views -->
@if( $user->isInstructor() )
	Profile Views: {{ $user->userable->page_views }}
	<hr />

	@if( !$user->isSelf() )
		<!-- Leave Feedback -->
		@include('_partials.elements.leaveFeedback', ['instructor' => $user])
	@endif
@endif

<hr />

<!-- Social -->
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

<!-- Activities -->
<h4>Activities</h4>
<hr />

<!-- Bio -->
@if( $bio = $user->userable->bio )
	<h4>Bio</h4>
	{{ $bio }}
@endif