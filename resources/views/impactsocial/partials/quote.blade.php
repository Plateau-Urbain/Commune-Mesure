@php
    $charLimit = 300;
@endphp
<div class="quote">
        <span class="excerpt">{{ \Illuminate\Support\Str::limit($text, $charLimit, '') }}@if(mb_substr($text, -1) !== '.').@endif</span>
        @if (strlen($text) > $charLimit)
                <span class="dots">...</span>
                <span class="more">{{ $text }}</span>
            <button class="readmore">Lire la suite</button>
        @endif
</div>
