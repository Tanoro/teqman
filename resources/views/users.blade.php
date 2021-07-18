<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Manage Users</title>

	<link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}" />
</head>
<body class="antialiased">

@include('includes.menu')

<div id="pageBody">
	<a href="/users/add" class="buttonLink"><input type="button" name="adduser" value="Add User" class="lgButton" /></a>
	<div class="fieldsection flattop">
		<table class="default">
			<thead>
				<tr>
					<th>ID</th>
					<th>Username</th>
					<th>E-mail</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($rows as $row)
					<tr align="center">
						<td>{{ $row->userid }}</td>
						<td><a href="/users/{{ $row->userid }}">{{ $row->username }}</a></td>
						<td>{{ $row->email }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

</body>
</html>
