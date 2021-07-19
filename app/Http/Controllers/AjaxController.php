<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Config;

class AjaxController extends Controller
{
	public function notfound(Request $request)
	{
		return view('ajax-request');
	}
	
	public function test(Request $request)
	{
		$data = $request->all();

		#create or update your data here

		$response['success'] = 'Ajax request submitted successfully';

		// JSON response array
		return response()->json($response);
	}
}
