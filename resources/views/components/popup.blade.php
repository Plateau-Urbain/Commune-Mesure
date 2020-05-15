<h1>{{ $name }}</h1>
<div>
    <p>Lorem Ipsum</p>
    <p><a href={{ route('place.show', ['slug' => $name ]) }}>Plus d'info</a></p>
</div>
