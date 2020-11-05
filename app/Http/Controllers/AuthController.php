<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Group;

use App\Tools\Redis;
use App\Tools\Permission as storePermission;

class AuthController extends Controller {
	protected $redirectTo = '/';

	public function index() {
		$data = [];
		if (Auth::check()) {
			return redirect($this->redirectTo);
		}
		return view('login')->with($data);
	}
	public function authenticate(Request $request) {
		$req = [
			'email'=>$request->username,
			'password'=>$request->password
		];
		if (Auth::attempt($req)) {
			$user = Auth::user();
			$hashKey = Hash::make($user->password.$user->id);
			$user->hash = $hashKey;
			// store into session
			$request->session()->put('user',$user);

			$group = Group::find($user->group_id);
			
			$request->session()->put('group',$group);
			// get permission
			storePermission::setPermission($user->group_id);
			return response()->json([
				'status'=>true,
				'data'=>[],
				'errors'=>null,
				'redirect'=>[
					'page'=>''
				],
			]);
		}

		return response()->json([
			'status'=>false,
			'data'=>[],
			'errors'=>[
				'messages'=>'Invalid Username or Password',
			],
			'redirect'=>false,
		]);
	}
	public function forgot() {
		return view('forgot');

	}
	public function logout(Request $request) {
		Auth::logout();
		
		$request->session()->flush();

		return redirect('login');
	}
}