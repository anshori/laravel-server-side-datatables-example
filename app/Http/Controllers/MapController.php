<?php

namespace App\Http\Controllers;

use App\Models\PersonModel;
use Illuminate\Http\Request;

class MapController extends Controller
{
	public function __construct()
	{
		$this->persons = new PersonModel();
	}

	public function index()
	{
		$data = [
			'title' => 'Map',
			'page' => 'map',
		];

		return view('map', $data);
	}

	public function geojson(Request $request)
	{
		// test
		// http://localhost:8000/api/geojson?xmin=110.123&xmax=110.234&ymin=-7.289&ymax=-7.123

		// Get the bounding box coordinates from the request
		$xmin = $request->input('xmin');
		$ymin = $request->input('ymin');
		$xmax = $request->input('xmax');
		$ymax = $request->input('ymax');

		// Check if all coordinates are provided
		if (is_null($xmin) || is_null($ymin) || is_null($xmax) || is_null($ymax)) {
			return response()->json(['error' => 'Missing coordinates'], 400);
		}
		// Validate the coordinates
		if (!is_numeric($xmin) || !is_numeric($ymin) || !is_numeric($xmax) || !is_numeric($ymax)) {
			return response()->json(['error' => 'Invalid coordinates'], 400);
		}

		// Fetch persons within the bounding box limit to 100
		$this->persons = $this->persons->whereBetween('longitude', [$xmin, $xmax])
			->whereBetween('latitude', [$ymin, $ymax])->limit(100);

		// Convert to GeoJSON format
		$geojson = [
			'type' => 'FeatureCollection',
			'features' => $this->persons->get()->map(function ($person) {
				return $person->geojson();
			}),
		];
		return response()->json($geojson, 200, [], JSON_NUMERIC_CHECK);
	}
}
