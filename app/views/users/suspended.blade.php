@section('title', 'Suspended Users')

@section('content')

	@if( !$users->isEmpty() )

		@foreach($users as $user)

			@include('_partials.users.excerpt', compact('user'))

		@endforeach

	@else

		<div class="alert alert-info">
			No Suspended Users
		</div>

	@endif

@stop