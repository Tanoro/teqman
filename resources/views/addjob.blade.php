<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Add Job Ticket</title>

	<link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}" />
</head>
<body class="antialiased">

@include('includes.menu')

<div id="pageBody">
	<div class="pseudoTab">Add Job Ticket</div>
	<div class="fieldsection flattop">
		<form action="/job/add" method="post" enctype="multipart/form-data">
			<input type="hidden" name="attachments" value="" />
			<table cellpadding="10">
				<tbody>
					<tr>
						<td>Select Customer</td>
						<td>
							<select name="cid">
								<option value="">:: Select Customer ::</option>
								@foreach ($customers as $row)
								<option value="{{ $row->cid }}">{{ $row->customer }}</option>
								@endforeach
							</select>
						</td>
					</tr>
					<tr>
						<td>Select Project</td>
						<td>
							<select name="pid">
								<option value="">:: Select Project ::</option>
								@foreach ($projects as $row)
								<option value="{{ $row->pid }}">{{ $row->projecttitle }}</option>
								@endforeach
							</select>
						</td>
					</tr>
					<tr>
						<td>Job Type</td>
						<td>
							<select name="jobtype">
								@foreach ($jobtype as $key => $value)
								<option value="{{ $key }}">{{ $value }}</option>
								@endforeach
							</select>
						</td>
					</tr>
					<tr>
						<td>Website</td>
						<td><input type="url" name="website" size="60" value="" placeholder="http://" /></td>
					</tr>
					<tr>
						<td>Open Date</td>
						<td><input type="date" name="opened" min="{{ $timenow }}" value="{{ $timenow }}" required /></td>
					</tr>
					<tr>
						<td>Priority</td>
						<td><input type="number" name="priority" size="3" min="0" max="10" value="0" /></td>
					</tr>
					<tr>
						<td>Status</td>
						<td>
							<select name="status">
								@foreach ($status as $key => $value)
								<option value="{{ $key }}">{{ $value }}</option>
								@endforeach
							</select>
						</td>
					</tr>
					<!--<tr valign="top">
						<td>Attachment</td>
						<td>
							<div class="dropzone-previews"></div>
							<div class="dropzone"></div>
						</td>
					</tr>-->
					<tr>
						<td>Assign Job</td>
						<td>
							<select name="claimedby">
								<option value="0">:: Assign Job ::</option>
								@foreach ($users as $row)
								<option value="{{ $row->userid }}">{{ $row->fullname }}</option>
								@endforeach
							</select>
						</td>
					</tr>
					<tr>
						<td>Subject</td>
						<td><input type="text" name="subject" size="60" value="" /></td>
					</tr>
					<tr valign="top">
						<td>Description</td>
						<td><textarea name="description" cols="80" rows="30"></textarea></td>
					</tr>
					<tr>
						<td>Complexity</td>
						<td>@include('includes.complexityTable')</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2" align="center"><input type="submit" value="Save" class="lgButton" /></td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
</div>

</body>
</html>