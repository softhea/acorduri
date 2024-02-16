@extends('layouts.bootstrap')

@section('content')

<h1>{{ __('Tabs') }}</h1>

@if (Session::has('message'))
    <div class="alert alert-success mt-5">
		{{ Session::get('message') }}
    </div>
@endif

@if (Auth::check())
	<a href="{{ route('tabs.create') }}" class="btn btn-primary">{{ __('Create') }}</a>
@endif

@foreach ($chords as $chord)
	<div id="chord_{{ $chord->getChord() }}" style="position: absolute; top: 0; left: 0; width: 136px; height: 173px; z-index: 9999; display: none;">
		<img src="{{ URL('images/chords/chord_' . $chord->getChord() . '.jpg') }}" />
	</div>
@endforeach

<table class="table table-striped mt-2">
	<thead>
		<tr>
			<th>{{ __('Song') }}</th>
			<th>{{ __('Artist') }}</th>
			<th>{{ __('User') }}</th>
			<th>{{ __('Chords') }}</th>        
			<th>{{ __('No of chords') }}</th>        
			<th>{{ __('No of views') }}</th> 
		</tr>
		<tr>
			<form action="" method="GET">
				<th><input type="text" name="name" class="form-control" value="<?=$searchName?>"></th>
				<th>
					<select name="artist_id" class="form-control">
						<option value="">{{ __('Select') }}</option>
						@foreach ($artists as $artist) 
							<option value="{{ $artist->id }}"
								@if ((int) $searchArtistId === $artist->id) selected @endif
							>
								{{ $artist->name }}
							</option>
						@endforeach
					</select>
				</th>
				<th>
					<select name="user_id" class="form-control">
						<option value="">{{ __('Select') }}</option>
						@foreach ($users as $user) 
							<option value="{{ $user->id }}"
								@if ((int) $searchUserId === $user->id) selected @endif
							>
								{{ $user->username }}
							</option>
						@endforeach
					</select>
				</th>
				<th>
					<select multiple name="chord_ids[]" id="chord_ids" class="form-control"
						multiselect-search="true" 
						multiselect-select-all="false" 
						multiselect-hide-x = "false"
					>
						@foreach ($chords as $chord)
							<option value="{{ $chord->getId() }}"
								@if (null !== $searchChordIds && in_array($chord->getId(), $searchChordIds)) selected @endif
							>{{ $chord->getChord() }}</option>
						@endforeach
					</select>
				</th>
				<th><input type="number" name="no_of_chords" id="search_no_of_chords" class="form-control" value="<?=$searchNoOfChords?>"></th>      
				<th><button class="btn btn-success" type="submit">{{ __('Search') }}</button></th>
			</form>
    	</tr>
	</thead>
	<tbody>
		@foreach ($tabs as $tab)
			<tr>
				<td>
					<a href="{{ route('tabs.show', ['tab' => $tab->getId()]) }}" >
						{{ $tab->getName() }}
					</a>
				</td>
				<td>
					@if (null !== $tab->getArtistId())
						<a href="{{ route('artists.show', ['artist' => $tab->getArtistId()]) }}" >
							{{ $tab->getArtist()->getName() }}
						</a>
					@else
						N/A
					@endif
				</td>
				<td>
					@if (null !== $tab->getUserId())
						<a href="{{ route('users.show', ['user' => $tab->getUserId()]) }}" >
							{{ $tab->getUser()->getUsername() }}
						</a>
					@else
						N/A
					@endif					
				</td>
				<td>        
					@if (count($tab->getChords()) > 0)
						@foreach ($tab->chords as $i => $chord)
							<a href="{{ route('chords.show', ['chord' => $chord->getId()]) }}" 
									class="chord" chord_id="chord_{{ $chord->chord }}">
								{{ $chord->chord }}
							</a>&nbsp;
						@endforeach
					@endif
				</td>
				<td>{{ $tab->getNoOfChords() }}</td>
				<td>{{ $tab->getNoOfViews() }}</td>
				@if (
					Auth::check() 
					&& (
						Auth::user()->getId() === $tab->getUserId()
						|| Auth::user()->isAdmin()
					)
				)
					<td>
						<div class="btn-group" role="group">
							<a href="{{ route('tabs.edit', ['tab' => $tab->getId()]) }}" class="btn btn-warning">
								{{ __('Update') }}
							</a>
							<form class="btn btn-danger p-0" method="POST" 
									action="{{ route('tabs.destroy', ['tab' => $tab->getId()]) }}">
								@csrf
								@method('DELETE')
								<input type="submit" class="btn btn-danger delete-button" 
										value="{{ __('Delete') }}">
							</form>
						</div>
					</td>                
				@endif
			</tr>
		@endforeach
	</tbody>
</table>

@endsection