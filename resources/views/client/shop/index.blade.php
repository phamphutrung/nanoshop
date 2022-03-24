@extends('layouts.client')
@section('title')
    Cửa hàng
@endsection

@section('content')
    <main id="main" class="main-site left-sidebar">
        <div class="container">
            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="{{ route('home') }}" class="link">Trang chủ</a></li>
                    <li class="item-link"><a href="{{ route('shop') }}" class="link">Shop</a></li>
                    <li class="item-link"><span>{{ $category_name }}</span></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">
                    <div class="banner-shop">
                        <a href="#" class="banner-link">
                            <figure><img src="{{ asset('clients/assets/images/shop-banner.jpg') }}" alt=""></figure>
                        </a>
                    </div>
                    <div class="wrap-shop-control">
                        <h1 class="shop-title" style="text-transform: uppercase">{{ $category_name }}</h1>
                        <div class="wrap-right">

                            <div class="sort-item orderby ">
                                <select id="sortby" name="orderby" class="use-chosen">
                                    <option value="1" selected="selected">Mới nhất</option>
                                    <option value="2">Cũ nhất</option>
                                    <option value="3">Giá: thấp đến cao</option>
                                    <option value="4">Giá: cao đên thấp</option>
                                </select>
                            </div>

                            {{-- <div class="sort-item product-per-page">
                                <select id="show_per_page" name="post-per-page" class="use-chosen">
                                    <option value="4">Hiển thị 4 sản phẩm</option>
                                    <option value="8">Hiển thị 8 sản phẩm</option>
                                    <option value="12" selected="selected">Hiển thị 12 sản phẩm</option>
                                    <option value="16">Hiển thị 16 sản phẩm</option>
                                    <option value="20">Hiển thị 20 sản phẩm</option>
                                    <option value="24">Hiển thị 24 sản phẩm</option>
                                    <option value="28">Hiển thị 28 sản phẩm</option>
                                    <option value="32">Hiển thị 32 sản phẩm</option>
                                    <option value="all">Hiển thị tất cả sản phẩm</option>
                                </select>
                            </div> --}}
                        </div>
                    </div>
                    <input type="hidden" name="categoryId" value="{{ $categoryId }}">
                    <input type="hidden" name="page" value="1">
                    <style>
                        #kun {
                            position: absolute; z-index: 200; top: 100px;right: 50%;font-size: 50px;display: none;
                        }
                    </style>
                    <div style="position: relative" id="wrapper_content" class="row">
                        <i id="kun" class="fas fa-spinner fa-pulse"></i>
                        <ul id="main_data" class="product-list grid-products equal-container" style="margin-bottom: 100px">
                            @foreach ($products as $key => $product)
                                <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                                    <div class="product product-style-3 equal-elem ">
                                        <div class="product-thumnail">
                                            <a href="{{ route('product', [$product->slug, $product->id]) }}"
                                                title="{{ $product->name }}">
                                                <figure><img src="{{ asset('storage/' . $product->feature_image_path) }}"
                                                        alt="{{ $product->name }}"></figure>
                                            </a>
                                        </div>
                                        <div class="product-info">
                                            <a href="{{ route('product', [$product->slug, $product->id]) }}"
                                                class="product-name"><span
                                                    style="display: block; height: 5em">{{ $product->name }}</span></a>
                                            <div class="wrap-price"><span
                                                    class="product-price">{{ number_format($product->selling_price) }}đ</span>
                                            </div>
                                            <a data-id="{{ $product->id }}" class="btn add-to-cart">Add To Cart</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <button id="noti" style="font-weight: bold; display: none;" class="btn btn-sm btn-danger form-control">Đang tải...</button>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                    @include('client.shop.inc.category_menu')
                    @include('client.shop.inc.popular_product')
                </div>
            </div>
        </div>
    </main>
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .show_child_cat {
            float: right;
            cursor: pointer;
        }

        .show_child_cat:hover {
            color: red;
        }

        .list_category .category_item .list_sub_category {
            margin-left: 22px;
            display: none;
        }

    </style>
@endsection
@section('scripts')
    <script>
        $(document).on('click', '.show_child_cat', function(e) {
            $(this).parent('li').children('ul').slideToggle();
            $(this).parent('li').children('i').toggleClass('fa-circle-chevron-down fa-circle-chevron-right');
        })

    </script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('change', '#show_per_page', function(){
                filter()
            })

            $(document).on('change', '#sortby', function() {
                var sortby = $(this).val()
                var idCat = $('input[name="categoryId"]').val();
                $('#noti').css('display', 'none');
                $.ajax({
                    url: "{{ route('sort') }}",
                    type: 'get',
                    data: {idCat:idCat,sortby:sortby},
                    beforeSend: function() { 
                        $('#main_data').css('opacity', '0.6')
                        $('#kun').css('display', 'block')
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#main_data').css('opacity', '1')
                        $('#kun').css('display', 'none')
                        $('#main_data').html(res.view)
                        $('input[name="page"]').val(2)
                        $('#noti').css('display', 'none');
                    }
                })
            })

            var page = $('input[name="page"]').val();
            $(window).on('scroll', function(){
                 if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                    page ++;
                    if ($('input[name="page"]').val() == 2) {
                        page = 2;
                    }
                    loadMore(page)
                    $('input[name="page"]').val(1)
                 }
            })
            function loadMore(page) {
                var idCat = $('input[name="categoryId"]').val();
                var sortby = $('#sortby').val();
                $.ajax({
                    url: "{{ route('load-more')}}" + "?page=" + page,
                    type: 'get',
                    data: {idCat:idCat, sortby:sortby},
                    dataType: 'json',
                    beforeSend: function() {
                        $('#noti').css('display', 'block');
                    },
                    success:function(res){
                        if(res.view == '') {
                            $('#noti').text('Đã hết dữ liệu.');
                            $('#noti').prop('disable', true);
                        } else {
                            $('#noti').css('display', 'none');
                            $('#main_data').append(res.view)
                        }
                    }
                })
            }

            $(document).on('click', '.add-to-cart', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('shop-add-cart') }}",
                    type: 'get',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        alertify.success(response.msg)
                        $('#cartCount').text(response.cartCount + ' SP')
                    }
                })
            })
        })

    </script>
@endsection
