@section('title', 'Marketing Materials')

@section('content')

	{{ Form::open(['route' => 'marketing.download', 'method' => 'GET']) }}
		<input type="hidden" value="marketing.pdf" name="view" />
		<input type="hidden" value="test" name="filename" />
		<button type="submit" class="btn btn-success">Download</button>
	{{ Form::close() }}

@stop