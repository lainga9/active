@include('_partials.layout.head')

	<div class="container">

		<!-- The top nav -->
		@include('_partials.layout.header')

		<div class="row">

			<!-- Alerts and Errors -->
			@include('_partials.errors')
			@include('_partials.alerts')

			<!-- The main content -->
			<div class="col-sm-12">
				@yield('content')		
			</div>

		</div>
	</div>

@include('_partials.layout.footer')