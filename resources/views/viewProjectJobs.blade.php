<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>View Project - {{ $project->pid }}</title>

	<link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ url('css/viewjob.css') }}" />
</head>
<body class="antialiased">

@include('includes.menu')

<div id="pageBody">
	<a href="/projects/{{ $project->pid }}" class="buttonLink"><input type="button" value="Edit Project" class="lgButton" /></a>
	<div class="fieldsection flattop">
		<table class="default" width="100%" cellpadding="5">
			<thead>
				<tr>
					<th colspan="6" align="left">{{ $project->customer }} - {{ $project->projecttitle }}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Tasks</td>
					<td>{{ $project->taskNum }}</td>
					<td>Priority</td>
					<td>{{ $project->priority }}</td>
					<td>Open Date</td>
					<td>{{ date('F j, Y g:i A', $project->dateadded) }}</td>
				</tr>
				<tr>
					<td>Hourly Fee</td>
					<td>${{ number_format($project->hourfee, 2) }}</td>
					<td>Estimated Time</td>
					<td>{{ $project->totalHours }} hrs.</td>
					<td>Estimated Income</td>
					<td>${{ number_format($project->estIncome, 2) }}</td>
				</tr>
				<tr>
					<td>Time Spent</td>
					<td>{{ $project->hoursSpent }} hrs.</td>
					<td>Total Income</td>
					<td>${{ number_format($project->totalIncome, 2) }}</td>
					<td title="@if ($teq->teq < 100)Low TEQ means time approximations are too high.@elseHigh TEQ means time approximations are too low.@endif">Time Efficiency Quotient</td>
					<td title="@if ($teq->teq < 100)Low TEQ means time approximations are too high.@elseHigh TEQ means time approximations are too low.@endif">
						<span style="border-bottom: 1px dashed #000000;">{{ $teq->teq }}%</span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="fieldsection flattop">
		<table class="default">
			<thead>
				<tr>
					<th>Ticket</th>
					<th align="left">Subject</th>
					<th>Opened</th>
					<th>Est. Hours</th>
					<th>TEQ</th>
					<th title="Customer + Project + Job + Session = Priority">Priority</th>
				</tr>
			</thead>
			<tbody>
			@if (count($jobs) > 0)
				@foreach ($jobs as $r)
					<tr align="center">
						<td><a href="/jobs/view/{{ $r->jid }}" class="general">#{{ $r->jid }}</a></td>
						<td align="left">{{ $r->subject }}</td>
						<td><span class="general-small">{{ date('M j, Y', $r->opened) }}</span></td>
						<td>{{ $r->estimatedhours }}</td>
						<td>@if ($r->teq) {{ $r->teq }}% @else n/a @endif</td>
						<td title="{{ $r->customerpriority }} + {{ $r->projectpriority }} + {{ $r->jobpriority }} + {{ $r->sessScore }}">{{ $r->priority }}</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="6" align="center">No jobs</td>
				</tr>
			@endif
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td></td>
					<td align="right"><strong>Totals:</strong></td>
					<td align="center"><strong>{{ $totals->hours }}</strong></td>
					<td align="center"><strong>@if ($totals->teqAvg <= 100)<span style="color: green;">{{ $totals->teqAvg }}%</span>@else<span style="color: red;">{{ $totals->teqAvg }}%</span>@endif</strong></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

</body>
</html>
