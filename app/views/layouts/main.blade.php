@include('_partials.layout.head')

	<div class="container">

		<!-- The top nav -->
		@include('_partials.layout.header')

		<div class="row">

			<!-- Alerts and Errors -->
			@include('_partials.errors')
			@include('_partials.alerts')

			<!-- The sidebar -->
			<aside class="sidebar {{ Base::sidebarClass() }}">
				@yield('sidebar')
			</aside>

			<!-- The main content -->
			<div class="{{ Base::mainClass() }}">
				@yield('content')
			</div>

		</div>
	</div>

@include('_partials.layout.footer')