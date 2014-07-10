jQuery(document).ready(function($) {

	var $ajaxSearch = (function() {

		var $_postcode = $('input[name="postcode"]'),
			$_distance = $('input[name="distance"]'),

		init = function() {
			initEvents();
		},

		initEvents = function() {
			$('input[name="distance"]').on('change', function() {

				if( $.trim( $_postcode.val() ) == '' ) {
					alert('Please enter your location first');
					return;
				}

				var $val = $(this).val();
				
				$.ajax({
					type: "POST",
					data: "distance=" + $val,
					url: "{{ URL::route('search') }}"
				}).done(function(result) {
					var source   = $("#search-results-template").html();
					var template = Handlebars.compile(source);
					var html = template(result);
					$('#activities').html(html);
				});
			});
		},

		success = function(position) {
			var $coords = position.coords.latitude + "," + position.coords.longitude;
			var $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + $coords + "&key=AIzaSyAb4H0rGSxeyJ1uVJgx6oBoL-CKiFHVqOY";
			$.ajax({
				dataType: "json",
				url: $url,
			}).done(function(result) {
				var $results = result.results;
				if($results.length > 0) {
					$_postcode.val($results[0].formatted_address);
				}
			});
		},

	 	error = function(msg) {
			console.log(msg);
		};

		return {init: init};

	})();

	$ajaxSearch.init();

});