@extends('layouts.bootstrap')

@section('content')
<h1>{{ __('Artisti') }}</h1>

@if (Session::has('message'))
    <div class="alert alert-success mt-5">
		{{ Session::get('message') }}
    </div>
@endif

@if (Auth::check())
	<a href="{{ route('artists.create') }}" class="btn btn-primary">{{ __('Adauga') }}</a>
@endif

<form class="form-inline mt-2" action="" method="GET">
	<div class="row">
		<div class="form-group col-11">
			<input type="text" class="form-control" name="search" value="<?=$search?>">
		</div>
		<button type="submit" class="btn btn-primary col-1">{{ __('Cauta') }}</button>
	</div>
</form>

<table class="table table-striped mt-2">
	<thead>
		<tr>
			<th>{{ __('Artist') }}</th>       
			<th>{{ __('Numar de tabulaturi') }}</th>        
			<th>{{ __('Vizualizari') }}</th> 
		</tr>
	</thead>
	<tbody>
		@foreach ($artists as $artist)
			<tr>
				<td><a href="{{ route('artists.show', ['artist' => $artist->id]) }}">{{ $artist->name }}</a></td>
				<td>{{ $artist->no_of_tabs }}</td>
				<td>{{ $artist->no_of_views }}</td>
				@if (Auth::check() && Auth::user()->id === $artist->user_id)
					<td>
						<div class="btn-group" role="group">
							<a href="{{ route('artists.edit', ['artist' => $artist->id]) }}" class="btn btn-warning">Modifica</a>
							<form class="btn btn-danger p-0" method="POST" 
									action="{{ route('artists.destroy', ['artist' => $artist->id]) }}">
								@csrf
								@method('DELETE')
								<input type="submit" class="btn btn-danger delete-button" value="{{ __('Sterge') }}">
							</form>
						</div>
					</td>                
				@endif
			</tr>
		@endforeach
	</tbody>
</table>

@endsection