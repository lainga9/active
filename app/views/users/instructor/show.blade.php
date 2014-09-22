@extends('layouts.full')

@section('title', $user->first_name . ' ' . $user->last_name . ' Profile')

@section('content')

	@if( Auth::user()->isAdmin() )
		<a href="{{ URL::route('user.suspend', $user->id) }}" class="btn btn-danger">Suspend</a>
	@endif

	<article class="instructor">
		<div class="row">
			<div class="col-md-4">
				@include('_partials.users.profile', compact('user'))
			</div>
			<div class="col-md-8">

				<ul class="nav nav-tabs" role="tablist">
					<li class="active"><a href="#activities" role="tab" data-toggle="tab">Activities</a></li>
					<li><a href="#following" role="tab" data-toggle="tab">Following</a></li>
					<li><a href="#followers" role="tab" data-toggle="tab">Followers</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="activities">
						@include('_partials.elements.timetable', ['activities' => $user->makeTimetable($user)])
						<hr />
						@include('_partials.instructor.activities', ['activities' => $user->instructorActivities()])
					</div>
					<div class="tab-pane" id="following">
						@include('_partials.elements.following', compact('user'))
					</div>
					<div class="tab-pane" id="followers">
						@include('_partials.elements.followers', compact('user'))
					</div>
				</div>

			</div>
		</div>
	</article>

@stop