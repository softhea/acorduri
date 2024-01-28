@extends('layouts.bootstrap')

@section('content')

<h1>{{ __('Artist') }}: {{ $artist->name }}</h1>
<p>{{ __('Adaugat de utilizatorul') }}: <a href="{{ route('users.show', ['user' => $artist->user['id']]) }}">{{ $artist->user['username'] }}</a></p>
<p>{{ __('Numar de tabulaturi') }}: {{ $artist->no_of_tabs }}</p>
<p>{{ __('Vizualizari') }}: {{ $artist->no_of_views }}</p>

@endsection