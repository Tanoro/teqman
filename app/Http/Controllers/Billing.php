<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Billing extends Controller
{
	/**
	* Show the currently open jobs
	*
	* @return \Illuminate\Http\Response
	**/
	public function index()
	{
		$totals = new \stdClass;
		$totals->billing = 0;
		$totals->hours = 0;

		$rows = DB::table('jobtickets AS j')
		->select(
			'j.jid',
			'j.subject',
			'c.customer',
			'p.hourfee',
			'j.claimedby',
			'u.firstname',
			'u.lastname',
			DB::raw('ROUND((SUM(t.stopped) - SUM(t.started)) / 60 / 60, 2) totalHours')
		)
		->join('timetrack AS t', 'j.jid', '=', 't.jid')
		->join('projects AS p', 'j.pid', '=', 'p.pid')
		->join('customers AS c', 'p.cid', '=', 'c.cid')
		->join('users AS u', 'j.claimedby', '=', 'u.userid')
		->where([
			['j.status', '=', 4],
			['t.stopped', '!=', 0]
		])
		->groupBy('j.jid')
		->get();

		foreach($rows AS $row)
		{
			$row->fee = ($row->totalHours * $row->hourfee);
			$row->fullname = trim(substr($row->firstname, 0, 1) . '. ' . $row->lastname);
			$totals->billing += $row->fee;
			$totals->hours += $row->totalHours;
		}
		
		return view('billing', [
			'rows' => $rows,
			'totals' => $totals
		]);
	}
}
