<div id="activities">

	@foreach($activities as $activity)

		@include('_partials.client.activity', ['activity' => $activity])

		<hr>

	@endforeach

	<?php 
		$appends = [
			'day' 			=> Input::get('day'),
			'postcode' 		=> Input::get('postcode'),
			'terms' 		=> Input::get('terms'),
			'class_type_id' => Input::get('class_type_id'),
			'distance' 		=> Input::get('distance')
		]; 
	?>

	{{ $activities->appends($appends)->links() }}

</div>