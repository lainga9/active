jQuery(document).ready(function($) {

	var $ajaxSearch = (function() {

		var $activities = $('#activitiesWrapper'),
			$pagination = $('#pagination'),
			$template = $("#search-results-template"),
			$_location = $('input[name="location"]'),
			$_slider = $('.distance-slider'),
			$_days = $('input[name="day[]"]'),
			$_classType = $('input[name="class_type_id[]"]'),
			$_terms = $('input[name="terms"]'),
			$_genders = $('input[name="genders[]"]'),
			$_time_from = $('input[name="time_from"]'),
			$_time_until = $('input[name="time_until"]'),
			$location = '',
			$distance = 20,
			$days = '',
			$classType = '',
			$terms = '',
			$genders = '',
			$time_from = '',
			$time_until = '',
			$page = 1,
			$ul = $('ul.pagination'),
			$lis = $ul.children(),
			$links = $lis.find('a'),

		init = function() {

			$('.distance-value').html($distance);
			$location = $_location.val();

			$_distance = $_slider.slider({
				min: 0,
				value: $distance,
				max: 70,
				change: function( event, ui ) {
					$distance = ui.value;
					$('.distance-value').html($distance);
					performSearch();
				}
			});

			if( $.trim( $_location.val() ) != '' ) {
				$('.refine').slideDown();
			}

			initEvents();

			timepicker();

			performSearch();
		},

		timepicker = function() {
			$_time_from.datetimepicker({
				datepicker: false,
				step: 30,
				format: 'H:i',
			});

			$_time_until.datetimepicker({
				datepicker: false,
				step: 30,
				format: 'H:i',
			});
		},

		initEvents = function() {

			$(document).on('click', 'ul.pagination a', function(e) {
				e.preventDefault();
				$page = getParameterByName('page', $(this).attr('href'));
				performSearch();
			});

			$_time_from.on('change', function() {
				$time_from = $(this).val();
				
				if( $.trim( $(this).val() ) != '' && $.trim( $time_until ) != '' ) {
					performSearch();
				}
			});

			$_time_until.on('change', function() {
				$time_until = $(this).val();

				if( $.trim( $(this).val() ) != '' && $.trim( $time_from ) != '' ) {
					performSearch();
				}
			});

			$_location.on('blur', function() {
				if( $.trim( $(this).val() ) != '' ) {
					$('.refine').slideDown();
					$location = encodeURI($(this).val()).replace(/%20/g,'+');
				} else {
					$('.refine').slideUp();
				}
				performSearch();
			});

			// Location Search
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

			// Gender
			$_genders.on('click', function() {

				$genders = '';

				$_genders.each(function() {
					if( $(this).is(":checked") )
					{
						$genders += $(this).val() + ',';
					}
				});

				// Remove the trailing comma
				$genders = $genders.replace(/,(?=[^,]*$)/, '');
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

		getParameterByName = function(name, link) {
    		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        	results = regex.exec(link);
    		return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
		},

		performSearch = function() {
			$.ajax({
				type: "GET",
				data: "distance=" + $distance + "&day=" + $days + "&class_type_id=" + $classType + "&terms=" + $terms + "&location=" + $location + "&page=" + $page + "&genders=" + $genders + "&time_from=" + $time_from + "&time_until=" + $time_until,
				url: "/active/public/search/activities"
			}).done(function(result) {
				$activities.html(result.activities);
			});
		};

		return {init: init};

	})();

	$ajaxSearch.init();

});