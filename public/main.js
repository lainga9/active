jQuery(document).ready(function($) {

	$('select').chosen();

	var $infinite = (function() {

		var $container = $('#activities'),

		init = function() {
			$container.infinitescroll({
				navSelector: "ul.pagination",
				nextSelector: "ul.pagination li.active + li a",
				itemSelector: "#activities article.activity",
				loadingText: 'Loading more activities...',
				doneText: 'No more activities!'
			});
		};

		return {init: init};

	})();

	// $infinite.init();

	$(document).on('click', 'a.remove-favourite, a.add-favourite', function(e) {
		$this = $(this);
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: $(this).attr('href')
		}).done(function(result) {
			$this.replaceWith(result.html);
		});
	});

	var $getLocation = (function() {

		var $_location = $('input[name="location"]'),
			$_distance = $('input[name="distance"]'),

		init = function() {
			initEvents();
		},

		initEvents = function() {
			$_location.one('focus', function() {
				if( $.trim( $(this).val() ) == '' ) {
					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(success, error);
					} else {
						error('not supported');
					}
				}
			});
		},

		success = function(position) {
			$('.refine').slideDown();
			var $coords = position.coords.latitude + "," + position.coords.longitude;
			var $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + $coords + "&key=AIzaSyAb4H0rGSxeyJ1uVJgx6oBoL-CKiFHVqOY";
			$.ajax({
				dataType: "json",
				url: $url,
			}).done(function(result) {
				var $results = result.results;
				if($results.length > 0) {
					$_location.val($results[0].formatted_address);
				}
			});
		},

	 	error = function(msg) {
			console.log(msg);
		};

		return {init: init};

	})();

	$getLocation.init();

});