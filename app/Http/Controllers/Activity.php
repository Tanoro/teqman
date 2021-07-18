<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Activity extends Controller
{
    /**
	* Show the currently open jobs
	*
	* @return \Illuminate\Http\Response
	**/
	public function view()
	{
		$activity = DB::table('timetrack AS tt')
		->select(
			'tt.jid',
			'tt.started',
			'tt.stopped',
			'tt.notes',
			't.subject',
			't.website',
			'p.hourfee',
			'c.customer'
		)
		->join('jobtickets AS t', 'tt.jid', '=', 't.jid')
		->join('projects AS p', 't.pid', '=', 'p.pid')
		->join('customers AS c', 'p.cid', '=', 'c.cid')
		->orderBy('tt.started', 'desc')
		->limit(100)
		->get()
		->each(function($row) {
			$row->totalHours = ($row->stopped - $row->started) / 60 / 60;
			$row->fee = ($row->totalHours * $row->hourfee);

			if ($row->stopped != 0)
			{
				$row->totalHours = number_format($row->totalHours, 2);
				$row->stopped = date('M j Y, g:ia', $row->stopped);
				$row->fee = '$' . number_format($row->fee, 2);
			}
			else
			{
				$row->totalHours = 2;
				$row->stopped = 'In Progress';
				$row->fee = '0.00';
			}
		});

		return view('activity', ['activity' => $activity]);
	}
}
