@extends('layouts.main')

@section('title', $user->first_name . ' ' . $user->last_name . '\'s Profile')

@section('content')

	<div class="row">
		<div class="col-sm-4">
			<h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
			<a href="{{ URL::route('user.follow', $user->id) }}" class="btn btn-success">Follow</a>
			@include('_partials.elements.sendMessage', compact('user'))
		</div>
		<div class="col-sm-8">
			
		</div>
	</div>

@stop