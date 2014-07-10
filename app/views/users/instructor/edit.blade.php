@section('title', 'Edit Your Profile')

@section('content')

	<h3>Welcome {{ $user->first_name }}, edit your details below</h3>

	<div class="row">
		<div class="col-sm-4">Profile View: </div>
		<div class="col-sm-4">Feedback Received: </div>
		<div class="col-sm-4">Classes Listed: </div>
	</div>

	<hr>

	<h4>Update your details using the form below</h4>

	<hr>

	{{ Form::open([
		'route' => ['users.update', $user->id], 
		'method' => 'PUT'
	]) }}

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

						<div>Postcode</div>		
						<p>
							{{ Form::text(
								'postcode',
								$user->userable->postcode
							) }}
						</p>
					</div>
					<div class="col-md-6">
						<div>Telephone Number</div>		
						<p>
							{{ Form::text(
								'phone',
								$user->userable->phone
							) }}
						</p>

						<div>Mobile</div>		
						<p>
							{{ Form::text(
								'mobile',
								$user->userable->mobile
							) }}
						</p>

						<div>Email</div>		
						<p>
							{{ Form::text(
								'email',
								$user->email
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

		<div class="row">
			<div class="col-md-7">
				<div>Bio (Tell us a little about yourself):</div>
				{{ Form::textarea(
					'bio',
					$user->userable->bio
				) }}
			</div>
			<div class="col-md-5">
				<div>Website</div>
				<p>
					{{ Form::text(
						'website',
						$user->userable->website
					) }}
				</p>

				<div>Facebook</div>
				<p>
					{{ Form::text(
						'facebook',
						$user->userable->facebook
					) }}
				</p>

				<div>Twitter</div>
				<p>
					{{ Form::text(
						'twitter',
						$user->userable->twitter
					) }}
				</p>

				<div>YouTube</div>
				<p>
					{{ Form::text(
						'youtube',
						$user->userable->youtube
					) }}
				</p>
			</div>
		</div>

		{{ Form::submit('Update Profile', ['class' => 'btn btn-success']) }}

	{{ Form::close() }}

@stop