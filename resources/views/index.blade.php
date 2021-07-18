<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>TEQ Project Manager</title>

	<link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}" />
</head>
<body class="antialiased">

@include('includes.menu')

{{-- Search Filters --}}
<div id="pageBody">
	<div class="pseudoTab">Search Jobs</div>
	<div class="fieldsection searchFilters flattop">
		<form action="/" method="post">
			<table border="0" width="100%" cellspacing="0" cellpadding="3">
				<tbody>
					<tr valign="top">
						<td>
							Customer<br>
							<select name="cid">
								<option value="">:: All Customers ::</option>
								@foreach ($cid as $row)
								<option value="{{ $row->cid }}"@if ($row->cid == app('request')->input('cid')) select @endif>{{ $row->customer }}</option>
								@endforeach
							</select>
						</td>
						<td>
							Project<br>
							<select name="pid">
								<option value="">:: All Projects ::</option>
								@foreach ($pid as $row)
								<option value="{{ $row->pid }}"@if ($row->pid == app('request')->input('pid')) select @endif>{{ $row->projecttitle }}</option>
								@endforeach
							</select>
						</td>
						<td>
							Status<br>
							<select name="status">
								@foreach ($status as $key => $value)
								<option value="{{ $key }}"{{ ( $key == app('request')->input('status')) ? ' selected' : '' }}>{{ $value }}</option>
								@endforeach
							</select>
						</td>
					</tr>
					<tr valign="top">
						<td>
							Type<br>
							<select name="jobtype">
								@foreach ($jobtype as $key => $value)
								<option value="{{ $key }}"{{ ( $key == app('request')->input('jobtype')) ? ' selected' : '' }}>{{ $value }}</option>
								@endforeach
							</select>
						</td>
						<td>Text Search<br><input type="text" name="search" size="40" value="{{ app('request')->input('search') }}" /></td>
						<td>Show Claimed Jobs<br><input type="checkbox" name="showClaimed" value="1"@if (app('request')->input('showClaimed') == 1) selected @endif /></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3" align="center"><input type="submit" value="Go" class="lgButton" /></td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>

	{{-- List jobs --}}
	<a href="/jobs/add" class="buttonLink"><input type="button" value="Add Job" class="lgButton" /></a>
	<div class="fieldsection flattop">
		<table class="default">
			<thead>
				<tr>
					<th>Ticket</th>
					<th align="left">Subject</th>
					<th align="left">Customer</th>
					<th align="left">Project</th>
					<th>Opened</th>
					<th title="Customer + Project + Job + Session = Priority">Priority</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($jobs as $row)
				<tr align="center">
					<td><a href="/jobs/view/{{ $row->jid }}@if ($row->bold)&highlight={{ $row->bold }}@endif" class="general">#{{ $row->jid }}</a></td>
					<td align="left">{{ $row->subject }}</td>
					<td align="left">{{ $row->customer }}</td>
					<td align="left"><a href="/projects/view/{{ $row->pid }}" class="general" target="_blank">{{ $row->projecttitle }}</a></td>
					<td><span class="general-small">{{ $row->dateopened }}</span></td>
					<td title="{{ $row->customerpriority }} + {{ $row->projectpriority }} + {{ $row->jobpriority }} + {{ $row->sessScore }}">{{ $row->priority }}</td>
					<td>
						<span class="jobstatus{{ $row->class }}">
							@if ($row->claimed)
								{{ $row->claimed }}
							@else
								{{ $row->arrStatus }}
							@endif
						</span>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

</body>
</html>
