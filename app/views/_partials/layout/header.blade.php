<div class="row">
	<div class="col-sm-4">
		<h1><a href="{{ URL::route('dashboard') }}">Get me Active.co.uk</a></h1>
	</div>
	<div class="col-sm-8">
		<div class="pull-right">
			@if( Auth::check() )
				@include('_partials.elements.top-nav')
				Logged in as: {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
			@else
				@include('_partials.elements.login')
			@endif
		</div>
	</div>
</div>