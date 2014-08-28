@section('title', 'Search Results')

@section('content')

	@if( !$users->isEmpty() )

		@foreach( $users as $user )

			@include('_partials.users.excerpt', compact('user'))

		@endforeach

	@else

		<div class="alert alert-info">No people found!</div>

	@endif

@stop

@section('sidebar')

	@include('_partials.search.basic')

@stop