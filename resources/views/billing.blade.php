<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Billable Work</title>

	<link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}" />
</head>
<body class="antialiased">

@include('includes.menu')

<div id="pageBody">
	<div class="fieldsection flattop">
		<table class="default">
			<thead>
				<tr>
					<th align="left">Ticket</th>
					<th align="left">Subject</th>
					<th align="left">Customer</th>
					<th align="left">Employee</th>
					<th>Hours</th>
					<th>Fee</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			@if (count($rows) > 0)
				@foreach ($rows as $r)
				<tr>
					<td><a href="/jobs/view/{{ $r->jid }}" class="general">#{{ $r->jid }}</a></td>
					<td>{{ $r->subject }}</td>
					<td>{{ $r->customer }}</td>
					<td><a href="/viewactivity/{{ $r->claimedby }}" class="general">{{ $r->fullname }}</a></td>
					<td align="center">{{ $r->totalHours }}</td>
					<td align="center">${{ number_format($r->fee, 2) }}</td>
					<td align="center"><input type="button" name="close" value="Close" jid="{{ $r->jid }}" /></td>
				</tr>
				@endforeach
			@else
				<tr>
					<td colspan="7" align="center">No jobs</td>
				</tr>
			@endif
			
			</tbody>
			<tfoot>
				<tr align="center">
					<td align="right" colspan="4"><strong>Totals:</strong></td>
					<td><strong>{{ $totals->hours }}</strong></td>
					<td><strong>${{ number_format($totals->billing, 2) }}</strong></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

</body>
</html>
