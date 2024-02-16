@extends('layouts.bootstrap')

@section('content')
<h1>{{ __('Chords') }}</h1>

<table class="table table-striped">
	<thead>
		<tr>
			<th>{{ __('Chord') }}</th>       
			<th>{{ __('No of tabs') }}</th>        
		</tr>
	</thead>
	<tbody>
		@foreach ($chords as $chord)
			<tr>
				<td>
					<a href="{{ route('chords.show', ['chord' => $chord->getId()]) }}" class="chord" 
							chord_id="chord_{{ $chord->getChord() }}">
						{{ $chord->getChord() }}
					</a>
					<div id="chord_{{ $chord->getChord() }}" 
							style="position: absolute; top: 0; left: 0; width: 136px; height: 173px; z-index: 9999; display: none;" >
						<img src="{{ URL('images/chords/chord_' . $chord->getChord() . '.jpg') }}" />
					</div>
				</td>
				<td>{{ $chord->getNoOfTabs() }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@endsection