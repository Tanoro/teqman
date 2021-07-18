<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Customers extends Controller
{
    public function view()
	{
		$rows = DB::table('customers')->select('cid','customer','contact','priority')->orderBy('customer')->get();
		return view('customers', ['rows' => $rows]);
	}
}
