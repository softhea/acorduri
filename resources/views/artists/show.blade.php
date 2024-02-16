@extends('layouts.bootstrap')

@section('content')

<h1>{{ __('Artist') }}: {{ $artist->getName() }}</h1>
<p>
    {{ __('Added by user') }}:&nbsp;
    <a href="{{ route('users.show', ['user' => $artist->getUserId()]) }}">
        {{ $artist->getUser()->getUsername() }}
    </a>
</p>
<p>{{ __('No of tabs') }}: {{ $artist->getNoOfTabs() }}</p>
<p>{{ __('No of views') }}: {{ $artist->getNoOfViews() }}</p>

@endsection