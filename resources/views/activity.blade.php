<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>View Activity</title>

	<link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}" />
</head>
<body class="antialiased">

@include('includes.menu')

<div id="pageBody">
	<div class="fieldsection flattop">
		<table class="default">
			<thead>
				<tr>
					<th>Ticket</th>
					<th align="left">Subject</th>
					<th align="left">Customer</th>
					<th>Started</th>
					<th>Stopped</th>
					<th>Time</th>
					<th>Fee</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($activity as $row)
					<tr align="center">
						<td><a href="/jobs/view/{{ $row->jid }}">#{{ $row->jid }}</a></td>
						<td align="left">{{ $row->subject }}</td>
						<td align="left">{{ $row->customer }}</td>
						<td>{{ date('M j Y, g:ia', $row->started) }}</td>
						<td>{{ $row->stopped }}</td>
						<td>{{ $row->totalHours }}</td>
						<td>{{ $row->fee }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

</body>
</html>
