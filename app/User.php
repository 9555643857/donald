<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword,HasApiTokens,Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name','last_name', 'email', 'password','password_confirmation','status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    
    public static function getUserInfo($id) 
    { 
		return User::find($id);
	}

    public static function getUserFullname($id) 
    { 
        $userinfo=User::find($id);

        return $userinfo->first_name.' '.$userinfo->last_name;
    }
    
    public static function getTotalUsers() 
    { 
        return User::where('usertype', '=', 'User')->count(); 
    }  
    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }
}
