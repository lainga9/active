@extends('layouts.full')

@section('title', $user->first_name . ' ' . $user->last_name . ' Profile')

@section('content')

	<article class="instructor">
		<div class="row">
			<div class="col-md-4">
				<h5>Telephone: {{ $user->userable->phone }}</h5>
				<h5>Mobile: {{ $user->userable->mobile }}</h5>
				@include('_partials.elements.sendMessage', ['instructor' => $user])
			</div>
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-3">
						<img src="http://placehold.it/200x200" alt="" />
						<h5>Average Rating</h5>
						@include('_partials.elements.leaveFeedback', ['instructor' => $user])
					</div>
					<div class="col-md-9">
						<h3 class="text-success">{{ $user->first_name }} {{ $user->last_name }}</h3>
						<hr />
						<h4>Class Types</h4>
						@if( $classTypes = User::classTypes($user) )
							@foreach( $classTypes as $classType)
								{{ $classType->name }}, 
							@endforeach
						@else
							<p>No class types</p>
						@endif

						<h4>Bio:</h4>
						<p>{{ $user->userable->bio }}</p>
						<div class="row">
							<div class="col-md-4">
								<a href="{{ $user->userable->facebook }}">{{ $user->userable->facebook }}</a>
							</div>
							<div class="col-md-4">
								<a href="{{ $user->userable->twitter }}">{{ $user->userable->twitter }}</a>
							</div>
							<div class="col-md-4">
								<a href="{{ $user->userable->youtube }}">{{ $user->userable->youtube }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>

	<div class="row">
		<div class="col-md-4">
			@include('_partials.search.basic')
			<hr >
			<img src="http://placehold.it/400x300&amp;text=Advertising+Space" alt="" />
		</div>
		<div class="col-md-8">
			@include('_partials.elements.timetable', ['activities' => $activities = Activity::makeTimetable($user)])
		</div>
	</div>

@stop