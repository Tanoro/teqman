@extends('layouts.app')
@section('title', 'Manage Customers')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ url('css/viewjob.css') }}" />
@endsection

@section('content')
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
@endsection
