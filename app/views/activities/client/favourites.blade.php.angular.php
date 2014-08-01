@section('title', 'Favourite Activities')

@section('head')

	{{ HTML::script('js/angular/angular.min.js') }}
	{{ HTML::script('js/angular/angularBooter.js') }}

	<script>
		activityApp = new AngularBooter('activityApp');
    </script>

@stop

@section('content')

	<div ng-cloak ng-app="activityApp" ng-controller="activityController">
		
		<ul id="favourites" ng-show="favourites">
			
			@include('_partials.angular.activity')

		</ul>

		<div ng-hide="favourites" class="alert alert-info">
			You have not yet added any favourites!
		</div>

	</div>

@stop

@section('scripts')

	<script>

		activityApp.controllers.activityController = ['$scope', '$http', function($scope, $http) {

			$scope.favourites = {{$activities->toJSON()}};
			$scope.attending = [];

			$scope.getFavourites = function() {
				$http.get('/active/public/api/favourites').then(function(response) {
					$scope.favourites = response.data;
				});
			};

			$scope.removeFavourite = function(id) {
				$http.post('removeFavourite/' + id).then(function(response) {
					$scope.getFavourites();
				});
			};

			$scope.isAttending = function(id) {
				$http.get('/active/public/api/activity/isAttending/' + id).then(function(response) {
					$scope.attending.push({id: response.data.attending});
				});	
			};

		}];

		activityApp.boot();

	</script>

@stop