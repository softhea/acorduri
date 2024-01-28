@extends('layouts.bootstrap')

@section('content')

<h1>{{ __('Tabulatura') }}</h1>

<h4>{{ $tab->name }}</h4>
<h5>{{ __('Artist') }}: 
	@if (null !== $tab->artist)
		<a href="{{ route('artists.show', ['artist' => $tab->artist['id']]) }}" >{{ $tab->artist['name'] }}</a>
	@else
		N/A
	@endif
</h5>

<p>{{ __('Adaugata de utilizatorul') }}: <a href="{{ route('users.show', ['user' => $tab->user['id']]) }}">{{ $tab->user['username'] }}</a></p>
<p>{{ __('Numar de acorduri') }}: {{ $tab->no_of_chords }}</p>
<p>{{ __('Vizualizari') }}: {{ $tab->no_of_views }}</p>

@foreach ($tab->chords as $chord)
	<div id="chord_{{ $chord['chord'] }}" style="position: absolute; top: 0; left: 0; width: 136px; height: 173px; z-index: 9999; display: none;">
		<img src="{{ URL('images/chords/chord_' . $chord['chord'] . '.jpg') }}" />
	</div>
@endforeach

{!! $tab->text !!}

@endsection