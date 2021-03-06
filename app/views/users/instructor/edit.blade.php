@section('title', 'Edit Your Profile')

@section('content')

	<h3>Welcome {{ $user->first_name }}, edit your details below</h3>

	<div class="row">
		<div class="col-sm-4">Profile View: {{ $user->userable->page_views }}</div>
		<div class="col-sm-4">Feedback Received: {{ count($user->feedback) }}</div>
		<div class="col-sm-4">Classes Listed: {{ count($user->activities) }}</div>
	</div>

	<h4>Profile Picture</h4>

	@if( $user->avatar )
		<img src="{{ URL::asset($user->avatar) }}" alt="" />
	@endif

	{{ Form::open([
		'route' 	=> ['user.avatar', $user->id],
		'method' 	=> 'PUT',
		'files'		=> true
	]) }}

		<p>{{ Form::file('avatar') }}</p>

		{{ Form::submit('Update Profile Pic', ['class' => 'btn btn-success']) }}

	{{ Form::close() }}

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

						<div>Street Address</div>
						<p>
							{{ Form::text(
								'street_address',
								$user->street_address
							) }}
						</p>

						<div>Town</div>		
						<p>
							{{ Form::text(
								'town',
								$user->town
							) }}
						</p>

					</div>
					<div class="col-md-6">

						<div>Postcode</div>		
						<p>
							{{ Form::text(
								'postcode',
								$user->postcode
							) }}
						</p>

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