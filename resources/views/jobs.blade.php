@extends('layouts.app')
@section('title', 'Manage Jobs')

@section('content')
<a href="/jobs/add" class="buttonLink"><input type="button" value="Add Job" class="lgButton" /></a>
<div class="fieldsection">
	<table class="default">
		<thead>
		<tr>
			<th>Job Ticket</th>
			<th>Subject</th>
			<th>Project</th>
			<th>Priority</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
			@foreach ($rows as $row)
			<tr>
				<td>@if ($row->projecttitle){{ $row->projecttitle }}@else<em>Untitled</em>@endif</td>
				<td><a href="/jobs/view/{{ $row->jid }}" class="general">{{ $row->subject }}</a></td>
				<td>{{ $row->projecttitle }}</td>
				<td>{{ $row->projpriority }}-{{ $row->priority }}</td>
				<td><a href="/jobs/{{ $row->jid }}" class="general"><img src="/images/edit-icon.png" /></a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
