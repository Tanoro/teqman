<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Users extends Controller
{
    public function view()
	{
		$rows = DB::table('users')->select('userid','usergroup','username','email','firstname','lastname')->orderBy('username')->get();
		return view('users', ['rows' => $rows]);
	}
}
