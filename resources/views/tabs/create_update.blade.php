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
            action="{{ route('tabs.update', ['tab' => $tab->id]) }}"
        @endif
>
    @csrf
    @if (request()->routeIs('tabs.edit'))
        @method('PATCH')
    @endif

	<div class="form-group">
        <label for="name">{{ __('Nume') }}</label>
        <input type="text" class="form-control" name="name" aria-describedby="nameHelp" 
            value="{{ old('name') ?? (isset($tab) ? $tab->name : '') }}"
        >
        <small id="nameHelp" class="form-text text-muted">
            {{ __('Numele melodiei') }}
        </small>
    </div>

	<div class="form-group">
        <label for="artist_id">{{ __('Artist') }}</label>
		<select name="artist_id" class="form-control" aria-describedby="artist_id_help">
			<option value="">Selecteaza</option>
			@foreach ($artists as $artist)
				<option value="{{ $artist->id }}"
					@if (
						(null !== old('artist_id') && (int) $artist->id === old('artist_id'))
						|| (null === old('artist_id') && isset($tab) && $artist->id === $tab->artist_id)
					)
						selected
					@endif
				>{{ $artist->name }}</option>
			@endforeach
		</select>
        <small id="artist_id_help" class="form-text text-muted">
            {{ __('Artistul') }}
        </small>
    </div>

	<div class="form-group">
        <label for="text">{{ __('Tabulatura') }}</label>
		<textarea class="form-control" name="text" aria-describedby="textHelp">{{ old('text') ?? (isset($tab) ? $tab->text : '') }}</textarea>
        <small id="textHelp" class="form-text text-muted">
            {{ __('Versuri si acorduri') }}
        </small>
    </div>

	<button type="submit" class="btn btn-primary mt-3">
        @if (request()->routeIs('tabs.create'))
            {{ __('Adauga') }}
        @else
            {{ __('Modifica') }}
        @endif
    </button>
</form>

@endsection