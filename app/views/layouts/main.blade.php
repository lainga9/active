@include('_partials.layout.head')

	<div class="container">

		<!-- The top nav -->
		@include('_partials.layout.header')

		<div class="row">

			<!-- Alerts and Errors -->
			@include('_partials.errors')
			@include('_partials.alerts')

			<!-- The sidebar -->
			<aside class="sidebar col-sm-3">
				@yield('sidebar')
			</aside>

			<!-- The main content -->
			<div class="col-sm-9">
				@yield('content')		
			</div>

		</div>
	</div>

@include('_partials.layout.footer')