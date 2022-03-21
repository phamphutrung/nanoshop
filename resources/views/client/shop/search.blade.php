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
                    <li class="item-link"><span>Tìm kiếm</span></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">
                    <div class="wrap-shop-control">
                        <h1 class="shop-title" style="text-transform: uppercase">kết quả cho: {{ $str }}</h1>
                    </div>
                    <div id="main_data" class="row">
                        <ul class="product-list grid-products equal-container">
                            @if ($products->count() > 0)
                                @foreach ($products as $product)
                                    <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                                        <div class="product product-style-3 equal-elem ">
                                            <div class="product-thumnail">
                                                <a href="{{ route('product', [$product->slug, $product->id]) }}"
                                                    title="{{ $product->name }}">
                                                    <figure><img
                                                            src="{{ asset('storage/' . $product->feature_image_path) }}"
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
                            @else
                                  <h4 class="text-center">Không tìm thấy kết quả nào</h4>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                    @include('client.shop.inc.category_menu')
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

            $(document).on('change', '#show_per_page', function() {
                filter()
            })



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
