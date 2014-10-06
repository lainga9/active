{{ Form::open(['route' => ['activity.findCover', $activity->id], 'method' => 'PUT']) }}
	<button type="submit" class="btn btn-warning">Find Cover</button>
{{ Form::close() }}