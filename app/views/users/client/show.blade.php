@extends('layouts.full')

@section('title', $user->first_name . ' ' . $user->last_name . '\'s Profile')

@section('content')

	<div class="row">
		<div class="col-sm-4">
			@if($user->avatar)
				<a href="{{ URL::route('users.show', $user->id) }}"><img src="{{ URL::asset($user->avatar) }}" alt="" /></a>
			@else
				<img src="http://placehold.it/150" alt="" />
			@endif
			<h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
			<a href="{{ URL::route('user.follow', $user->id) }}" class="btn btn-success">Follow</a>
			@include('_partials.elements.sendMessage', compact('user'))
			<p>Followers: 
				<span class="text-info">
					<a href="{{ URL::route('user.followers', $user->id) }}">{{ count($user->followers) }}</a>
				</span>
			</p>
			<p>Following: 
				<span class="text-info">
					<a href="{{ URL::route('user.following', $user->id) }}">{{ count($user->following) }}</a>
				</span>
			</p>
			<hr />
			@if( $website = $user->userable->website )
				<p><a href="{{ $website }}">{{ $website }}</a></p>
			@endif
			@if( $facebook = $user->userable->facebook )
				<p><a href="{{ $facebook }}">{{ $website }}</a></p>
			@endif
			@if( $twitter = $user->userable->twitter )
				<p><a href="{{ $twitter }}">{{ $twitter }}</a></p>
			@endif
			@if( $youtube = $user->userable->youtube )
				<p><a href="{{ $youtube }}">{{ $youtube }}</a></p>
			@endif
			@if( $instagram = $user->userable->instagram )
				<p><a href="{{ $instagram }}">{{ $instagram }}</a></p>
			@endif
			<hr />
			<h4>Activities</h4>
			<hr />
			@if( $bio = $user->userable->bio )
				<h4>Bio</h4>
				{{ $bio }}
			@endif
		</div>
		<div class="col-sm-8">
			
			@foreach( $user->stream() as $action )

				@include('_partials.elements.action')

			@endforeach

		</div>
	</div>

@stop