<nav class="nav-top">
	<ul style="list-style: none; padding: 0; margin: 0; text-align: right;">
		@if( Auth::user()->isClient() )
			<li>
				<a href="{{ URL::route('favourites') }}">Favourites</a>
			</li>
			<li>
				<a href="{{ URL::route('activities.attending') }}">Attending</a>
			</li>
		@endif
		@if( Auth::user()->isInstructor() )
			<li>
				<a href="{{ URL::route('activities.create') }}">Add Activity</a>
			</li>
			<li>
				<a href="{{ URL::route('activities.index') }}">My Activities</a>
			</li>
			<li>
				<a href="{{ URL::route('feedback.index') }}">Feedback</a>
			</li>
		@endif
		<li>
			<a href="{{ URL::route('messages.index') }}">My Inbox</a>
		</li>
		<li>
			<a href="{{ URL::route('account') }}">My Account</a>
		</li>
		<li>
			<a href="{{ URL::route('profile') }}">Profile</a>
		</li>
		<li>
			<a href="{{ URL::route('profile.edit') }}">Edit Profile</a>
		</li>
		<li>
			<a href="{{ URL::route('getLogout') }}">Logout</a>
		</li>
	</ul>
</nav>