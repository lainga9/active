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

	@if( $user->subscribed('pro') )

		<div class="alert alert-success">
			{{ ucwords($user->stripe_plan) }}
		</div>

	@else
	
		<div class="alert alert-danger">
			Basic Plan
		</div>

	@endif

	<h4>
		Credits remaining this week: 
		<strong>
			@if( $user->subscribed('pro') )
				Unlimited
			@else
				{{ $user->userable->credits }}
			@endif
		</strong>
	</h4>

	<hr>

	@if( !$user->subscribed('pro') )

		<h3>Upgrade</h3>

		@include('_partials.elements.stripeForm', ['action' => URL::route('account.goPro'), 'buttonText' => 'Go Pro!'])

	@else

		@if( $user->onGracePeriod() )

			<div class="alert alert-info">
				You have cancelled your pro plan and your subscription will expire at {{ $user->subscription_ends_at }}
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

	<hr>

	<h3>History</h3>

	@if( $credits = $user->creditHistory )

		@foreach( $credits as $credit )

			<h5>{{ $credit->created_at }}</h5>
			<p><a href="{{ $credit->activity->getLink() }}">{{ $credit->activity->getName() }}</a></p>

		@endforeach

	@endif

@stop

@section('scripts')

	{{ HTML::script('js/stripe.js') }}

@stop