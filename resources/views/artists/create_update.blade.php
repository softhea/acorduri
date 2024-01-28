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
            action="{{ route('artists.update', ['artist' => $artist->id]) }}"
        @endif
>
    @csrf
    @if (request()->routeIs('artists.edit'))
        @method('PATCH')
    @endif
    <div class="form-group">
        <label for="artist">{{ __('Artist') }}</label>
        <input type="text" class="form-control" name="name" aria-describedby="nameHelp" 
            value="{{ old('name') ?? (isset($artist) ? $artist->name : '') }}"
        >
        <small id="nameHelp" class="form-text text-muted">
            {{ __('Numele artistului trebuie sa fie unic') }}
        </small>
    </div>
    <button type="submit" class="btn btn-primary mt-3">
        @if (request()->routeIs('artists.create'))
            {{ __('Adauga') }}
        @else
            {{ __('Modifica') }}
        @endif
    </button>
</form>

@endsection