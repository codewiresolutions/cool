{{--@php use Illuminate\Support\Str; @endphp--}}

{{--<div class="our_blog_container">--}}
{{--    <div class="container-fluid latest_blogs">--}}
{{--        --}}
{{--        <div class="section howitwrap our_blog_post">--}}
{{--            <!-- title start -->--}}
{{--            <div class="titleTop mb-4">--}}
{{--                <h3 class="w-100">Our Latest News</h3>--}}
{{--                <p class="text-left w-100">--}}
{{--                    News is information about current events. This may be provided through many different media:--}}
{{--                    word of mouth, printing, postal systems, broadcasting, electronic communication, or through the--}}
{{--                    testimony of observers and witnesses to events.--}}
{{--                </p>--}}
{{--            </div>--}}
{{--            <!-- title end -->--}}
{{--            <div class="row gx-3 gy-4">--}}
{{--                @foreach($blogs as $blog)--}}
{{--                    <div class="col-12 col-md-6 col-lg-4">--}}
{{--                        <div class="card h-100">--}}
{{--                            <div class="card-body d-flex flex-column">--}}
{{--                                <img src="{{ asset($blog->image ? 'uploads/blogs/'.$blog->image : 'images/blog/1.jpg') }}"--}}
{{--                                     class="card-img-top img-fluid" alt="{{ $blog->heading }}">--}}
{{--                                <h5 class="card-title mt-5 mb-2">--}}
{{--                                    <a href="{{ route('blog-detail', $blog->slug) }}">{{ $blog->heading }}</a>--}}
{{--                                </h5>--}}
{{--                                --}}
{{--                                <div class="mb-3 text-muted">--}}
{{--                                    @foreach($blog->categories as $category)--}}
{{--                                        <a href="{{ url('/blog/category/'.$category->slug) }}">{{ $category->heading }}</a>@if(!$loop->last)--}}
{{--                                            ,--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                                --}}
{{--                                <p class="card-text mt-auto">{!! Str::limit($blog->content, 200, '...') !!}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}













@php use Illuminate\Support\Str; @endphp

<div class="our_blog_container">
    <div class="container-fuild latest_blogs">

        <div class="titleTop mb-4">
            <h3>Our Latest News</h3>
            <p class="text-left w-100">
                News is information about current events. This may be provided through many different media:
                word of mouth, printing, postal systems, broadcasting, electronic communication, or through the
                testimony of observers and witnesses to events.
            </p>
        </div>

        <!-- BLOG SLIDER -->
        <div class="blog-slider">

            @foreach($blogs as $blog)
                <div class="blog-item">
                    <div class="blog-card">

                        <img src="{{ asset($blog->image ? 'uploads/blogs/'.$blog->image : 'images/blog/1.jpg') }}">

                        <div class="blog-content">
                            <h5 class="card-title mt-5 mb-2">
                                <a href="{{ route('blog-detail', $blog->slug) }}">{{ $blog->heading }}</a>
                            </h5>

                            <div class="mb-3 text-muted">
                                @foreach($blog->categories as $category)
                                    <a href="{{ url('/blog/category/'.$category->slug) }}">{{ $category->heading }}</a>@if(!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </div>
                            <p>{{ Str::limit(strip_tags($blog->content),150) }}</p>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
        <!-- END -->

    </div>
</div>


<!-- ===== BLOG SLIDER SECTION END ===== -->


<!-- ===== REQUIRED CSS ===== -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">

<style>
    .latest_blogs {
        margin-top: 375px ;
        overflow: hidden;
        padding: 0 100px 70px; /* proper space */

    }

    /* slick layout fix */
    .blog-slider .slick-track {
        display: flex !important;
    }

    .blog-slider .slick-slide {
        height: auto !important;
    }

    .blog-item {
        padding: 0 18px;
    }

    /* card */
    .blog-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,.08);
        width: 100%;
        display: flex;
        flex-direction: column;
        height: 100%; /* full height for all cards */
    }

    /* image */
    .blog-card img {
        width: 100%;
        height: 250px; /* slightly smaller for consistency */
        object-fit: cover;
    }

    /* content */
    .blog-content {
        padding: 16px;
        flex: 1; /* ensures equal height for content area */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .blog-content h5 {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .blog-content p {
        font-size: 14px;
        color: #6b7280;
    }

    /* arrows */
    .slick-prev, .slick-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        background: blue;
        color: #fff;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex !important;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .slick-prev:before {
        margin-top: 3px;

    }
    .slick-next:before {
        margin-top: 3px;

    }
    .slick-prev:hover, .slick-next:hover {
        background: rgba(0,0,0,0.8);
    }

    .slick-prev {
        left: -70px;
    }

    .slick-next {
        right: -70px;
    }

</style>


<!-- ===== REQUIRED JS ===== -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
    $('.blog-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 1000,
        speed: 1800,
        cssEase: 'ease-in-out',
        arrows: true,          // enable arrows
        dots: false,
        pauseOnHover: true,
        prevArrow: '<button type="button" class="slick-prev">&#10094;</button>',
        nextArrow: '<button type="button" class="slick-next">&#10095;</button>',

        responsive: [
            { breakpoint: 1024, settings: { slidesToShow: 2 }},
            { breakpoint: 768, settings: { slidesToShow: 1 }}
        ]
    });

</script>