@extends('layouts.bootstrap')

@section('content')

<h1>{{ __('Utilizatori') }}</h1>

@if ($errors->any())
    <div class="alert alert-danger mt-5">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
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
			<th>{{ __('Username') }}</th>
			<th>{{ __('Nume') }}</th>
			<th>{{ __('Numar de tabulaturi') }}</th>        
			<th>{{ __('Numar de artisti') }}</th>
			<th>{{ __('Vizualizari') }}</th> 
		</tr>
	</thead>
	<tbody>
		@foreach ($users as $user)
			<tr>
				<td><a href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->username }}</a></td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->no_of_tabs }}</td>
				<td>{{ $user->no_of_artists }}</td>
				<td>{{ $user->no_of_views }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@endsection