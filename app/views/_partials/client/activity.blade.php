<article class="activity activity-excerpt">
	<div class="row">
		<div class="col-sm-3">
			@include('_partials.activities.avatar', compact('activity'))
		</div>
		<div class="col-sm-9">
			<h4><a href="{{ $activity->getLink() }}">{{ $activity->getName() }}</a></h4>
			<h5>
				Suitable for: <strong>{{ $activity->getLevel() }}</strong>
				<span class="pull-right">
					Host Rating:
					@include('_partials.elements.averageRating', ['instructor' => $activity->instructor])
				</span>
			</h5>
			<div class="row">
				<div class="col-md-6">
					<p>{{ $activity->getDescription() }}</p>
				</div>
				<div class="col-md-6">
					@include('_partials.elements.bookActivity', compact('activity'))
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<p>Time: {{ $activity->getTime() }} Date: {{ $activity->getDate() }}</p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<p class="pull-right">
				Tweet Share on Facebook
			</p>
			<p class="pull-left">
				<a href="{{ URL::route('users.show', $activity->instructor->id) }}">{{ $activity->instructor->getName() }}</a>
			</p>
		</div>
	</div>
</article>