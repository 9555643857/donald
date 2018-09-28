<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'restaurant_order';

    protected $fillable = ['user_id','menu_id','restaurant_id','cod', 'item_price','quantity','address_id','payment_id','status','created_date'];
	
	public function menu() 
    { 
		 $this->belongsTo('\App\Menu');
	}
	
	public function user() 
    { 
		 $this->belongsTo('\App\User');
	}
}
