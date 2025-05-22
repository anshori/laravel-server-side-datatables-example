<?php

namespace App\Http\Controllers;

use App\Models\PersonModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TableController extends Controller
{
  public function json()
	{
		return DataTables::of(PersonModel::query()->limit(50))->addIndexColumn()->toJson();
	}

	public function datatables()
	{
		$data = [
			'title' => 'DataTables',
			'page' => 'datatables',
		];

		return view('datatable', $data);
	}
}
