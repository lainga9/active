<article class="activity activity-excerpt" ng-init="isAttending(favourite.id)" ng-repeat="favourite in favourites">
	<div class="row">
		<div class="col-sm-3">
			<img src="http://placehold.it/150x150" alt="Avatar" />
		</div>
		<div class="col-sm-9">
			<h4>@{{favourite.name}}</h4>
			<h5>
				Suitable for: <strong>@{{favourite.level_id}}</strong>
				<span class="pull-right">
					Host Rating:
				</span>
			</h5>
			<div class="row">
				<div class="col-md-6">
					<p>@{{favourite.description}}</p>
				</div>
				<div class="col-md-6">
					<div ng-hide="attending">Attending</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<p>Time: @{{favourite.time}} Date: @{{favourite.date}} Address: @{{favourite.street_address}}</p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<p class="pull-right">
				Tweet Share on Facebook
			</p>
			<p class="pull-left">
				<a href="#" ng-if="favourite" ng-click="removeFavourite(favourite.id)" class="btn btn-danger btn-sm">Remove Favourite</a>
				@{{favourite.instructor.first_name}}
				@{{favourite.instructor.last_name}}
			</p>
		</div>
	</div>
</article>