<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonModel extends Model
{
	use HasFactory;
	
	protected $table = 'persons';
	protected $guarded = ['id'];

	public function geojson()
	{
		return [
			'type' => 'Feature',
			'geometry' => [
				'type' => 'Point',
				'coordinates' => [
					$this->longitude,
					$this->latitude,
				],
			],
			'properties' => [
				'id' => $this->id,
				'name' => $this->name,
				'email' => $this->email,
				'hometown' => $this->hometown,
				'city' => $this->city,
				'state' => $this->state,
				'company' => $this->company,
			],
		];
	}

	public function search($query)
	{
		return $this->where('name', 'ilike', "%{$query}%");
	}
}
