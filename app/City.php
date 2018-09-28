<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model {
	//

	public $timestamps = false;

	protected $fillable = ['city_name'];
}
