{{ Form::open(
	['route' => 'users.store']
) }}

	{{ Form::hidden('role_id', 2) }}
	{{ Form::hidden('user_type', 'Instructor') }}

	<div>First Name</div>
	<p>
		{{ Form::text(
			'first_name', 
			Input::old('first_name')
		) }}
	</p>

	<div>Last Name</div>
	<p>
		{{ Form::text(
			'last_name', 
			Input::old('last_name')
		) }}
	</p>

	<div>Email Address</div>
	<p>
		{{ Form::text(
			'email', 
			Input::old('email')
		) }}
	</p>

	<div>Re-Enter Email Address</div>
	<p>
		{{ Form::text(
			'email_confirmation', 
			Input::old('email')
		) }}
	</p>

	<div>Password</div>
	<p>
		{{ Form::password(
			'password'
		) }}
	</p>

	<div>Re-Enter Password</div>
	<p>
		{{ Form::password(
			'password_confirmation'
		) }}
	</p>

	<div>Date of Birth</div>
	<div class="row">
		<div class="col-sm-2">
			<p>
				{{ Form::select(
					'dob_day',
					[
						'' 	=> 'Day',
						1 	=> '1'
					]
				) }}
			</p>
		</div>
		<div class="col-sm-2">
			<p>
				{{ Form::select(
					'dob_month',
					[
						'' 	=> 'Month',
						1 	=> 'Jan'
					]
				) }}
			</p>
		</div>
		<div class="col-sm-2">
			<p>
				{{ Form::select(
					'dob_year',
					[
						''		=> 'Year',
						1987 	=> '1987'
					]
				) }}
			</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-2">
			<span>Male:</span>
			{{ Form::radio('gender', 'male', true) }}
		</div>
		<div class="col-sm-2">
			<span>Female:</span>
			{{ Form::radio('gender', 'female', false) }}
		</div>
	</div>

	{{ Form::submit(
		'Get Active', 
		['class' => 'btn btn-success']
	) }}

{{ Form::close() }}