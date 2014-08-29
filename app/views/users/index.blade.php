@section('title', 'Users')

@section('content')

	@if( !$users->isEmpty() )

		@foreach( $users as $user )

			@include('_partials.users.excerpt', compact('user'))

		@endforeach

	@else

		<div class="alert alert-info">No results found</div>

	@endif

@stop