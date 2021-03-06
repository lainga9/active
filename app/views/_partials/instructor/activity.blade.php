<article class="activity instructor">
	<table>
		<tr>
			<th>Activity</th>
			<th>Description</th>
			<th>Venue</th>
			<th>Time</th>
			<th>No of Bookings</th>
		</tr>
		<tr>
			<td><a href="{{ URL::route('activities.show', $activity->id) }}">{{ $activity->name }}</a></td>
			<td>{{ $activity->description }}</td>
			<td>{{ $activity->street_address }}</td>
			<td>{{ $activity->time_from }} until {{ $activity->time_until }}</td>
			<td>{{ count($activity->clients) }}</td>
		</tr>
	</table>
	@if( $activity->createdBy() )
		<div class="actions clearfix">
			<div class="pull-left">
				<a class="text-success" href="{{ URL::route('activities.edit', $activity->id) }}">Edit Activity</a>
				<a class="text-success" href="{{ URL::route('activities.create', $activity->createSimilarString()) }}">Create Similar Activity</a>
			</div>
		</div>
	@endif
</article>