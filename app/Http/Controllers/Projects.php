<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Projects extends Controller
{
	// View projects
	public function list()
	{
		$rows = DB::table('projects AS p')
		->select('p.pid','p.cid','p.priority','p.projecttitle','c.customer')
		->join('customers AS c', 'p.cid', '=', 'c.cid')
		->orderBy('p.projecttitle')
		->get();

		return view('projects', ['rows' => $rows]);
	}

	// Show the Add Projects form
	public function add()
	{

	}

	// Insert new project record
	public function post()
	{

	}

	// View edit project form
	public function edit($id)
	{

	}

	// Save the post from the Edit Project form
	public function save($id)
	{

	}

	// View a project detail record
	public function view($id)
	{
		$UTCTIME = Carbon::now("UTC")->timestamp;
		$teqAvg = [];
		$totals = new \stdClass;
		$totals->hours = 0;
		$totals->teqAvg = 0;
		
		// Derived tables
		$calcEstTime = DB::table('jobtickets')
		->select(
			'pid',
			DB::raw('COUNT(*) AS taskNum'),
			DB::raw('SUM(estimatedhours) AS totalHours')
		)
		->groupBy('pid');

		$calcRealTime = DB::table('jobtickets AS j')
		->select('j.pid', DB::raw('ROUND((SUM(t.stopped) - SUM(t.started)) / 60 / 60, 2) AS hoursSpent'))
		->join('timetrack AS t', 'j.jid', '=', 't.jid')
		->where('t.stopped', '!=', 0)
		->groupBy('j.pid');
		
		// Get project header information
		$project = DB::table('projects AS p')
		->select(
			'p.pid',
			'p.dateadded',
			'p.priority',
			'p.projecttitle',
			'p.hourfee',
			'c.customer',
			'j.taskNum',
			'j.totalHours',
			DB::raw('ROUND(j.totalHours * p.hourfee, 2) estIncome'),
			't.hoursSpent',
			DB::raw('ROUND(t.hoursSpent * p.hourfee, 2) totalIncome')
		)
		->join('customers AS c', 'p.cid', '=', 'c.cid')
		->join(DB::raw('(' . $calcEstTime->toSql() . ') AS j'), function($join) {
			$join->on('p.pid', '=', 'j.pid');
		})
		->mergeBindings($calcEstTime)
		->join(DB::raw('(' . $calcRealTime->toSql() . ') AS t'), function($join) {
			$join->on('p.pid', '=', 't.pid');
		})
		->mergeBindings($calcRealTime)
		->where('p.pid', $id)
		->first();

		// Get the hours closed and Time Efficiency Quotient
		$totalHours = DB::table('timetrack')
		->select('jid', DB::raw('ROUND((SUM(stopped) - SUM(started)) / 60 / 60, 2) totalHours'))
		->where('stopped', '!=', 0)
		->groupBy('jid');
		
		$teq = DB::table('jobtickets AS t')
		->select(
			DB::raw('SUM(s.totalHours) closedHours'),
			DB::raw('ROUND(AVG((s.totalHours/t.estimatedhours) * 100), 2) teq')
		)
		->leftJoin(DB::raw('(' . $totalHours->toSql() . ') AS s'), function($join) {
			$join->on('t.jid', '=', 's.jid');
		})
		->mergeBindings($totalHours)
		->where('t.pid', $id)
		->first();

		// Get open jobs
		$totalHours = DB::table('timetrack')->select('jid', DB::raw('ROUND((SUM(stopped - started)) / 60 / 60, 2) totalHours'))->where('stopped', '!=', 0)->groupBy('jid');
		$priority = DB::table('jobtickets AS t')
		->select('t.jid',DB::raw('(t.priority + p.priority + c.priority + (SELECT COUNT(*) FROM timetrack r WHERE r.jid = t.jid)) priority'))
		->join('projects AS p', 't.pid', '=', 'p.pid')
		->join('customers AS c', 'p.cid', '=', 'c.cid');

		$jobs = DB::table('jobtickets AS t')
		->select(
			't.jid',
			't.subject',
			't.website',
			't.addedby',
			't.opened',
			't.closed',
			't.description',
			't.jobtype',
			't.status',
			'c.customer',
			'p.projecttitle',
			't.estimatedhours',
			's.totalHours',
			DB::raw('ROUND((s.totalHours/t.estimatedhours) * 100, 2) AS teq'),
			't.priority AS jobpriority',
			'p.priority AS projectpriority',
			'c.priority AS customerpriority',
			DB::raw('(SELECT COUNT(*) FROM timetrack r WHERE r.jid = t.jid) sessScore'),
			'pri.priority',
			DB::raw('(SELECT u.username FROM timetrack t2 LEFT JOIN users u ON (t2.userid = u.userid) WHERE t2.jid = t.jid AND t2.stopped = 0) claimed'),
		)
		->leftJoin(DB::raw('(' . $totalHours->toSql() . ') AS s'), function($join) {
			$join->on('t.jid', '=', 's.jid');
		})
		->mergeBindings($totalHours)
		->join('projects AS p', 't.pid', '=', 'p.pid')
		->join('customers AS c', 'p.cid', '=', 'c.cid')
		->join(DB::raw('(' . $priority->toSql() . ') AS pri'), function($join) {
			$join->on('t.jid', '=', 'pri.jid');
		})
		->mergeBindings($priority)
		->where([
			['p.pid', '=', $id],
			['t.opened', '<', $UTCTIME]
		])
		->orderBy('t.opened', 'desc')
		->get();

		foreach($jobs as $row)
		{
			$totals->hours += $row->estimatedhours;

			if (!empty($row->teq))
			{
				$teqAvg[] = $row->teq;
			}
		}

		// Get totals
		$totals->teqAvg = number_format(count($teqAvg) != 0 ? array_sum($teqAvg) / count($teqAvg) : 0, 2);
		
		return view('viewProjectJobs', [
			'project' => $project,
			'teq' => $teq,
			'jobs' => $jobs,
			'totals' => $totals
		]);
	}

	// Delete a project
	public function delete($id)
	{

	}
}
