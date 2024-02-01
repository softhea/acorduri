@extends('layouts.bootstrap')

@section('content')
<h1>{{ __('Tabulaturi') }}</h1>

@if (Session::has('message'))
    <div class="alert alert-success mt-5">
		{{ Session::get('message') }}
    </div>
@endif

@if (Auth::check())
	<a href="{{ route('tabs.create') }}" class="btn btn-primary">{{ __('Adauga') }}</a>
@endif

@foreach ($chords as $chord)
	<div id="chord_{{ $chord }}" style="position: absolute; top: 0; left: 0; width: 136px; height: 173px; z-index: 9999; display: none;">
		<img src="{{ URL('images/chords/chord_' . $chord . '.jpg') }}" />
	</div>
@endforeach

<table class="table table-striped mt-2">
	<thead>
		<tr>
			<th>{{ __('Melodie') }}</th>
			<th>{{ __('Artist') }}</th>
			<th>{{ __('Utilizator') }}</th>
			<th>{{ __('Acorduri') }}</th>        
			<th>{{ __('Numar de acorduri') }}</th>        
			<th>{{ __('Vizualizari') }}</th> 
		</tr>
		<tr>
			<form action="" method="GET">
				<th><input type="text" name="name" class="form-control" value="<?=$searchName?>"></th>
				<th>
					<select name="artist_id" class="form-control">
						<option value="">Selecteaza</option>
						@foreach ($artists as $artist) 
							<option value="{{ $artist->id }}"
								@if ($searchArtistId === $artist->id) selected @endif
							>
								{{ $artist->name }}
							</option>
						@endforeach
					</select>
				</th>
				<th>
					<select name="user_id" class="form-control">
						<option value="">Selecteaza</option>
						@foreach ($users as $user) 
							<option value="{{ $user->id }}"
								@if ($searchUserId === $user->id) selected @endif
							>
								{{ $user->username }}
							</option>
						@endforeach
					</select>
				</th>
				<th><input type="text" name="chords" class="form-control" value="<?=$searchChords?>"></th>
				<th><input type="number" name="no_of_chords" id="search_no_of_chords" class="form-control" value="<?=$searchNoOfChords?>"></th>      
				<th><button class="btn btn-success" type="submit">{{ __('Cauta') }}</button></th>
			</form>
    	</tr>
	</thead>
	<tbody>
		@foreach ($tabs as $tab)
			<tr>
				<td><a href="{{ route('tabs.show', ['tab' => $tab->id]) }}" >{{ $tab->name }}</a></td>
				<td>
					@if (null !== $tab->artist)
						<a href="{{ route('artists.show', ['artist' => $tab->artist['id']]) }}" >
							{{ $tab->artist['name'] }}
						</a>
					@else
						N/A
					@endif
				</td>
				<td>
					@if (null !== $tab->user)
					<a href="{{ route('users.show', ['user' => $tab->user['id']]) }}" >
						{{ $tab->user['username'] }}
					</a>
					@else
						N/A
					@endif					
				</td>
				<td>        
					@if (count($tab->chords) > 0)
						@foreach ($tab->chords as $i => $chord)
							<a href="{{ route('chords.show', ['chord' => $chord->id]) }}" class="chord" chord_id="chord_{{ $chord->chord }}">{{ $chord->chord }}</a>&nbsp;
						@endforeach
					@endif
				</td>
				<td>{{ $tab->no_of_chords }}</td>
				<td>{{ $tab->no_of_views }}</td>
				@if (Auth::check() && Auth::user()->id === $tab->user_id)
					<td>
						<div class="btn-group" role="group">
							<a href="{{ route('tabs.edit', ['tab' => $tab->id]) }}" class="btn btn-warning">Modifica</a>
							<form class="btn btn-danger p-0" method="POST" 
									action="{{ route('tabs.destroy', ['tab' => $tab->id]) }}">
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