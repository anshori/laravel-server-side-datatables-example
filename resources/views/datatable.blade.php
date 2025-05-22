@extends('layouts.template')

@section('style')
  <link href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap5.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.bootstrap5.css" rel="stylesheet">
@endsection

@section('content')
  <div class="container-fluid my-4">
    <div class="card">
      <div class="card-header">
        <h5>Persons</h5>
      </div>
      <div class="card-body">
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
          </table>
        </div>
      </div>
      <div class="card-footer text-end">
        <small>
          <a href="{{ route('api.json') }}" target="_blank" rel="noopener noreferrer">JSON Data</a>
        </small>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.print.min.js"></script>
  <script>
    $(function() {
      new DataTable('#table-persons', {
        processing: true,
        serverSide: true,
        ajax: '{!! route('api.json') !!}', // URL API
        columns: [{ 
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false,
            className: 'text-center'
          },
          {
            data: 'name',
            name: 'name'
          },
          {
            data: 'email',
            name: 'email'
          },
          {
            data: 'hometown',
            name: 'hometown'
          },
          {
            data: 'city',
            name: 'city'
          },
          {
            data: 'state',
            name: 'state'
          },
          {
            data: 'company',
            name: 'company'
          },
          {
						render: function(data, type, row) {
							return '<a href="https://www.google.com/maps/search/?api=1&query=' + row.latitude + ',' + row.longitude + '" target="_blank" rel="noopener noreferrer">' + row.latitude + ',' + row.longitude + '</a>';
						},
          },
          {
            data: 'created_at',
            render: function(data, type, row) {
              var zulutime = new Date(data);
              var localtime = new Date(zulutime).toLocaleString('id-ID', {
                timeZone: 'Asia/Jakarta',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
              });
              return localtime.replace(',', '');
            },
            name: 'created_at',
            className: 'text-center'
          }
        ],
        layout: {
          bottomStart: {
            buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
            ]
          },
          bottom: 'info'
        }
      });
    });
  </script>
@endsection
