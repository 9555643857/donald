<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $table = 'promocodes';

    protected $fillable = ['code', 'reward','data','is_disposable','expires_at'];

				
	public $timestamps = false;
 
	

}
