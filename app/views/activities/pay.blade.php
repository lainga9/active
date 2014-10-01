@section('title', 'Make a payment for ' . $activity->name)

@section('head')

	<!-- <script src="https://checkout.stripe.com/checkout.js"></script> -->
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

	<script type="text/javascript">
		Stripe.setPublishableKey('pk_test_4QR8R5HFHhhp9QS55FC9ql72');
	</script>

@stop

@section('content')

	<h3>Pay for {{ $activity->name }}</h3>

	<hr />

	@if( !Auth::user()->hasStripeCard() )

		<h4>Add a Payment Method</h4>

		<form action="{{ URL::route('activity.book', $activity->id) }}" method="POST" id="payment-form">

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

			<button type="submit" class="btn btn-success">Make Payment</button>

		</form>

	@else

		<p>By Clicking the button below you confirm you are committing to pay {{ $activity->getPrice() }} to attend {{ $activity->getName() }} on {{ $activity->getDate() }} at {{ $activity->getTime() }} using <strong>card ending in {{ Auth::user()->last_four }}</p>
	
		<form action="{{ URL::route('activity.book', $activity->id) }}" method="POST">
			<button type="submit" class="btn btn-success">Make Payment</button>
		</form>

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