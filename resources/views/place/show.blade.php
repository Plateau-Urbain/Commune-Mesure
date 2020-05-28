@extends('layout')

@section('header.submenu')
    @include('components.header-submenu')
@endsection

@section('content')
<section>
    <div class="container is-fluid">
        <h1 class="title is-1">{{ $place->name }}</h1>
        <h3 class="subtitle has-text-grey-light is-italic">Tags:
            @foreach ($place->tags as $tag)
                <a class="tag" href="/tag/{{ $tag }}" title="{{ $tag }}">{{ $tag }}</a>
            @endforeach
        </h3>

        <div class="content">{!! $place->description !!}</div>

        <div class="columns is-multiline">
        @foreach ($place->photos as $photo)
            <div class="column is-one-quarter has-text-centered">
                <img src="/images/{{ $photo }}" {{ getimagesize("images/$photo")[3] }}/>
            </div>
        @endforeach
        </div>
        <div class="hero is-dark" id="block-data-stat">
            <div class="columns">
                <div class="column">
                <span>
                    <img src="/images/visualization.svg" style="height: 25em">
                </span>
                </div>
                <div class="column">
                <span>
                <img src="/images/visualization2.svg">
                </span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
