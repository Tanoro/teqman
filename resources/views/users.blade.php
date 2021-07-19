@extends('layouts.app')
@section('title', 'Manage Users')

@section('content')
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
@endsection
