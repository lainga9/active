<nav class="nav-top">
	<ul>
		@if( Auth::user()->isClient() )
			<li>
				<a href="{{ URL::route('favourites') }}">Favourites</a>
			</li>
			<li>
				<a href="{{ URL::route('activities.attending') }}">Attending</a>
			</li>
		@endif
		<li>
			<a href="{{ URL::route('profile.edit') }}">Profile</a>
		</li>
		<li>
			<a href="{{ URL::route('getLogout') }}">Logout</a>
		</li>
	</ul>
</nav>