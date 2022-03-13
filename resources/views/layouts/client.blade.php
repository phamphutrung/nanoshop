<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Home</title>	
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('clients/assets/images/favicon.ico') }}">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,700italic,900,900italic&amp;subset=latin,latin-ext" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open%20Sans:300,400,400italic,600,600italic,700,700italic&amp;subset=latin,latin-ext" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/animate.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/owl.carousel.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/flexslider.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/chosen.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/color-01.css') }}">

	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
    {{-- end css alertifyjs --}}
	@yield('css')
</head>
<body class="home-page home-01 ">

	<!-- mobile menu -->
    <div class="mercado-clone-wrap">
        <div class="mercado-panels-actions-wrap">
            <a class="mercado-close-btn mercado-close-panels" href="#">x</a>
        </div>
        <div class="mercado-panels"></div>
    </div>

	<!--header-->
	
	@include('layouts.inc_client.client_header')


	<main id="main">
        @yield('content')
	</main>


	@include('layouts.inc_client.client_footer')
	<script src="{{ asset('clients/assets/js/jquery-1.12.4.minb8ff.js?ver=1.12.4') }}"></script>
	<script src="{{ asset('clients/assets/js/jquery-ui-1.12.4.minb8ff.js?ver=1.12.4') }}"></script>
	<script src="{{ asset('clients/assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('clients/assets/js/jquery.flexslider.js') }}"></script>
	<script src="{{ asset('clients/assets/js/chosen.jquery.min.js') }}"></script>
	<script src="{{ asset('clients/assets/js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('clients/assets/js/jquery.countdown.min.js') }}"></script>
	<script src="{{ asset('clients/assets/js/jquery.sticky.js') }}"></script>
	<script src="{{ asset('clients/assets/js/functions.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

	@yield('scripts')
</body>
</html>