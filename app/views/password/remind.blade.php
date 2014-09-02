@section('title', 'Password Reminder')

@section('content')

	<div class="row">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="login-box">
    			<h4>Password Reminder</h4>
    			<form action="{{ action('RemindersController@postRemind') }}" method="POST">
    				<div class="form-item" style="text-align: center;">
    					<span>Email Address:</span>
    					<input type="email" name="email" class="form-control" />
    				</div>
    				<div class="login-actions">
    					<input type="submit" value="Send Reminder" class="button" />
    				</div>
				</form>
			</div>
    	</div>
	</div>

@stop