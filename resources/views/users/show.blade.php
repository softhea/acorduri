@extends('layouts.bootstrap')

@section('content')

<h1>{{ __('User') }}: {{ $user->getUsername() }}</h1>

<h4>{{ __('Name') }}: {{ $user->getName() }}</h4>
<p>{{ __('No of tabs') }}: {{ $user->getNoOfTabs() }}</p>
<p>{{ __('No of artists') }}: {{ $user->getNoOfArtists() }}</p>
<p>{{ __('No of views') }}: {{ $user->getNoOfViews() }}</p>

@endsection