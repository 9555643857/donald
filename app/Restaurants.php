<?php

namespace App;

use App\Categories;
use App\Menu;
use App\Order;
use Illuminate\Database\Eloquent\Model;

class Restaurants extends Model
{
    protected $table = 'restaurants';

    protected $fillable = ['user_id','restaurant_type', 'restaurant_name','restaurant_slug','restaurant_description','restaurant_address','availablity','type','packages_available','is_trail_available','lat','lng','delivery_time','delivery_charge','restaurant_logo','open_monday','open_tuesday','open_wednesday','open_thursday','open_friday','open_saturday','open_sunday'];


	public $timestamps = false;
 
	public function restaurants()
    {
        return $this->hasMany('App\Restaurants', 'id');
    }
	
	public static function getRestaurantsInfo($id) 
    { 
		return Restaurants::find($id);
	}

	public static function getUserRestaurant($id) 
    { 
		return Restaurants::where('user_id',$id)->count(); 
	}


	public static function getMenuCategories($id) 
    { 
		return Categories::where('restaurant_id',$id)->count(); 
	}

	public static function getMenuItems($id) 
    { 
		return Menu::where('restaurant_id',$id)->count(); 
	}

	public static function getOrders($id) 
    { 
		return Order::where('restaurant_id',$id)->count(); 
	}

	public static function getTotalRestaurants() 
    { 
		return Restaurants::count(); 
	} 


	public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("restaurant_address", "LIKE","%$keyword%")
                    ->orWhere("restaurant_name", "LIKE", "%$keyword%");                     
            });
        }
        return $query;
    }

    public static function getRestaurantOwnerInfo() 
    { 
		$rest=Restaurants::find($id);

		return User::find($rest->user_id);
	}

}
