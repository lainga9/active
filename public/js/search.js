jQuery(document).ready(function($) {

	var $ajaxSearch = (function() {

		var $activities = $('#activities'),
			$pagination = $('#pagination'),
			$template = $("#search-results-template"),
			$_location = $('input[name="location"]'),
			$_slider = $('.distance-slider'),
			$_days = $('input[name="day[]"]'),
			$_classType = $('input[name="class_type_id[]"]'),
			$_terms = $('input[name="terms"]'),
			$location = '',
			$distance = 20,
			$days = '',
			$classType = '',
			$terms = '',
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

			performSearch();
		},

		initEvents = function() {

			$(document).on('click', 'ul.pagination a', function(e) {
				e.preventDefault();
				$page = getParameterByName('page', $(this).attr('href'));
				performSearch();
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

		getParameterByName = function(name, link) {
    		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        	results = regex.exec(link);
    		return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
		},

		performSearch = function() {
			$.ajax({
				type: "GET",
				data: "distance=" + $distance + "&day=" + $days + "&class_type_id=" + $classType + "&terms=" + $terms + "&location=" + $location + "&page=" + $page,
				url: "/active/public/search/activities"
			}).done(function(result) {
				var source   = $template.html();
				var template = Handlebars.compile(source);
				var html = template(result.activities);
				$pagination.html(result.activities.links);
				$activities.html(html);
				$page = 1;
			});
		};

		return {init: init};

	})();

	$ajaxSearch.init();

});