@extends('layouts.full')

@section('title', $user->first_name . ' ' . $user->last_name . '\'s Profile')

@section('content')

	<div class="row">
		<div class="col-sm-4">
			@include('_partials.users.profile', compact('user'))
		</div>
		<div class="col-sm-8">
			
			@foreach( $user->socialStream() as $action )

				@include('_partials.elements.action')

			@endforeach

		</div>
	</div>

@stop