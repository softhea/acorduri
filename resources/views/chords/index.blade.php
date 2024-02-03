@extends('layouts.bootstrap')

@section('content')
<h1>{{ __('Acorduri') }}</h1>

<table class="table table-striped">
	<thead>
		<tr>
			<th>{{ __('Acord') }}</th>       
			<th>{{ __('Numar de tabulaturi') }}</th>        
		</tr>
	</thead>
	<tbody>
		@foreach ($chords as $chord)
			<tr>
				<td>
					<a href="{{ route('chords.show', ['chord' => $chord->id]) }}" class="chord" chord_id="chord_{{ $chord->chord }}">{{ $chord->chord }}</a>
					<div id="chord_{{ $chord->chord }}" style="position: absolute; top: 0; left: 0; width: 136px; height: 173px; z-index: 9999; display: none;" >
						<img src="{{ URL('images/chords/chord_' . $chord->chord . '.jpg') }}" />
					</div>
				</td>
				<td>{{ $chord->no_of_tabs }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@endsection