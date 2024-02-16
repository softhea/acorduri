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
        @if (request()->routeIs('tabs.create'))
            action="{{ route('tabs.store') }}"
        @else
            action="{{ route('tabs.update', ['tab' => $tab->getId()]) }}"
        @endif
>
    @csrf
    @if (request()->routeIs('tabs.edit'))
        @method('PATCH')
    @endif

	<div class="form-group">
        <label for="name">{{ __('Name') }}</label>
        <input type="text" class="form-control" name="name" aria-describedby="nameHelp" 
            value="{{ old('name') ?? (isset($tab) ? $tab->getName() : '') }}"
        >
        <small id="nameHelp" class="form-text text-muted">
            {{ __('Song Name') }}
        </small>
    </div>

	<div class="form-group">
        <label for="artist_id">{{ __('Artist') }}</label>
		<select name="artist_id" class="form-control" aria-describedby="artist_id_help">
			<option value="">{{ __('Select') }}</option>
			@foreach ($artists as $artist)
				<option value="{{ $artist->getId() }}"
					@if (
						(null !== old('artist_id') && (int) $artist->getId() === old('artist_id'))
						|| (null === old('artist_id') && isset($tab) && $artist->getId() === $tab->getArtistId())
					)
						selected
					@endif
				>{{ $artist->getName() }}</option>
			@endforeach
		</select>
        <small id="artist_id_help" class="form-text text-muted">
            {{ __('The Artist') }}
        </small>
    </div>

	<div class="form-group">
        <label for="text">{{ __('Tab') }}</label>
		<textarea class="form-control" name="text" aria-describedby="textHelp">{{ old('text') ?? (isset($tab) ? $tab->getText() : '') }}</textarea>
        <small id="textHelp" class="form-text text-muted">
            {{ __('Lyrics and Chords') }}
        </small>
    </div>

	<button type="submit" class="btn btn-primary mt-3">
        @if (request()->routeIs('tabs.create'))
            {{ __('Create') }}
        @else
            {{ __('Update') }}
        @endif
    </button>
</form>

@endsection