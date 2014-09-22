@extends('layouts.full')

@section('title', $user->first_name . ' ' . $user->last_name . '\'s Profile')

@section('content')

	<div class="row">
		<div class="col-sm-4">
			@include('_partials.users.profile', compact('user'))
		</div>
		<div class="col-sm-8">

			<ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#recent" role="tab" data-toggle="tab">Recent Activity</a></li>
				<li><a href="#following" role="tab" data-toggle="tab">Following</a></li>
				<li><a href="#followers" role="tab" data-toggle="tab">Followers</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="recent">
					@include('_partials.elements.recentActivity', compact('user'))
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

@stop

@section('scripts')

	<script>

	jQuery(document).ready(function($) {

		var $stream = (function() {

		var $container = $('#recent'),

			init = function() {
				$container.infinitescroll({
					navSelector: "ul.pagination",
					nextSelector: "ul.pagination li.active + li a",
					itemSelector: "#recent article",
					loadingText: 'Loading more activity...',
					doneText: 'No more activity!'
				});
			};

			return {init: init};

		})();

		$stream.init();

	});

	</script>

@stop