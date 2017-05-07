<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller{

	public function show()
	{	
		$users = User::all();
		return $this->success($users,200);
	}

}
