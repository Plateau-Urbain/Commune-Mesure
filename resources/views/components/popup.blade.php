{{-- Attention, use ' instead of " --}}
<div class='card'>

    @if($images != "")
        <div class='card-image'>
            <figure class='image'>
                <img src='{{ url('/images/lieux/'.$images) }}' alt='Image lieu'>
            </figure>
        </div>
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
