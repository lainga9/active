<article class="activity activity-excerpt">
	<div class="row">
		<div class="col-sm-3">
			<img src="http://placehold.it/150x150" alt="Avatar" />
		</div>
		<div class="col-sm-9">
			<h4><a href="{{ URL::route('activities.show', $activity->id) }}">{{ $activity->name }}</a></h4>
			<h5>
				Suitable for: 
				<strong>
					@if($activity->level)
						{{ $activity->level->name }}
					@else
						N/A
					@endif
				</strong>
				<span class="pull-right">
					Host Rating:
					@if( $rating = $activity->instructor->userable->getAverageFeedback() )
						{{ $rating }}
					@else
						No Reviews
					@endif
				</span>
			</h5>
			<div class="row">
				<div class="col-md-6">
					<p>{{ $activity->description}}</p>
				</div>
				<div class="col-md-6">
					@include('_partials.elements.bookActivity', compact('activity'))
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<p>Time: {{ $activity->time_from}} - {{ $activity->time_until}} Date: {{ $activity->date }} Address: {{ $activity->street_address }}</p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<p class="pull-right">
				Tweet Share on Facebook
			</p>
			<p class="pull-left">
				@if($activity->isFavourite())
					@include('_partials.elements.removeFavourite', ['activity' => $activity])
				@else
					@include('_partials.elements.addFavourite', ['activity' => $activity])
				@endif
				<a href="{{ URL::route('users.show', $activity->instructor->id) }}">
					{{ $activity->instructor->first_name }}
					{{ $activity->instructor->last_name }}
				</a>
			</p>
		</div>
	</div>
</article>