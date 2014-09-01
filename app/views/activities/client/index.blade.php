@section('title', 'Activities')

@section('content')

	<ul class="nav nav-tabs" role="tablist">
		<li class="active"><a href="#activities" role="tab" data-toggle="tab">Activities</a></li>
		<li><a href="#network" role="tab" data-toggle="tab">Network</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="activities">
		
			@if( !$activities->isEmpty() )

				@include('_partials.client.activities', compact('activities'))

			@else

				<div class="alert alert-info">
					No Activities
				</div>

			@endif
		</div>
		<div class="tab-pane" id="network">
			@include('_partials.elements.socialStream', compact('user'))
		</div>
	</div>

@stop

@section('sidebar')

	@include('_partials.search.basic')
	
@stop