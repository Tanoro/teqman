<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Config;

class IndexController extends Controller
{
	/**
	* Show the currently open jobs
	*
	* @return \Illuminate\Http\Response
	**/
	public function index(Request $request)
	{
		$bold = null;

		if ($request->input('search'))
		{
			$bold = urlencode($request->input('search'));
		}

		$jobConfigs = Config::get('custom.jobs');

		// Fill the filter fields
		$filters = $this->setFilters($request);
		
		$priority = DB::table('jobtickets AS t')
			->selectRaw('t.jid, (t.priority + p.priority + c.priority + (SELECT COUNT(*) FROM timetrack r WHERE r.jid = t.jid)) priority')
			->join('projects AS p', 't.pid', '=', 'p.pid')
			->join('customers AS c', 'p.cid', '=', 'c.cid');
		
		$jobs = DB::table('jobtickets AS t')
		->select(
			't.jid',
			't.pid',
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
			't.priority AS jobpriority',
			'p.priority AS projectpriority',
			'c.priority AS customerpriority',
			DB::raw('(SELECT COUNT(*) FROM timetrack r WHERE r.jid = t.jid) AS sessScore'),
			'pri.priority',
			DB::raw('(SELECT u.username FROM timetrack t2 LEFT JOIN users u ON (t2.userid = u.userid) WHERE t2.jid = t.jid AND t2.stopped = 0) claimed')
		)
		->join('projects AS p', 't.pid', '=', 'p.pid')
		->join('customers AS c', 'p.cid', '=', 'c.cid')

		->join(DB::raw('(' . $priority->toSql() . ') AS pri'), function($join) {
			$join->on('pri.jid', '=', 't.jid');
		})
		->where('t.status', 1)
		->orderBy('t.closed', 'desc')
		->orderBy('pri.priority', 'desc')
		->orderBy('t.opened', 'desc')
		->get();

		foreach($jobs as $row)
		{
			$row->class = $this->setStatus($row->status, $row->claimed);
			$row->bold = $bold;
			$row->dateopened = date('M j, Y', $row->opened);
			$row->arrStatus = $jobConfigs['status'][ $row->status ];
		}

		return view('index', [
			'jobs' => $jobs,
			'status' => $jobConfigs['status'],
			'jobtype' => $jobConfigs['jobtype'],
			'cid' => DB::table('customers')->select('cid', 'customer')->orderBy('customer')->get(),
			'pid' => DB::table('projects')->select('pid', 'projecttitle')->orderBy('projecttitle')->get()
		]);
	}

	// Populate and pre-selecct the search filters
	private function setFilters($request)
	{
		// Create fields
		$fields = new \stdClass;

		$fields->cid = DB::table('customers')->select('cid', 'customer')->orderBy('customer')->get();
		$fields->pid = '';

		return $fields;
	}
	
	// Convert the status code into something readable for display
	private function setStatus($status, $claimed)
	{
		if (!empty($claimed))
		{
			return ' claimed';
		}

		if ($status == '0')
		{
			return ' closed';
		}

		if ($status == '2')
		{
			return ' hold';
		}

		return '';
	}
}


?>
