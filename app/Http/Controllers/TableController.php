<?php

namespace App\Http\Controllers;

use App\Models\PersonModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TableController extends Controller
{
	public function __construct()
	{
		$this->persons = new PersonModel();
	}

  public function json()
	{
		return DataTables::of($this->persons->limit(50))->addIndexColumn()->toJson();
	}

	public function datatables()
	{
		$data = [
			'title' => 'DataTables',
			'page' => 'datatables',
		];

		return view('datatable', $data);
	}

	public function table()
	{
		$data = [
			'title' => 'Table',
			'page' => 'table',
			'persons' => $this->persons
			->when(request('search'), function ($query) {
				$search = request('search');
				$query->where(function ($q) use ($search) {
					$q->where('name', 'ilike', "%{$search}%")
					  ->orWhere('email', 'ilike', "%{$search}%");
				});
			})
			->paginate(25),
		];

		return view('table', $data);
	}


}
