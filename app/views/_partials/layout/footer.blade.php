<script>
		jQuery(document).ready(function($) {
			$('input[type="text"], input[type="password"], textarea').addClass('form-control');
		});
	</script>

	@yield('scripts')

	{{ HTML::script('routes.js') }}
	{{ HTML::script('js/jquery.infinitescroll.min.js') }}
	{{ HTML::script('js/chosen.jquery.min.js') }}
	{{ HTML::script('main.js') }}

</body>
</html>