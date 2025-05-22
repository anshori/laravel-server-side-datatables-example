@extends('layouts.template')

@section('style')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <style>
    #map {
      height: calc(100dvh - 56px);
      width: 100%;
    }
  </style>
@endsection

@section('content')
  <div id="map"></div>
@endsection

@section('script')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script>
    let map = L.map('map').setView([-7.4401111,110.4846954], 10);

    L.tileLayer('https://tile.f4map.com/tiles/f4_2d/{z}/{x}/{y}.png', {
      attribution: `<a href="" target="_blank" id="geojson_attribution">GeoJSON</a> | <a href="https://unsorry.net" target="_blank">unsorry</a>`,
    }).addTo(map);

    // Get bounding box
    let precisionBbox = 5;
    mapMovement();
    map.addEventListener('moveend', mapMovement);

    function mapMovement() {
      // clear all layers
      map.eachLayer(function(layer) {
        if (layer instanceof L.GeoJSON) {
          map.removeLayer(layer);
        }
      });

      // Get bounding box
      let ymin = map.getBounds().getSouth().toFixed(precisionBbox);
      let xmin = map.getBounds().getWest().toFixed(precisionBbox);
      let ymax = map.getBounds().getNorth().toFixed(precisionBbox);
      let xmax = map.getBounds().getEast().toFixed(precisionBbox);

      console.log('ymin: ' + ymin);
      console.log('xmin: ' + xmin);
      console.log('ymax: ' + ymax);
      console.log('xmax: ' + xmax);

			let geojsonUrl = `{{ route('api.geojson') }}?xmin=${xmin}&xmax=${xmax}&ymin=${ymin}&ymax=${ymax}`;

			$('#geojson_attribution').attr('href', geojsonUrl);

      // GeoJSON Point
      var point = L.geoJSON(null, {
        onEachFeature: function(feature, layer) {
					let popup = `<table class="table table-sm">
							<tr>
								<th>Name</th>
								<td>:</td>
								<td>${feature.properties.name}</td>
							</tr>
							<tr>
								<th>Email</th>
								<td>:</td>
								<td>${feature.properties.email}</td>
							</tr>
							<tr>
								<th>Hometown</th>
								<td>:</td>
								<td>${feature.properties.hometown}</td>
							</tr>
							<tr>
								<th>Company</th>
								<td>:</td>
								<td>${feature.properties.company}</td>
							</tr>
						</table>`;
          layer.on({
            click: function(e) {
              point.bindPopup(popup);
            },
            mouseover: function(e) {
              point.bindTooltip(feature.properties.name);
            },
          });
        },
      });
      $.getJSON(geojsonUrl, function(data) {
        point.addData(data);
        map.addLayer(point);
      });
    }
  </script>
@endsection
