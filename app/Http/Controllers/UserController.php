<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class UserController extends Controller{

	/**
     * Return a JSON response having all users.
     *
     * @var  JSON  $users
     * @return JSON
     */

	public function show()
	{	
		$users = User::all();
		return $this->success($users, 200);
	}

	/**
     * Return a JSON response with information about a specific user.
     *
     * @param int $id
     * @var  JSON  $user
     * @return JSON
     */

	public function find($id)
	{	
		$user = User::find($id);
		return $this->success($user, 200);
	}

	/**
     * Create a new user. Insert into database a new user.
     *
     * @param Request $request 
     * @return JSON
     */

	public function insert(Request $request)
	{	
		$this->validate($request, [
				'id' => 'required',
				'email' => 'required',
				'FirstName' =>'required',
				'LastName' => 'required',
				'Birthday' => 'required'
				]);

		// if ($validator->fails()) {
  //           $message = $validator->errors();
  //           $this->SetStatusCode(404);
  //           return $this->RespondWithError($message);
  //       }

		$user = User::create([		
					'id' => $request->get('id'),
					'email' => $request->get('email'),
					'FirstName' =>$request->get('FirstName'),
					'Birthday' =>date('Y-m-d', strtotime(str_replace('-', '/', $request->get('Birthday')))),
					'LastName' =>$request->get('LastName')
					
				]);

		return $this->success("Welcome!", 200);
	}

}
