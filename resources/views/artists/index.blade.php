@extends('layouts.bootstrap')

@section('content')
<h1>{{ __('Artists') }}</h1>

@if (Session::has('message'))
    <div class="alert alert-success mt-5">
		{{ Session::get('message') }}
    </div>
@endif

@if (Auth::check())
	<a href="{{ route('artists.create') }}" class="btn btn-primary">{{ __('Create') }}</a>
@endif

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
			<th>{{ __('Artist') }}</th>       
			<th>{{ __('No of tabs') }}</th>        
			<th>{{ __('No of views') }}</th> 
		</tr>
	</thead>
	<tbody>
		@foreach ($artists as $artist)
			<tr>
				<td><a href="{{ route('artists.show', ['artist' => $artist->getId()]) }}">{{ $artist->getName() }}</a></td>
				<td>{{ $artist->getNoOfTabs() }}</td>
				<td>{{ $artist->getNoOfViews() }}</td>
				@if (
					Auth::check() 
					&& (
						Auth::user()->getId() === $artist->getUserId()
						|| Auth::user()->isAdmin()
					)
				)
					<td>
						<div class="btn-group" role="group">
							<a href="{{ route('artists.edit', ['artist' => $artist->getId()]) }}" class="btn btn-warning">
								{{ __('Update') }}
							</a>
							<form class="btn btn-danger p-0" method="POST" 
									action="{{ route('artists.destroy', ['artist' => $artist->getId()]) }}">
								@csrf
								@method('DELETE')
								<input type="submit" class="btn btn-danger delete-button" value="{{ __('Delete') }}">
							</form>
						</div>
					</td>                
				@endif
			</tr>
		@endforeach
	</tbody>
</table>

@endsection