{{-- Attention, use ' instead of " --}}
<div class='card'>
    @if (count($images))
        <div class='card-image'>
            <figure class='image'>
                <img src='{{ url('/images/'.$images[0]) }}' alt='Image lieu'>
            </figure>
        </div>
    @endif

    <div class='card-content'>
        <div class='content'>
            <p class='title is-4'>{{ $name }}</p>
            <p class='subtitle is-6'>{{ $city }}</p>
            <p>La diversité au service de nos quartiers</p>
            <br>
            <a href='{{ route('place.show', ['slug' => $name]) }}'>Plus d'info</a>
        </div>
    </div>
</div>
