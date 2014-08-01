@extends('layouts.full')

@section('title', 'Search Results')

@section('content')

	<div class="row">
		<div class="col-md-4">
			@include('_partials.search.advanced')	
		</div>
		<div class="col-md-8">
			<div id="activities"></div>
			<div id="pagination"></div>
		</div>
	</div>
@stop

@section('scripts')

@stop