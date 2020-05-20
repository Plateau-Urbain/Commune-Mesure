<div class='container-pop'>
	<div>
		@foreach ($images as $image)
			<span><img src='{{ url('/images/'.$image) }}' ></span>
		@endforeach
		<h1>{{ $title }}</h1>
	</div>
	<div>
	    <p>La diversité au service de nos quartiers.</p>
	    <span><a href={{ route('place.show', ['slug' => $name ]) }}>Plus d'info</a></span>
	</div>
</div>
