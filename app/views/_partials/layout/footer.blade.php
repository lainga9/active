<script>
		jQuery(document).ready(function($) {
			$('input[type="text"], input[type="password"], textarea').addClass('form-control');
		});
	</script>

	@yield('scripts')

	{{ HTML::script('routes.js') }}
	{{ HTML::script('main.js') }}

</body>
</html>