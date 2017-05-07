<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\User;
use Gate;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return a JSON response for success.
     *
     * @param  array  $data
     * @param  string $code
     * @return \Illuminate\Http\JsonResponse
     */
	public function success($data, $code)
    {
		return response()->json(['data' => $data, 'code' => $code]);
	}

    /**
     * Return a JSON response for error.
     *
     * @param  array  $message
     * @param  string $code
     * @return \Illuminate\Http\JsonResponse
     */
	public function error($message, $code, $fields=null)
    {
		return response()->json(['message' => $message, 'code' => $code, 'fields' => $fields]);
	}
}
