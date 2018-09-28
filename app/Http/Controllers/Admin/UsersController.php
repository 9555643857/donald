<?php

namespace App\Http\Controllers\Admin;

use App\Restaurants;
use App\User;
use App\Address;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Input;

class UsersController extends MainAdminController {
	public function __construct() {
		$this->middleware('auth');

		parent::__construct();

	}
	public function userslist() {

		if (Auth::User()->usertype != "Admin") {

			\Session::flash('flash_message', 'Access denied!');

			return redirect('admin/dashboard');

		}

		$allusers = User::where('usertype', '=', 'User')->orderBy('status')->get();
		return view('admin.pages.users', compact('allusers'));
	}

	public function merchants() {

		if (Auth::User()->usertype != "Admin") {

			\Session::flash('flash_message', 'Access denied!');

			return redirect('admin/dashboard');

		}

		$users = User::where('usertype', '=', 'Merchant')->orderBy('status')->get();
		$allusers = $users->map(function ($user) {
			$restaurant = Restaurants::where(['user_id' => $user->id])->first();
			if ($restaurant) {
				$user->restaurant_name = $restaurant->restaurant_name;
				$user->restaurant_id = $restaurant->id;
			} else {
				$user->restaurant_name = "";
				$user->restaurant_id = 0;
			}
			return $user;
		});

		return view('admin.pages.merchants', compact('allusers'));
	}

	public function addeditUser() {

		if (Auth::User()->usertype != "Admin") {

			\Session::flash('flash_message', 'Access denied!');

			return redirect('admin/dashboard');

		}

		return view('admin.pages.addeditUser');
	}

