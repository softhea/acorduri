@extends('layouts.bootstrap')

@section('content')

<h1>{{ __('Tab') }}</h1>

<h4>{{ $tab->getName() }}</h4>
<h5>{{ __('Artist') }}: 
	@if (null !== $tab->getArtistId())
		<a href="{{ route('artists.show', ['artist' => $tab->getArtistId()]) }}" >{{ $tab->getArtist()->getName() }}</a>
	@else
		N/A
	@endif
</h5>

<p>{{ __('Added by user') }}: <a href="{{ route('users.show', ['user' => $tab->getUserId()]) }}">{{ $tab->getUser()->getUsername() }}</a></p>
<p>{{ __('No of chords') }}: {{ $tab->getNoOfChords() }}</p>
<p>{{ __('No of views') }}: {{ $tab->getNoOfViews() }}</p>

@foreach ($tab->chords as $chord)
	<div id="chord_{{ $chord->getChord() }}" style="position: absolute; top: 0; left: 0; width: 136px; height: 173px; z-index: 9999; display: none;">
		<img src="{{ URL('images/chords/chord_' . $chord->getChord() . '.jpg') }}" />
	</div>
@endforeach

{!! $tab->getText() !!}

@endsection