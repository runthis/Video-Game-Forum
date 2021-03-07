<!DOCTYPE html>
<html lang="en">
<head>
	<title>Video Game Forum - @yield('title')</title>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui" />

	<meta name="theme-color" content="#222222">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">	
	<meta name="description" content="@yield('description')">
	
	<meta property="og:url" content="@yield('og_url')" />
	<meta property="og:type" content="article" />
	<meta property="article:author" content="@yield('og_article_author')" />
	<meta property="article:publisher" content="@yield('og_article_publisher')" />
	<meta property="og:title" content="@yield('og_title')" />
	<meta property="og:description" content="@yield('og_description')" />
	<meta property="og:image" content="@yield('og_image')" />
	<meta property="og:image:secure_url " content="@yield('og_image')" />
	<meta property="og:image:alt" content="@yield('og_image_alt')" />
	<meta property="og:image:width" content="@yield('og_image_width')" />
	<meta property="og:image:height" content="@yield('og_image_height')" />
	<meta property="og:site_name" content="Video Game Forum" />
	
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
	@stack('scripts')
	
</body>
</html>