	public function addMerchant(Request $request) {
		$data = \Input::except(array('_token'));

		$inputs = $request->all();

		if (!empty($inputs['id'])) {
			$rule = array(
				'name' => 'required',
				'owner_mobile' => 'required',
				'mobile' => 'nullable',
				'email' => 'required|email|max:75',
			);

		} else {
			$rule = array(
				'first_name' => 'required',
				'owner_mobile' => 'required',
				'mobile' => 'nullable',
				'email' => 'required|email|max:75|unique:users',

			);
		}

		$validator = \Validator::make($data, $rule);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator->messages());
		}

		if (!empty($inputs['id'])) {

			$user = User::findOrFail($inputs['id']);
			if (!empty($inputs['restaurant_id'])) {
				$restaurant = Restaurants::where('id', $inputs['restaurant_id'])->update([
					'restaurant_name' => $inputs['restaurant_name'],
					'restaurent_contact_no' => $inputs['mobile'],
				]);
			}
		} else {

			$user = new User;

		}

		$user->usertype = $inputs['usertype'];
		$user->name = $user->first_name = $inputs['name'];

		$user->email = $inputs['email'];
		$user->mobile = $inputs['mobile'];
		$user->mobile_no = $inputs['owner_mobile'];
		$user->city = $inputs['city'];
		// $user->postal_code = $inputs['postal_code'];
		$user->address = $inputs['address'];
		// $user->status = $inputs['status'];

		$user->save();

		if (!empty($inputs['id'])) {

			\Session::flash('flash_message', 'Changes Saved');

			return \Redirect::back();
		} else {

			\Session::flash('flash_message', 'Added');

			return \Redirect::back();

		}

	}

	public function addnew(Request $request) {

		$data = \Input::except(array('_token'));

		$inputs = $request->all();

		if (!empty($inputs['id'])) {
			$rule = array(
				'first_name' => 'required',
				// 'last_name' => 'required',
				'email' => 'required|email|max:75',
			);

		} else {
			$rule = array(
				'first_name' => 'required',
				// 'last_name' => 'required',
				'email' => 'required|email|max:75|unique:users',

			);
		}

		$validator = \Validator::make($data, $rule);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator->messages());
		}

		if (!empty($inputs['id'])) {

			$user = User::findOrFail($inputs['id']);

		} else {

			$user = new User;

		}

		$user->usertype = $inputs['usertype'];
		$user->name = $user->first_name = $inputs['first_name'];
		// $user->last_name = $inputs['last_name'];
		// $user->email = $inputs['email'];
		$user->mobile_no = $inputs['mobile'];
		// $user->city = $inputs['city'];
		// $user->postal_code = $inputs['postal_code'];
		$user->address = $inputs['address'];
		$user->status = $inputs['status'];

		$user->save();

		if (!empty($inputs['id'])) {

			\Session::flash('flash_message', 'Changes Saved');

			return \Redirect::back();
		} else {

			\Session::flash('flash_message', 'Added');

			return \Redirect::back();

		}

	}

	public function editUser($id) {
		if (Auth::User()->usertype != "Admin") {

			\Session::flash('flash_message', 'Access denied!');

			return redirect('admin/dashboard');

		}

		$user = User::findOrFail($id);

		return view('admin.pages.addeditUser', compact('user'));

	}

	public function editMerchant($id) {
		if (Auth::User()->usertype != "Admin") {

			\Session::flash('flash_message', 'Access denied!');

			return redirect('admin/dashboard');

		}

		$user = User::findOrFail($id);
		$restaurant = Restaurants::where('user_id', $id)->first();
		$cities = \App\City::all();

		return view('admin.pages.addeditMerchant', compact('user', 'restaurant', 'cities'));

	}

	public function delete($id) {

		if (Auth::User()->usertype != "Admin") {

			\Session::flash('flash_message', 'Access denied!');

			return redirect('admin/dashboard');

		}

		$user = User::findOrFail($id);

		\File::delete(public_path() . '/upload/members/' . $user->image_icon . '-b.jpg');
		\File::delete(public_path() . '/upload/members/' . $user->image_icon . '-s.jpg');

		$user->delete();

		\Session::flash('flash_message', 'Deleted');

		return redirect()->back();

	}

	public function editAddress($id)
	{
		if (Auth::User()->usertype != "Admin") {

			\Session::flash('flash_message', 'Access denied!');

			return redirect('admin/dashboard');

		}

		$addresses = Address::where('user_id',$id)->get();

		// echo "<pre>";
		// print_r($addresses);
		// die();
		return view('admin.pages.editAddress', compact('addresses'));

	}

	public function editSingleAddress($id)
	{
		if (Auth::User()->usertype != "Admin") {

			\Session::flash('flash_message', 'Access denied!');

			return redirect('admin/dashboard');

		}

		$address = Address::where('id',$id)->first();

		return view('admin.pages.editSingleAddress', compact('address'));

	}


	public function saveAddresses(Request $request)
	{
		$inputs = Input::get();

		// echo "<pre>";
		// print_r($inputs);
		// die();

		$n =  $inputs['size'];
		for($i=0; $i<$n; $i++)
		{
			DB::table('addresses')
				->where('id',$inputs['id'][$i])
				->update(['flat_no'=>$inputs['flat_no'][$i] , 'colony'=>$inputs['colony'][$i] , 'state'=>$inputs['state'][$i] , 'city'=>$inputs['city'][$i] , 'area'=>$inputs['area'][$i] ,'pincode'=>$inputs['pincode'][$i] ,'lanmark'=>$inputs['landmark'][$i]]);
		}	

		return redirect()->back();
	}


	public function saveSingleAddresses(Request $request)
	{

		$inputs = Input::get();

			DB::table('addresses')
				->where('id',$inputs['id'])
				->update(['flat_no'=>$inputs['flat_no'] , 'colony'=>$inputs['colony'] , 'state'=>$inputs['state'] , 'city'=>$inputs['city'] , 'area'=>$inputs['area'] ,'pincode'=>$inputs['pincode'] ,'lanmark'=>$inputs['landmark']]);

		return redirect()->back();
	}

}
