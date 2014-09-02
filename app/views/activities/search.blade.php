@extends('layouts.full')

@section('title', 'Search Results')

@section('content')

	<div class="row">
		<div class="col-sm-12">
			@include('_partials.search.advanced')
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<img src="http://placehold.it/400&amp;text=Advertising+Space" alt="" style="margin-bottom: 20px;" />
			<img src="http://placehold.it/400&amp;text=Advertising+Space" alt="" />
		</div>
		<div class="col-md-8">
			<div id="results"></div>
		</div>
	</div>
@stop