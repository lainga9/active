jQuery(document).ready(function($) {

	var $ajaxSearch = (function() {

		var $activities = $('#activities'),
			$template = $("#search-results-template"),
			$_location = $('input[name="location"]'),
			$_slider = $('.distance-slider'),
			$_distance,
			$_days = $('input[name="day[]"]'),
			$_classType = $('input[name="class_type_id[]"]'),
			$_terms = $('input[name="terms"]'),
			$location,
			$distance = 20,
			$days = '',
			$classType = '',
			$terms = '',

		init = function() {

			$_distance = $_slider.slider({
				min: 0,
				value: $distance,
				max: 70,
				change: function( event, ui ) {
					$distance = ui.value;
					performSearch();
				}
			});

			if( $.trim( $_location.val() ) != '' ) {
				$('.refine').slideDown();
			}

			initEvents();
		},

		initEvents = function() {

			$_location.on('blur', function() {
				if( $.trim( $(this).val() ) != '' ) {
					$('.refine').slideDown();
					$distance = 5;
					$location = $(this).val();
				} else {
					$('.refine').slideUp();
				}
				performSearch();
			});

			$_location.on('change', function() {
				$location = $(this).val();
			});

			// Days of the week
			$_days.on('click', function() {

				$days = '';

				$_days.each(function() {
					if( $(this).is(":checked") )
					{
						$days += $(this).val() + ',';
					}
				});

				// Remove the trailing comma
				$days = $days.replace(/,(?=[^,]*$)/, '');
				performSearch();
			});

			// Class Types
			$_classType.on('click', function() {

				$classType = '';

				$_classType.each(function() {
					if( $(this).is(":checked") )
					{
						$classType += $(this).val() + ',';
					}
				});

				// Remove the trailing comma
				$classType = $classType.replace(/,(?=[^,]*$)/, '');
				performSearch();
			});

			$_terms.on('keyup', function() {
				$terms = $(this).val();
				performSearch();
			});
		},

		performSearch = function() {
			$.ajax({
				type: "GET",
				data: "distance=" + $distance + "&day=" + $days + "&class_type_id=" + $classType + "&terms=" + $terms + "&location=" + $location,
				url: "/active/public/search/activities"
			}).done(function(result) {
				var source   = $template.html();
				var template = Handlebars.compile(source);
				var html = template(result);
				$activities.html(html);
			});
		};

		return {init: init};

	})();

	$ajaxSearch.init();

});