@extends('layouts.bootstrap')

@section('content')

<h3>{{ __('Acord') }}: {{ $chord->chord }}</h3>

<div id="chord_" style="width: 136px; height: 173px; z-index: 9999; display: block;" >
    <img src="{{ URL('images/chords/chord_' . $chord->chord . '.jpg') }}" />
</div>

@endsection