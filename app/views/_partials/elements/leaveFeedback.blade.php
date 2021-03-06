<a class="btn btn-primary" href="#" data-toggle="modal" data-target=".modal-feedback">Leave Feedback</a>

<div class="modal fade modal-feedback">

	{{ Form::open(['route' => ['feedback.store', $instructor->id]]) }}

		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">Leave Feedback</h4>
				</div>
				<div class="modal-body">

					<?php $feedbackable = Auth::user()->feedbackable($instructor); ?>
				
					@if(count($feedbackable))

						<div>Class Type</div>
						<p>
							{{ Form::select('activity_id', Base::toSelect($feedbackable)) }}
						</p>
						
						@foreach( FeedbackItem::all() as $item )

							<div>{{ $item->name }}</div>
							<p>
								{{ Form::select(
									$item->id, 
									[
										1 => '1',
										2 => '2',
										3 => '3',
										4 => '4',
										5 => '5'
									]
								) }}
							</p>

						@endforeach

					@else

						<div class="alert alert-info">You cannot leave feedback for this instructor</div>

					@endif

				</div>
				<div class="modal-footer">
					@if(count($feedbackable))
						<button type="submit" class="btn btn-success">Leave Feedback</button>
					@endif
				</div>
			</div>
		</div>
	{{ Form::close() }}
</div>