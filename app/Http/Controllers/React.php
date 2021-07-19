<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class React extends Controller
{
	/**
	* Show the currently open jobs
	*
	* @return \Illuminate\Http\Response
	**/
	public function index()
	{
		return view('react');
	}
}
