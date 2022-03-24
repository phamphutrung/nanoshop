@extends('layouts.client')
@section('title', 'Trang chủ')
@section('content')
    <main id="main">
        <div class="container">

            <!--MAIN SLIDE-->
            @include('client.home.inc.slider')

            <!--BANNER-->
            @include('client.home.inc.banner')

            <!--On Sale-->
            @include('client.home.inc.selling_product')

            <!--Latest Products-->
            @include('client.home.inc.latest_product')

            <!--Product Categories-->
            @include('client.home.inc.tab_categories')

        </div>
    </main>

@endsection
