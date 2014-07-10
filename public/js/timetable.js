jQuery(document).ready(function($) {

	var $timetable = (function() {

		var $timetable = $('.timetable'),
			$days = $timetable.find('.day'),
			$nav = $timetable.find('nav.nav-days'),
			$buttons = $nav.find('a'),

		init = function() {
			$days.first().show();
			$buttons.first().addClass('text-success');

			initEvents();
		},

		initEvents = function() {
			$buttons.on('click', function(e) {
				e.preventDefault();
				$buttons.removeClass('text-success');
				$(this).addClass('text-success');
				$days.hide();
				$('.day[data-day="' + $(this).data('target') + '"]').fadeIn();
			});
		};

		return {init: init};

	})();

	$timetable.init();

});