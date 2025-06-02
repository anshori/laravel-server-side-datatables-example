@extends('layouts.template')

@section('style')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <style>
    #map {
      margin-top: 56px;
      height: calc(100dvh - 56px);
      width: 100%;
    }

    .dropdown-menu {
      background-color: #fff;
    }

    .dropdown-menu a {
      color: #333;
    }

    .dropdown-menu a:hover {
      background-color: #f8f8f8;
      color: #333;
    }

    .dropdown-divider {
      background-color: #e3e3e3;
    }

    .typeahead {
      background-color: #FFFFFF;
    }

    .tt-dropdown-menu {
      background-color: #FFFFFF;
      border: 1px solid rgba(0, 0, 0, 0.2);
      border-radius: 4px 4px 4px 4px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      margin-top: 4px;
      padding: 4px 0;
      width: 100%;
      max-height: 300px;
      overflow: auto;
    }

    .tt-suggestion {
      font-size: 14px;
      line-height: 20px;
      padding: 3px 10px;
    }

    .tt-suggestion.tt-cursor {
      background-color: #0097CF;
      color: #FFFFFF;
      cursor: pointer;
    }

    .tt-suggestion p {
      margin: 0;
    }

    .tt-suggestion+.tt-suggestion {
      border-top: 1px solid #ccc;
    }

    .typeahead-header {
      margin: 0 5px 5px 5px;
      padding: 3px 0;
      border-bottom: 2px solid #333;
    }

    .has-feedback .form-control-feedback {
      position: absolute;
      top: 2px;
      right: 0;
      display: block;
      width: 34px;
      height: 34px;
      line-height: 34px;
      text-align: center;
    }
  </style>
@endsection

@section('content')
  <div id="map"></div>
@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.5/typeahead.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script>
    let map = L.map('map').setView([-7.4401111, 110.4846954], 10);

    L.tileLayer('https://tile.f4map.com/tiles/f4_2d/{z}/{x}/{y}.png', {
      attribution: `<a href="" target="_blank" id="geojson_attribution">GeoJSON</a> | <a href="https://unsorry.net" target="_blank">unsorry</a>`,
    }).addTo(map);

    /* Overlay Layers */
    var highlight = L.geoJson(null);
    var highlightStyle = {
      stroke: false,
      fillColor: "#00FFFF",
      fillOpacity: 0.7,
      radius: 10
    };

    function clearHighlight() {
      highlight.clearLayers();
    }

    /* Clear feature highlight when map is clicked */
    map.on("click", function(e) {
      highlight.clearLayers();
    });

    // Get bounding box
    let precisionBbox = 5;
    mapMovement();
    map.addEventListener('moveend', mapMovement);

    /* Highlight search box text on click */
    $("#searchbox").click(function() {
      $(this).select();
    });

    /* Prevent hitting enter from refreshing the page */
    $("#searchbox").keypress(function(e) {
      if (e.which == 13) {
        e.preventDefault();
      }
    });

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
            highlight.clearLayers().addLayer(L.circleMarker([feature.geometry.coordinates[1], feature
              .geometry.coordinates[0]
            ], highlightStyle));
            highlight.addTo(map);
          },
          mouseover: function(e) {
            point.bindTooltip(feature.properties.name);
          },
        });
      },
    });

    /* Typeahead search functionality */
    $(document).one("ajaxStop", function() {
      var personsBH = new Bloodhound({
        name: "Persons",
        datumTokenizer: function(d) {
          return Bloodhound.tokenizers.whitespace(d.name);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
          url: "{{ route('api.persons.search') }}?search=%QUERY",
          filter: function(data) {
            return $.map(data, function(result) {
              return {
                name: result.name,
                lat: result.latitude,
                lng: result.longitude,
                source: "Persons",
                email: result.email,
                hometown: result.hometown,
                company: result.company,
                city: result.city,
                state: result.state
              };
            });
          },
          ajax: {
            beforeSend: function(jqXhr, settings) {
              settings.url += "&east=" + map.getBounds().getEast() + "&west=" + map.getBounds().getWest() +
                "&north=" + map.getBounds().getNorth() + "&south=" + map.getBounds().getSouth();
              $("#searchicon").removeClass("fa-magnifying-glass").addClass("fa-rotate fa-spin");
            },
            complete: function(jqXHR, status) {
              $('#searchicon').removeClass("fa-rotate fa-spin").addClass("fa-magnifying-glass");
            }
          }
        },
        limit: 10
      });
      personsBH.initialize();

      $("#searchbox").typeahead({
        minLength: 3,
        highlight: true,
        hint: false
      }, {
        name: "Persons",
        displayKey: "name",
        source: personsBH.ttAdapter(),
        templates: {
          header: "<h4 class='typeahead-header'><img src='{{ asset('assets/images/user-tag-solid.svg') }}' width='25' height='25'>&nbsp;Persons</h4>"
        }
      }).on("typeahead:selected", function(obj, datum) {
        if (datum.source === "Persons") {
          map.setView([datum.lat, datum.lng], 16);
          highlight.clearLayers().addLayer(L.circleMarker([datum.lat, datum.lng], highlightStyle));
          highlight.addTo(map);
        }
        if ($(".navbar-collapse").height() > 50) {
          $(".navbar-collapse").collapse("hide");
        }
      }).on("typeahead:opened", function() {
        $(".navbar-collapse.in").css("max-height", $(document).height() - $(".navbar-header").height());
        $(".navbar-collapse.in").css("height", $(document).height() - $(".navbar-header").height());
      }).on("typeahead:closed", function() {
        $(".navbar-collapse.in").css("max-height", "");
        $(".navbar-collapse.in").css("height", "");
      });
      $(".twitter-typeahead").css("position", "static");
      $(".twitter-typeahead").css("display", "block");
    });

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

      $.getJSON(geojsonUrl, function(data) {
        point.addData(data);
        map.addLayer(point);
      });
    }
  </script>
@endsection
