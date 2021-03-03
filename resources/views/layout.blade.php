<html>
<head>
	<title>Forum - @yield('title')</title>
	<link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon"/>
	<link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
</head>
<body>
	<div>
		@yield('content')
	</div>
	
	<script src="{{ asset(mix('js/app.js')) }}"></script>
	<script src="{{ asset(mix('js/manifest.js')) }}"></script>
	<script src="{{ asset(mix('js/vendor.js')) }}"></script>
	
</body>
</html>
