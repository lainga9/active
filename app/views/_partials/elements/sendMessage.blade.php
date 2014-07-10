<a class="text-success" href="#" data-toggle="modal" data-target=".modal-message">Send a Message</a>

<div class="modal fade modal-message">
	{{ Form::open([
		'route' => [
			'messages.send',
			$activity->instructor->id
		]
	]) }}
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title">Send a message</h4>
				</div>
				<div class="modal-body">
					<div>Message</div>
					{{ Form::textarea('content') }}
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Send message</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	{{ Form::close() }}
</div><!-- /.modal -->