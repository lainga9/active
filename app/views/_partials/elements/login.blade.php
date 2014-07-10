{{ Form::open([
	'route' => 'postLogin'
]) }}
	<div class="login-box">
		<h4>Login to Get me Active</h4>
		<div class="pull-left">
			<div>Email</div>
			<p>
				{{ Form::text(
					'email', 
					Input::old('email')
				) }}
			</p>
		</div>
		<div class="pull-left">
			<div>Password</div>
			<p>
				{{ Form::password('password') }}
			</p>
		</div>
		
		<button class="button"type="submit">Log in</button>
		<p><a href="{{ URL::route('password.reminder') }}">Forgotten Password?</a></p>
	</div>
{{ Form::close() }}