<div class="wrap-main-slide">
    <div class="slide-carousel owl-carousel style-nav-1" data-items="1" data-loop="1" data-nav="true"
        data-dots="false">
        @foreach ($sliders as $slider)
            <div class="item-slide">
                <img src="{{ asset('storage/'. $slider->image_path) }}" alt="" class="img-slide">
                <div class="slide-info slide-1">
                    <h2 class="f-title">{!! $slider->title !!}</h2>
                    <span class="subtitle">{!! $slider->description !!}</span>
                    <p class="sale-info"></p>
                    <a href="#" class="btn-link">Mua Sắm Ngay</a>
                </div>
            </div>
        @endforeach
    </div>
</div>