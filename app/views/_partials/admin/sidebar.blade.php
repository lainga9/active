@if( $links )

	@foreach( $links as $link)

		<a href="{{ $link['url'] }}">{{ $link['name'] }}</a>

	@endforeach

@endif