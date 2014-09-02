@if( !$users->isEmpty() )

	@foreach( $users as $user )

		@include('_partials.users.excerpt', compact('user'))

	@endforeach

	<?php 
		$appends = [
			'name' 			=> Input::get('name'),
			'email' 		=> Input::get('email')
		]; 
	?>

	{{ $users->appends($appends)->links() }}

@else

	<div class="alert alert-info">
		No Users
	</div>

@endif