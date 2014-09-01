@extends('layouts.full')

@section('title', $user->first_name . ' ' . $user->last_name . ' Profile')

@section('content')

	@foreach( $user->actions as $action )
		{{ var_dump($action->getComponents()) }}
	@endforeach

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
						@include('_partials.instructor.activities', ['activities' => $user->activities])
					</div>
					<div class="tab-pane" id="following">
						@if( !$user->following->isEmpty() )
							@foreach( $user->following as $following)
								@include('_partials.users.excerpt', ['user' => $following])
							@endforeach
						@else
							<div class="alert alert-info">
								{{ $user->first_name }} is not yet following anyone!
							</div>
						@endif
					</div>
					<div class="tab-pane" id="followers">
						@if( !$user->followers->isEmpty() )
							@foreach( $user->followers as $follower)
								@include('_partials.users.excerpt', ['user' => $follower])
							@endforeach
						@else
							<div class="alert alert-info">
								{{ $user->first_name }} does not yet have any followers!
							</div>
						@endif
					</div>
				</div>

			</div>
		</div>
	</article>

@stop