<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('clients/assets/images/favicon.ico') }}">
    <link
        href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,700italic,900,900italic&amp;subset=latin,latin-ext"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Open%20Sans:300,400,400italic,600,600italic,700,700italic&amp;subset=latin,latin-ext"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/flexslider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/chosen.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('clients/assets/css/color-01.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
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
    @yield('content')
    @include('layouts.inc_client.client_footer')

    <div id="ontop"
        style="display:none; cursor: pointer;color: white; position: fixed; z-index: 3000; right: 50px; bottom: 100px; width: 5rem; height: 5rem; text-align: center; line-height: 5rem; background-color: red; border-radius: 100%; transition-property: all 3s; font-size: 1.5rem">
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>

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
    <script>
        $(document).on('keyup', '#search_product', function() {
            var str = $(this).val();
            $('#search_data').css('display', 'block')
            $.ajax({
                url: "{{ route('search-dropdown') }}",
                type: 'get',
                data: {
                    str: str
                },
                dataType: 'json',
                success: function(res) {
                    if (str == '') {
                        $('#search_data').css('display', 'none')
                    }
                    $('#search_data').html(res.view)
                }
            })
        })
        $(document).on('blur', '#search_product', function() {
            setTimeout(() => {
                $('#search_data').css('display', 'none')
            }, 500);
        })
        $(document).on('scroll', function() {
            if($(window).scrollTop() > 0) {
                $('#ontop').fadeIn();
            } else {
                $('#ontop').fadeOut();
            }
        })
        $(document).on('click', '#ontop', function() {
            $('html').animate({scrollTop: 0}, 500)
        })

    </script>
    @yield('scripts')
</body>

</html>
