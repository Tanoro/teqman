<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Manage Customers</title>

	<link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ url('css/viewjob.css') }}" />
</head>
<body class="antialiased">

@include('includes.menu')

<div id="pageBody">
	<a href="/customers/add" class="buttonLink"><input type="button" value="Add Customer" class="lgButton" /></a>
	<div class="fieldsection flattop">
		<table class="default">
			<thead>
				<tr>
					<th>ID</th>
					<th>Customer</th>
					<th>Contact</th>
					<th>Priority</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($rows as $row)
					<tr align="center">
						<td>{{ $row->cid }}</td>
						<td><a href="/customers/{{ $row->cid }}">{{ $row->customer }}</a></td>
						<td>{{ $row->contact }}</td>
						<td>{{ $row->priority }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

</body>
</html>