@extends('layouts.bootstrap')

@section('content')

<h3>{{ __('Chord') }}: {{ $chord->getChord() }}</h3>

<div style="width: 136px; height: 173px; z-index: 9999; display: block;" >
    <img src="{{ URL('images/chords/chord_' . $chord->getChord() . '.jpg') }}" />
</div>

@endsection