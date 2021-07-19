<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>@yield('title')</title>

	<script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
	<script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>
	<link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}" />
	@yield('styles')
</head>
<body class="antialiased">

@include('includes.menu')

<div id="pageBody">
	@yield('content')
</div>

</body>
</html>
