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
                                <select name="orderby" class="use-chosen">
                                    <option value="menu_order" selected="selected">Default sorting</option>
                                    <option value="popularity">Sort by popularity</option>
                                    <option value="rating">Sort by average rating</option>
                                    <option value="date">Sort by newness</option>
                                    <option value="price">Sort by price: low to high</option>
                                    <option value="price-desc">Sort by price: high to low</option>
                                </select>
                            </div>

                            <div class="sort-item product-per-page">
                                <select name="post-per-page" class="use-chosen">
                                    <option value="12" selected="selected">12 per page</option>
                                    <option value="16">16 per page</option>
                                    <option value="18">18 per page</option>
                                    <option value="21">21 per page</option>
                                    <option value="24">24 per page</option>
                                    <option value="30">30 per page</option>
                                    <option value="32">32 per page</option>
                                </select>
                            </div>

                            <div class="change-display-mode">
                                <a href="#" class="grid-mode display-mode active"><i class="fa fa-th"></i>Grid</a>
                                <a href="list.html" class="list-mode display-mode"><i class="fa fa-th-list"></i>List</a>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <ul class="product-list grid-products equal-container">
                            @foreach ($products as $product)
                                <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
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
                                                class="product-name"><span>{{ $product->name }}</span></a>
                                            <div class="wrap-price"><span
                                                    class="product-price">{{ number_format($product->selling_price) }}đ</span>
                                            </div>
                                            <a data-id="{{ $product->id }}" class="btn add-to-cart">Add To Cart</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="wrap-pagination-info">
                        <ul class="page-numbers">
                            <li><span class="page-number-item current">1</span></li>
                            <li><a class="page-number-item" href="#">2</a></li>
                            <li><a class="page-number-item" href="#">3</a></li>
                            <li><a class="page-number-item next-link" href="#">Next</a></li>
                        </ul>
                        <p class="result-count">Showing 1-8 of 12 result</p>
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
            $('.add-to-cart').on('click', function() {
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
