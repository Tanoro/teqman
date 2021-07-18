<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Config;

class Jobs extends Controller
{
	/**
	* Show the currently open jobs
	**/
	public function list()
	{
		$rows = DB::table('jobtickets AS t')
		->select(
			't.jid',
			't.subject',
			't.website',
			't.addedby',
			't.opened',
			't.closed',
			't.priority',
			't.description',
			't.jobtype',
			'p.priority AS projpriority',
			'p.projecttitle'
		)
		->join('projects AS p', 't.pid', '=', 'p.pid')
		->orderBy('p.priority', 'desc')
		->orderBy('t.priority', 'desc')
		->limit(100)
		->get();

		return view('jobs', ['rows' => $rows]);
	}

	// Show the Add Job form
	public function add()
	{
		$timenow = Carbon::now()->format('Y-m-d');
		$jobsConfig = Config::get('custom.jobs');
		$projects = DB::table('projects')->select('pid','projecttitle')->orderBy('projecttitle')->get();
		$customers = DB::table('customers')->select('cid','customer')->orderBy('customer')->get();
		$users = DB::table('users')
		->select("userid", DB::raw("CONCAT(SUBSTRING(firstname, 1, 1), '. ', lastname) fullname"))
		->orderBy('firstname')
		->orderBy('lastname')
		->get();

		return view('addjob', [
			'jobtype' => $jobsConfig['jobtype'],
			'status' => $jobsConfig['status'],
			'projects' => $projects,
			'customers' => $customers,
			'users' => $users,
			'timenow' => $timenow
		]);
	}

	/**
	* View a job
	*
	* @param  int  $id
	**/
	public function view($id)
	{
		$UTCTIME = Carbon::now("UTC")->timestamp;
		
		$job = DB::table('jobtickets AS j')
		->select(
			'p.pid',
			'p.projecttitle',
			'p.cid',
			'j.jid',
			'j.subject',
			'j.opened',
			'j.closed',
			'j.description',
			'j.filename',
			'j.jobtype',
			'j.website',
			'j.status',
			'j.estimatedhours',
			'p.hourfee',
			'c.customer',
			DB::raw('(SELECT t.userid FROM timetrack t WHERE t.jid = j.jid AND t.stopped = 0) AS claimedby')
		)
		->join('projects AS p', 'j.pid', '=', 'p.pid')
		->join('customers AS c', 'p.cid', '=', 'c.cid')
		->where('j.jid', $id)
		->first();

		$jobtype = Config::get('custom.jobs.jobtype');
		$job->jobtype = $jobtype[ $job->jobtype ];
		$job->estimatedFee = ($job->estimatedhours * $job->hourfee);

		if (!empty($job->website))
		{
			$job->website = (substr($job->website, 0, 4) == 'http' ? $job->website : 'http://' . $job->website);
		}

		$attachments = DB::table('attachments')->select('id','original','filename','filesize','dateadded')->where('jid', $id)->get();

		$sessions = DB::table('timetrack AS t')
		->select('t.tid','t.userid','t.started','t.stopped','t.notes','u.username','u.avatar')
		->join('users AS u', 't.userid', '=', 'u.userid')
		->where('t.jid', $id)
		->get();

		$totaltime = 0;
		$totalFee = 0;
		
		foreach($sessions AS $row)
		{
			// Get the total time spent in this session
			$row->totalTime = ($row->stopped == 0 ? 0 : number_format(( ( ($row->stopped - $row->started) / 60) / 60 ), 2));
			// Developer Note: I am not yet able to bold tag the session notes until I can get the highlight string out of the GET input
			//$row->notes = (isset($_GET['highlight']) ? bold_string($search, nl2br(parseJob($row->notes))) : nl2br(parseJob($row->notes)));

			// Accumulate total time and fee
			if ($row->stopped != 0)
			{
				$totaltime += ($row->stopped - $row->started);
			}
			else
			{
				$totaltime += ($UTCTIME - $row->started);
			}
		}

		$totaltime = number_format(( ($totaltime / 60) / 60 ), 2);
		$totalFee = $totaltime * $job->hourfee;

		return view('viewjob', [
			'job' => $job,
			'attachments' => $attachments,
			'sessions' => $sessions,
			'totaltime' => $totaltime,
			'totalFee' => $totalFee
		]);
	}
}
