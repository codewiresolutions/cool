@php use Illuminate\Support\Str; @endphp
<div class="section testimonialwrap px-0 px-md-5">
    <div class="container-fluid px-0 px-md-5 position-relative">
        
        <div class="titleTop mb-4">
            <h3 class="text-center">Success Stories</h3>
            <p class="testimonials_head_2 text-start">Testimonials</p>
        </div>
        
        <ul id="testimonials-carousel-1" class="owl-carousel testimonials-carousel list-unstyled">
            @if(isset($testimonials) && count($testimonials))
                @foreach($testimonials as $testimonial)
                    <li class="testimonial-card card shadow-sm p-4 rounded-4 d-flex flex-column h-100">
                        <div class="ratinguser mb-3 text-warning">
                            @for($i=0; $i<5; $i++)
                                <i class="fa fa-star" aria-hidden="true"></i>
                            @endfor
                        </div>
                        
                        <div class="clientname fw-bold mb-2">{{ $testimonial->testimonial_by }}</div>
                        <div class="clientinfo text-primary mb-3">{{ $testimonial->company }}</div>
                        <div class="testimonial-text-wrapper flex-grow-1 d-flex flex-column justify-content-between">
                            <p class="testimonial-text mb-3">
                                <span class="short-text">{{ Str::limit($testimonial->testimonial, 150) }}</span>
                                <span class="full-text d-none">{{ $testimonial->testimonial }}</span>
                            </p>
                            <button type="button" class="btn-read-more btn btn-link p-0" style="font-size: 1rem;">
                                Read more
                            </button>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
        
        <button class="custom-prev btn btn-primary position-absolute" data-carousel="#testimonials-carousel-1"
                style="top:65%; left:-20px; transform:translateY(-50%); z-index:10;">
            <i class="fa fa-chevron-left"></i>
        </button>
        <button class="custom-next btn btn-primary position-absolute" data-carousel="#testimonials-carousel-1"
                style="top:65%; right:-20px; transform:translateY(-50%); z-index:10;">
            <i class="fa fa-chevron-right"></i>
        </button>
    </div>
</div>