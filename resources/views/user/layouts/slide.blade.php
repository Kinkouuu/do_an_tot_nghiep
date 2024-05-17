<div class="position-relative">
<!-- Carousel -->
    <div class="slide-one-item home-slider owl-carousel" >
        <div class="site-blocks-cover overlay" style="background-image: url('{{asset('images/hero_1.jpg')}}') "
             data-aos="fade" data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center justify-content-center h-50">
                    <div class="col-md-7 text-center" data-aos="fade">
                        <h1 class="mb-2">{{ $page_title }}</h1>
                        <h2 class="caption">{{ $page_description }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-blocks-cover overlay" style="background-image: url('{{asset('images/hero_2.jpg')}}') "
             data-aos="fade" data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center justify-content-center h-50">
                    <div class="col-md-7 text-center" data-aos="fade">
                        <h1 class="mb-2">{{ $page_title }}</h1>
                        <h2 class="caption">{{ $page_description }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Search form -->
    <x-room-search></x-room-search>

</div>
