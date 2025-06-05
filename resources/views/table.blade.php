@extends('layouts.template')

@section('style')
  <link href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap5.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.bootstrap5.css" rel="stylesheet">
	<style>
		.card {
			margin-top: 76px; /* Adjust for fixed navbar */
		}
	</style>
@endsection

@section('content')
  <div class="container-fluid my-4">
    <div class="card">
      <div class="card-header">
        <h5><i class="bi bi-people-fill"></i> Persons</h5>
      </div>
      <div class="card-body">
        <div class="row mb-2">
          <div class="col-sm-12 col-md-4 offset-md-8">
            <form class="d-flex" role="search" method="GET" action="{{ route('table') }}">
              <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search"/>
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="table-persons">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Hometown</th>
                <th>City</th>
                <th>State</th>
                <th>Company</th>
								<th>Coordinates</th>
                <th class="text-nowrap">Created At</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($persons as $index => $person)
                <tr>
                  <td class="text-center">{{ $persons->firstItem() + $index }}</td>
                  <td>{{ $person->name }}</td>
                  <td>{{ $person->email }}</td> 
                  <td>{{ $person->hometown }}</td>
                  <td>{{ $person->city }}</td>
                  <td>{{ $person->state }}</td>
                  <td>{{ $person->company }}</td>
                  <td><a href="https://www.google.com/maps/search/?api=1&query={{ $person->latitude }},{{ $person->longitude }}" target="_blank" rel="noopener noreferrer">{{ $person->latitude }},{{ $person->longitude }}</a></td>
                  <td class="text-nowrap">{{ $person->created_at->format('d M Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          {{ $persons->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
@endsection
