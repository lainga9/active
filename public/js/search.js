jQuery(document).ready(function($) {

	var $ajaxSearch = (function() {

		var $searchSelect = $('.search-select'),
			$activitySearch = $('.activity-search'),
			$userSearch = $('.user-search'),
			$organisationSearch = $('.organisation-search'),
			$results = $('#results'),
			$_location = $('input[name="location"]'),
			$_slider = $('.distance-slider'),
			$_days = $('input[name="day[]"]'),
			$_classType = $('select.class-types'),
			$_terms = $('input[name="terms"]'),
			$_genders = $('input[name="genders[]"]'),
			$_time_from = $('input[name="time_from"]'),
			$_time_until = $('input[name="time_until"]'),
			$_name = $('input[name="name"]'),
			$_orgName = $('input[name="orgName"]'),
			$_email = $('input[name="email"]'),
			$location = '',
			$distance = 20,
			$days = '',
			$name = '',
			$orgName = '',
			$email = '',
			$classType = '',
			$terms = '',
			$genders = '',
			$time_from = '',
			$time_until = '',
			$page = 1,

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

		searchSelect = function() {
			$page = 1;
			$('div[class*="-search"]').fadeOut();
			var $type = $searchSelect.find('option:selected').data('type');
			$('.' + $type + '-search').fadeIn();
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

			$searchSelect.on('change', searchSelect);

			$(document).on('click', 'ul.pagination a', function(e) {
				e.preventDefault();
				$page = getParameterByName('page', $(this).attr('href'));
				performSearch();
			});

			$_time_from.on('change', function() {
				$page = 1;
				$time_from = $(this).val();
				
				if( $.trim( $(this).val() ) != '' && $.trim( $time_until ) != '' ) {
					performSearch();
				}
			});

			$_time_until.on('change', function() {
				$page = 1;
				$time_until = $(this).val();

				if( $.trim( $(this).val() ) != '' && $.trim( $time_from ) != '' ) {
					performSearch();
				}
			});

			$_location.on('blur', function() {
				$page = 1;
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
				$page = 1;
				$location = $(this).val();
			});

			// Days of the week
			$_days.on('click', function() {
				$page = 1;
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
				$page = 1;
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
			$_classType.on('change', function(e, p) {
				$page = 1;
				var $values = $(this).chosen().val();

				$classType = '';

				$.each($values, function(i,v) {
					$classType += v + ','
				});

				// Remove the trailing comma
				$classType = $classType.replace(/,(?=[^,]*$)/, '');

				performSearch();
			});

			$_terms.on('keyup', throttle(function() {
				$page = 1;
				$terms = $(this).val();

				performSearch();
			}));

			$_name.on('keyup', throttle(function() {
				$page = 1;
				$name = $(this).val();
				performSearch();
			}));

			$_orgName.on('keyup', throttle(function() {
				$page = 1;
				$orgName = $(this).val();
				performSearch();
			}));

			$_email.on('keyup', throttle(function() {
				$page = 1;
				$email = $(this).val();
				performSearch();
			}));
		},

		throttle = function(f, delay){
		    var timer = null;
		    return function(){
		        var context = this, args = arguments;
		        clearTimeout(timer);
		        timer = window.setTimeout(function(){
		            f.apply(context, args);
		        },
		        delay || 750);
		    };
		},

		getParameterByName = function(name, link) {
    		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        	results = regex.exec(link);
    		return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
		},

		getQuery = function() {
			var $type = $searchSelect.find('option:selected').data('type');
			var $query = '';

			if($type === 'activity') {
				$query = "distance=" + $distance + "&day=" + $days + "&class_type_id=" + $classType + "&terms=" + $terms + "&location=" + $location + "&page=" + $page + "&genders=" + $genders + "&time_from=" + $time_from + "&time_until=" + $time_until;
			}

			if($type === 'user') {
				$query = "name=" + $name + "&email=" + $email + "&page=" + $page;
			}

			if($type === 'organisation') {
				$query = "orgName=" + $orgName + "&page=" + $page;
			}

			return $query;
		},

		performSearch = function() {
			var $route = $searchSelect.find('option:selected').val();

			$.ajax({
				type: "GET",
				data: getQuery(),
				url: $route
			}).done(function(result) {
				$results.html(result.results);
			});
		};

		return {init: init};

	})();

	$ajaxSearch.init();

});