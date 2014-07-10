@section('title', 'Search Results')

@section('content')

	{{ HTML::script('js/angular.min.js') }}
	{{ HTML::script('js/angularBooter.js') }}
	<script>
      myApp = new AngularBooter('myApp');
    </script>

	<div class="row" ng-controller="activitySearchCtrl" ng-app="myApp">
		<div class="col-md-4">
			@include('_partials.search.advanced')	
		</div>
		<div class="col-md-8">
			
			<article class="activity activity-excerpt" ng-repeat="activity in activities">
				<div class="row">
					<div class="col-sm-3">
						<img src="http://placehold.it/150x150" alt="Avatar" />
					</div>
					<div class="col-sm-9">
						<h4>@{{activity.name}}</h4>		
						<h5>Suitable for: <strong>@{{activity.level_id}}</strong></h5>
						<div class="row">
							<div class="col-md-6">
								<p>@{{activity.description}}</p>
							</div>
							<div class="col-md-6">
								<button ng-hide="activity.attending" class="btn btn success btn-lg">Book Class</button>
								<button ng-show="activity.attending" class="btn btn success btn-lg" disabled>Attending!</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<p>Time: @{{activity.time}} Date: @{{activity.date}} Address: @{{activity.street_address}}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<p class="pull-right">
							Tweet Share on Facebook
						</p>
						<p class="pull-left">
							<span ng-show="activity.favourite">
								
							</span>
							<span ng-hide="activity.favourite">
								add favourite
							</span>
							<a href="@{{activity.routes.showUser}}">
								@{{activity.user.first_name}}
								@{{activity.user.last_name}}
							</a>
						</p>
					</div>
				</div>
			</article>

			<script>

				myApp.controllers.activitySearchCtrl = ['$scope', '$http', function($scope, $http) {
					$scope.terms = "";
					$scope.activities = {{json_encode($activities->toArray())}};

					$scope.performSearch = function(query) {
						$scope.searchServerForQuery(query).then(function(response, status) {
							console.log('response', response.data);
							$scope.activities = response.data;
							console.log($scope.activities);
						}, function(response, status) {
							alert('Durn, it failed');
						});
					}

					$scope.searchServerForQuery = function() {
						return $http.get('api/activities', {
							params: {
								"terms": query
							}
						});
					}
				}];

			</script>
		</div>
	</div>

	<script>
		myApp.boot();
	</script>

@stop

@section('scriptss')

	<script>

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
						} else {
							$('.refine').slideUp();
						}
						performSearch();
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
						data: "distance=" + $distance + "&day=" + $days + "&class_type_id=" + $classType + "&terms=" + $terms,
						url: "{{ URL::route('activities.search') }}"
					}).done(function(result) {
						var source   = $template.html();
						var template = Handlebars.compile(source);
						var html = template(result);
						$activities.html(html);
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

	</script>

@stop