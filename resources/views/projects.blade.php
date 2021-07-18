<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Manage Projects</title>

	<link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}" />
</head>
<body class="antialiased">

@include('includes.menu')

<div id="pageBody">
	<a href="/projects/add" class="buttonLink"><input type="button" value="Add Project" class="lgButton" /></a>
	<div class="fieldsection flattop">
		<table class="default">
			<thead>
			<tr>
				<th align="left">Project</th>
				<th align="left">Customer</th>
				<th>Priority</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
				@if (count($rows) > 0)
					@foreach ($rows as $row)
						<tr valign="top">
							<td><a href="/projects/view/{{ $row->pid }}" class="general">@if ($row->projecttitle){{ $row->projecttitle }}@else<em>Untitled</em>@endif</a></td>
							<td>{{ $row->customer }}</td>
							<td align="center">{{ $row->priority }}</td>
							<td align="center"><a href="/projects/{{ $row->pid }}" class="general"><img src="/images/edit-icon.png" /></a></td>
						</tr>
					@endforeach
				@else
				<tr>
					<td colspan="4" align="center">No projects</td>
				</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

</body>
</html>
