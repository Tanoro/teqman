@extends('layouts.app')
@section('title')View Job - #{{ $job->jid }}@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ url('css/viewjob.css') }}" />
@endsection

@section('content')
{{--
* Project Header Information
********************************************************************************************************************
--}}
	<a href="/jobs/edit/{{ $job->jid }}" class="buttonLink"><input type="button" name="editjob" value="Edit Job" class="lgButton" /></a>
	<br>
	<div class="pseudoTab">{{ $job->subject }}</div>
	<div class="fieldsection flattop">
		<table class="default">
			<tbody>
				<tr>
					<td>
						<a href="/projects/view/{{ $job->pid }}" class="general" style="float: right;">{{ $job->projecttitle }}</a>
						<strong>{{ $job->customer }}</strong>
					</td>
					<td>Job Type: {{ $job->jobtype }}</td>
				</tr>
				<tr>
					<td>Opened: {{ date('M j, Y', $job->opened) }}</td>
					<td>Est. Time: <span class="notice">{{ $job->estimatedhours }}</span> hours</td>
				</tr>
				<tr>
					<td>@if ($job->website)<a href="{{ $job->website }}" class="general">{{ $job->website }}</a>@endif</td>
					<td>Est. Fee <span class="notice">${{ number_format($job->estimatedFee, 2) }}</span></td>
				</tr>
				<tr>
					<td colspan="2" class="jobdescription">
						{!! $job->description !!}
						@if (count($attachments) > 0)
							<ul class="attachment">
								<li><strong>Attachments</strong></li>
								@foreach ($attachments as $r)
								<li><a href="/attachments/{{ $r->filename }}" target="_blank">{{ $r->filename }}</a></li>
								@endforeach
							</ul>
						@endif
					</td>
				</tr>
			</tbody>
		</table>
	</div>

{{--
* Loop Sessions
********************************************************************************************************************
--}}

@if (count($sessions) > 0)
<ul class="progressList">
	<li class="totalTime">
		<span class="hourFee" title="{{ $job->hourfee }} per hour">Calculated Fee: <span class="notice">{{ number_format($totalFee, 2) }}</span></span>
		Total Time: <span class="notice">{{ $totaltime }}</span> hours
	</li>
	@foreach ($sessions as $row)
	<li>
		<div class="progressContainer">
			<div class="avatar"><a href="/users/{{ $row->userid }}" class="general">{{ $row->username }}</a></div>
			<div class="title body">
{{--
	Developer Note: I had to remove the reference to the userinfo array here until I have a functioning login system from which to access user account information.
		$userinfo->userid == $row->userid && $row->stopped != 0
--}}
				<p class="sessionNumber @if ($row->stopped != 0) editSession pseudolink @endif" sid="{{ $row->tid }}">#{{ $row->tid }}</p>
				<p class="postdate">
					{{ date('M j, Y g:i A', $row->started) }} -
					@if ($row->stopped != 0){{ date('M j, Y g:i A', $row->stopped) }}@else<em>In Progress</em>@endif
				</p>
				{{ $row->notes }}
				{{--
				@if ($row->attachments)
					<ul class="attachment">
						<li><strong>Attachments</strong></li>
						@foreach ($row->attachments as $r)
							<li><a href="/attachments/{{ $r->filename }}" target="_blank">{{ $r->filename }}</a></li>
						@endforeach
					</ul>
				@endif
				--}}
				<p class="hoursSpent">{{ $row->totalTime }} hours</p>
			</div>
		</div>
	</li>
	@endforeach
	<li class="totalTime">
		<span class="hourFee" title="{{ $job->hourfee }} per hour">Calculated Fee: <span class="notice">{{ number_format($totalFee, 2) }}</span></span>
		Total Time: <span class="notice">{{ $totaltime }}</span> hours
	</li>
</ul>
@endif

{{-- Examine the status of this job and determine what controls need to be shown --}}

@if ($job->status == 1)
	@if ($job->claimedby)

{{--
Developer Note: I had to remove the reference to the userinfo array here until I have a functioning login system from which to access user account information.
	$job->claimedby == $userinfo.userid
--}}
		
	<form method="post" action="/jobs/{{ $job->jid }}">
		<div class="pseudoTab">Record Session Note</div>
		<div class="fieldsection flattop">
			<textarea name="notes" rows="3" class="addNote"></textarea>
			<br>
			<input type="file" width="79" height="18" size="60" id="attachment" name="attachment" />
			<div style="text-align: center;"><input type="submit" name="stopjob" value="Stop Job" class="lgButton" /></div>
		</div>
	</form>
		
	@else
		<form method="post" action="/jobs/{{ $job->jid }}" name="startjob">
			<div class="fieldsection flattop">
				<input type="submit" value="Begin Session" name="startjob" class="lgButton" />
				<input type="submit" value="Close Job" name="closejob" class="lgButton" />
			</div>
		</form>
	@endif
@endif
@endsection
