@extends('layouts.bootstrap')

@section('content')

<h1>{{ __('Users') }}</h1>

<form class="form-inline mt-2" action="" method="GET">
	<div class="row">
		<div class="form-group col-11">
			<input type="text" class="form-control" name="search" value="<?=$search?>">
		</div>
		<button type="submit" class="btn btn-primary col-1">{{ __('Search') }}</button>
	</div>
</form>
<table class="table table-striped mt-2">
	<thead>
		<tr>
			<th>{{ __('Username') }}</th>
			<th>{{ __('Name') }}</th>
			<th>{{ __('No of tabs') }}</th>        
			<th>{{ __('No of artists') }}</th>
			<th>{{ __('No of views') }}</th> 
		</tr>
	</thead>
	<tbody>
		@foreach ($users as $user)
			<tr>
				<td><a href="{{ route('users.show', ['user' => $user->getId()]) }}">{{ $user->getUsername() }}</a></td>
				<td>{{ $user->getName() }}</td>
				<td>{{ $user->getNoOfTabs() }}</td>
				<td>{{ $user->getNoOfArtists() }}</td>
				<td>{{ $user->getNoOfViews() }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

@endsection