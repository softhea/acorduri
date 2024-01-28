@extends('layouts.bootstrap')

@section('content')

<h1>{{ __('Utilizator') }}: {{ $user->username }}</h1>

<h4>{{ __('Nume') }}: {{ $user->name }}</h4>
<p>{{ __('Numar de tabulaturi') }}: {{ $user->no_of_tabs }}</p>
<p>{{ __('Numar de artisti') }}: {{ $user->no_of_artists }}</p>
<p>{{ __('Numar de acorduri') }}: {{ $user->no_of_chords }}</p>
<p>{{ __('Vizualizari') }}: {{ $user->no_of_views }}</p>

@endsection