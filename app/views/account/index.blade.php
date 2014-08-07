@section('title', 'My Account')

@section('head')

	<!-- <script src="https://checkout.stripe.com/checkout.js"></script> -->
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

	<script type="text/javascript">
		Stripe.setPublishableKey('pk_test_4QR8R5HFHhhp9QS55FC9ql72');
	</script>

@stop

@section('content')

	<h2>My Account</h2>

	<hr />

	<h3>My Plan</h3>

	@if( $user->userable->subscribed('pro') )

		<div class="alert alert-success">
			{{ ucwords($user->userable->stripe_plan) }}
		</div>

	@else
	
		<div class="alert alert-danger">
			Basic Plan
		</div>

	@endif

	<h4>
		Credits: 
		<strong>
			@if( $user->userable->subscribed('pro') )
				Unlimited
			@else
				{{ $user->userable->credits }}
			@endif
		</strong>
	</h4>

	<hr>

	@if( !$user->userable->subscribed('pro') )

		<h3>Upgrade</h3>

		<form action="{{ URL::route('account.goPro') }}" method="POST" id="payment-form">

			<span class="payment-errors"></span>
		
			<div class="form-row">
				<label>
					<span>Card Number</span>
					<input type="text" size="20" data-stripe="number"/>
				</label>
			</div>

			<div class="form-row">
				<label>
					<span>CVC</span>
					<input type="text" size="4" data-stripe="cvc"/>
				</label>
			</div>

			<div class="form-row">
				<label>
					<span>Expiration (MM/YYYY)</span>
					<input type="text" size="2" data-stripe="exp-month"/>
				</label>
				<span> / </span>
				<input type="text" size="4" data-stripe="exp-year"/>
			</div>

			<button type="submit" class="btn btn-success">Go Pro!</button>

		</form>

	@else

		@if( $user->userable->onGracePeriod() )

			<div class="alert alert-info">
				You have cancelled your pro plan and your subscription will expire at {{ $user->userable->subscription_ends_at }}
			</div>

			<form action="{{ URL::route('account.resumePro') }}" method="POST">
				<button type="submit" class="btn btn-danger">Resume Pro Plan</button>
			</form>			

		@else

			<h3>Cancel Subscription</h3>

			<form action="{{ URL::route('account.cancelPro') }}" method="POST">
				<button type="submit" class="btn btn-danger">Cancel Pro Plan</button>
			</form>

		@endif

	@endif

@stop

@section('scripts')

	<script>

		jQuery(function($) {

			$('#payment-form').submit(function(e) {
				e.preventDefault();
				var $form = $(this);
				$form.find('button').prop('disabled', true);
				Stripe.card.createToken($form, stripeResponseHandler);
				return false;
			});

			function stripeResponseHandler(status, response) {
				var $form = $('#payment-form');

				if (response.error) {
					$form.find('.payment-errors').text(response.error.message);
					$form.find('button').prop('disabled', false);
				} else {
					var token = response.id;
					$form.append($('<input type="hidden" name="stripeToken" />').val(token));
					$form.get(0).submit();
				}
			};
		});

	</script>

@stop