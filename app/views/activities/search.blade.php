@section('title', 'Search Results')

@section('content')

	<div class="row">
		<div class="col-md-4">
			@include('_partials.search.advanced')	
		</div>
		<div class="col-md-8">
			<div id="activities">
				@if( !$activities->isEmpty() )
					@foreach( $activities as $activity )
						@include('_partials.client.activity')
						<hr />
					@endforeach
				@else
					<div class="alert alert-info">No activities found</div>
				@endif
			</div>
		</div>
	</div>
@stop

@section('scripts')

	<script src="js/search.js"></script>

@stop