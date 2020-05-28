@extends('layout')

@section('header.submenu')
    @include('components.header-submenu')
@endsection

@section('content')
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
    </div>
@endsection
