@section('title', 'Password Reset')

@section('content')

	<div class="row">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="login-box">
    			<h4>Password Reset</h4>
    			<form action="{{ action('RemindersController@postReset') }}" method="POST">
				    <input type="hidden" name="token" value="{{ $token }}" />

					<div class="form-item">
						<div>Email</div>
					    <input type="email" name="email" class="form-control" />
					</div>

					<div class="form-item">
						<div>New Password</div>
						<input type="password" name="password" class="form-control" />
					</div>

					<div class="form-item">
						<div>Confirm Password</div>
					    <input type="password" name="password_confirmation" class="form-control" />
					</div>
					
					<div class="login-actions">
						<input type="submit" value="Reset Password" class="button" />
					</div>
				</form>
			</div>
    	</div>
	</div>

@stop