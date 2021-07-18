<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Add Customer</title>

	<link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}" />
</head>
<body class="antialiased">

@include('includes.menu')

<div id="pageBody">
	<div class="pseudoTab">Add Customer</div>
	<div class="fieldsection flattop">
		<form action="{$smarty.server.REQUEST_URI}" method="post">
			<table cellpadding="5">
				<tbody>
					<tr>
						<td>Customer Name</td>
						<td><input type="text" name="customer" size="40" value="" placeholder="Sizable Steel Erection Company" /></td>
					</tr>
					<tr>
						<td>Contact Name</td>
						<td><input type="text" name="contact" size="40" value="" placeholder="Harry Haha" /></td>
					</tr>
					<tr>
						<td>E-mail Address</td>
						<td><input type="email" name="email" size="40" value="" placeholder="party@myplace.com" /></td>
					</tr>
					<tr>
						<td>Mailing Address</td>
						<td><input type="text" name="address" size="40" value="" placeholder="100 Jerk Circle" /></td>
					</tr>
					<tr>
						<td>City</td>
						<td><input type="text" name="city" size="40" value="" placeholder="Eerie" /></td>
					</tr>
					<tr>
						<td>State</td>
						<td><input type="text" name="state" size="2" value="" placeholder="IN" /></td>
					</tr>
					<tr>
						<td>Zip Code</td>
						<td><input type="text" name="zip" size="10" value="" /></td>
					</tr>
					<tr>
						<td>Phone</td>
						<td><input type="tel" name="phone" size="12" value="" placeholder="(555)555-5555" /></td>
					</tr>
					<tr>
						<td>Priority</td>
						<td><input type="number" name="priority" size="3" min="0" max="10" value="0" /></td>
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
