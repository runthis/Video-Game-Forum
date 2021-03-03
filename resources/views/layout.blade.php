<html>
<head>
	<title>Forum - @yield('title')</title>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui" />

	<meta name="theme-color" content="#222222">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">	
	<meta name="description" content="Forum">
	
	<link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon"/>
	<link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
	
	@stack('styles')
	
</head>
<body>
	<div class="container-fluid h-100">
		@yield('content')
	</div>
	
	<script src="{{ asset(mix('js/app.js')) }}"></script>
	<script src="{{ asset(mix('js/manifest.js')) }}"></script>
	<script src="{{ asset(mix('js/vendor.js')) }}"></script>
	
</body>
</html>
