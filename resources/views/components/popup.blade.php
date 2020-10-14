{{-- Attention, use ' instead of " --}}
<div class='card'>
    @if (count($images))
    @if($images[0])
        <div class='card-image'>
            <figure class='image'>
                <img src='{{ url('/images/lieux/'.$images[0]) }}' alt='Image lieu'>
            </figure>
        </div>
    @endisset
    @endif

    <div class='card-content'>
        <div class='content'>
            <p class='title is-4'><a href='{{ route('place.show', ['slug' => $name]) }}'>{{ $name }}</a></p>
            <p class='subtitle is-6'>{{ $city }} ({{ $departement }})</p>
            <p>{{ $description }}</p>
            <br/><br/>
            <a href='{{ route('place.show', ['slug' => $name]) }}' class='btn-voir-lieu button is-default'>Voir ce lieu</a>
        </div>
    </div>
</div>
