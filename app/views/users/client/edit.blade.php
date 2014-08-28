@section('title', 'Edit Your Profile')

@section('content')

	<h3>Welcome {{ $user->first_name }}, edit your details below</h3>

	<hr>

	<h4>Update your details using the form below</h4>

	<hr>

	{{ Form::open([
		'route' => ['users.update', $user->id], 
		'method' => 'PUT'
	]) }}

		<input type="hidden" name="user_type_id" value="{{ $user->user_type_id }}" />

		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="col-md-6">
						<div>First Name</div>		
						<p>
							{{ Form::text(
								'first_name',
								$user->first_name
							) }}
						</p>

						<div>Last Name</div>		
						<p>
							{{ Form::text(
								'last_name',
								$user->last_name
							) }}
						</p>

						<div>Email</div>
						<p>
							{{ Form::text(
								'email',
								$user->email
							) }}
						</p>

						<div>Bio</div>
						<p>
							{{ Form::textarea(
								'bio',
								$user->userable->bio
							) }}
						</p>
					</div>
					<div class="col-md-6">
						<div>Twitter</div>
						<p>
							{{ Form::text(
								'twitter',
								$user->userable->twitter
							) }}
						</p>

						<div>Facebook</div>
						<p>
							{{ Form::text(
								'facebook',
								$user->userable->facebook
							) }}
						</p>

						<div>Instagram</div>
						<p>
							{{ Form::text(
								'instagram',
								$user->userable->instagram
							) }}
						</p>

						<div>YouTube</div>
						<p>
							{{ Form::text(
								'youtube',
								$user->userable->youtube
							) }}
						</p>

						<div>Website</div>
						<p>
							{{ Form::text(
								'website',
								$user->userable->website
							) }}
						</p>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div>Gender</div>
				<p>{{ Form::radio('gender', 'male', $user->gender == 'male') }} Male</p>
				<p>{{ Form::radio('gender', 'female', $user->gender == 'female') }} Female</p>
			</div>
		</div>

		{{ Form::submit('Update Profile', ['class' => 'btn btn-success']) }}

	{{ Form::close() }}

@stop