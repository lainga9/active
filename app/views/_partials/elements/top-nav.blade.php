<nav class="nav-top">
	<ul>
		@if( User::isClient() )
			<li>
				<a href="{{ URL::route('favourites') }}">Favourites</a>
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