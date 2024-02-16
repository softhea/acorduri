@extends('layouts.bootstrap')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger mt-5">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" 
        @if (request()->routeIs('artists.create'))
            action="{{ route('artists.store') }}"
        @else
            action="{{ route('artists.update', ['artist' => $artist->getId()]) }}"
        @endif
>
    @csrf
    @if (request()->routeIs('artists.edit'))
        @method('PATCH')
    @endif
    <div class="form-group">
        <label for="artist">{{ __('Artist') }}</label>
        <input type="text" class="form-control" name="name" aria-describedby="nameHelp" 
            value="{{ old('name') ?? (isset($artist) ? $artist->getName() : '') }}"
        >
        <small id="nameHelp" class="form-text text-muted">
            {{ __('Name should be unique') }}
        </small>
    </div>
    <button type="submit" class="btn btn-primary mt-3">
        @if (request()->routeIs('artists.create'))
            {{ __('Create') }}
        @else
            {{ __('Update') }}
        @endif
    </button>
</form>

@endsection