<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel Server Side DataTables Example</title>
  <link href="https://unsorry.net/assets-date/images/favicon.png" rel="shortcut icon" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  @yield('style')
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-dark fixed-top" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class="bi bi-boxes"></i> {{ $title }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('datatables') }}"><i class="bi bi-table"></i>
              DataTables</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('table') }}"><i class="bi bi-table"></i>
              Table Pagination</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('map') }}"><i class="bi bi-geo-alt-fill"></i>
              Map</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#" data-bs-toggle="modal" data-bs-target="#infoModal"><i
                class="bi bi-info-circle-fill"></i> Info</a>
          </li>
        </ul>
        @if ($page == 'map')
          <form class="d-block has-feedback" role="search">
            <div class="form-floating">
              <input id="searchbox" class="form-control bg-light text-dark" type="text" placeholder="Search"
                aria-label="Search">
              <i class="fa-solid fa-magnifying-glass form-control-feedback" id="searchicon"></i>
            </div>
          </form>
        @endif
      </div>
    </div>
  </nav>

  @yield('content')

  <!-- Modal -->
  <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="infoModalLabel"><i class="bi bi-info-circle-fill"></i> Info</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>
          <h6>Features:</h6>
          <ul>
            <li>Display 25000 people data using server side datatables</li>
            <li>Display 25000 points on the map, the number of which is limited to a maximum of 100 points based on the
              bounding box</li>
          </ul>
          </p>
          <p>
          <h6>Stack:</h6>
          <ul>
            <li><a href="https://laravel.com/" target="_blank" rel="noopener noreferrer">Laravel 12</a></li>
            <li><a href="https://github.com/yajra/laravel-datatables" target="_blank" rel="noopener noreferrer">Package
                laravel-datatables</a></li>
            <li><a href="https://datatables.net/" target="_blank" rel="noopener noreferrer">DataTables</a></li>
            <li><a href="https://getbootstrap.com/" target="_blank" rel="noopener noreferrer">Bootstrap 5</a></li>
            <li><a href="https://leafletjs.com/" target="_blank" rel="noopener noreferrer">LeafletJS</a></li>
          </ul>
          </p>
          <p>
          <h6>Repository:</h6>
          <a href="https://github.com/anshori/laravel-server-side-datatables-example" target="_blank"
            rel="noopener noreferrer">https://github.com/anshori/laravel-server-side-datatables-example</a>
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

  @yield('script')

</body>

</html>
