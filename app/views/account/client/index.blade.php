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

	<h3>Cards</h3>

	<div class="row">

		<div class="col-sm-6">

			<h4>Existing Cards</h4>

			@if( $cards = $stripe->getCards(Auth::user()->stripe_id) )

				@foreach( $cards as $card )

					<h4>{{ $card->brand }}</h4>
					<p>Last Four Digits: <strong>{{ $card->last4 }}</strong></p>
					<p>Expires: {{ $card->exp_month }}/{{ $card->exp_year }}</p>

					<form action="{{ URL::route('account.card.delete', $card->id) }}" method="POST">
						<button type="submit" class="btn btn-danger">Delete Card</button>
					</form>

				@endforeach

			@endif
			
		</div>

		<div class="col-sm-6">
		
			<h4>Add a Card</h4>

			@include('_partials.elements.stripeForm', ['action' => URL::route('account.card.add'), 'buttonText' => 'Add Card'])

		</div>

	</div>

	<h3>History</h3>

	@if( $charges = $stripe->getChargesByCustomerId(Auth::user()->stripe_id) )

		@foreach( $charges as $charge )

			<?php $activity = $stripe->getActivityFromCharge($charge); ?>

			<h4>{{ date('d-m-Y g:ia', $charge->created) }}</h4>
			@if( $activity )
				<h5><a href="{{ $activity->getLink() }}">{{ $activity->getName() }}</a></h5>
			@endif
			<p>&pound;{{ number_format($charge->amount/100, 2) }}</p>

		@endforeach

	@endif


@stop

@section('scripts')

	{{ HTML::script('js/stripe.js') }}

@stop