@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->

    <!-- Inner Page Title start -->
    <div class="pageTitle blog-hero">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="page-heading">Our Latest News</h1>
                    <p class="page_header_paragraph">
                        News is information about current events. This may be provided through many different media:
                        word of mouth, printing, postal systems, broadcasting, electronic communication, or through the
                        testimony of observers and witnesses to events.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <section id="blog-content">
            <div class="container">
                <!-- search categories -->
                <div class="row blog-filter-row">
                    <div class="col-lg-12">
                        <!-- FILTER CARD -->
                        <div class="blog-filter-card">
                            <div class="row align-items-end">
                                <!-- Search -->
                                <div class="col-lg-8 col-md-8">
                                    <div class="blog-search-widget">
                                        {{--                                        <h5 class="widget-title">Search</h5>--}}
                                        <form action="{{route('blog-search')}}" method="GET"
                                              class="blog-search-form" id="blogFilterForm">
                                            <div class="blog-search-box">
                                                <input
                                                        type="text"
                                                        class="form-control blog-search-input"
                                                        placeholder="Search..."
                                                        name="search">
                                                <!-- SUBMIT BUTTON INSIDE INPUT -->
                                                <button type="submit" class="blog-search-btn">
                                                    Submit
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Categories -->
                                <div class="col-lg-4 col-md-4">
                                    @if(null!==($categories))
                                        <div class="blog-category-widget">
                                            {{--                                            <h5 class="widget-title">Categories</h5>--}}
                                            <select class="form-control blog-category-dropdown"
                                                    onchange="if(this.value) window.location.href=this.value;">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{url('/blog/category/').'/'.$category->slug}}">
                                                        {{$category->heading}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                blogs start--}}
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Blog List start -->
                        <div class="blogwrapper">
                            <ul class="jobslist row">
                                @if(null!==($blogs))
                                        <?php
                                        $count = 1;
                                        ?>
                                    @foreach($blogs as $blog)
                                            <?php
                                            $cate_ids = explode(",", $blog->cate_id);
                                            $data = DB::table('blog_categories')->whereIn('id', $cate_ids)->get();
                                            $cate_array = array();
                                            foreach ($data as $cat) {
                                                $cate_array[] = "<a href='" . url('/blog/category/') . "/" . $cat->slug . "'>$cat->heading</a>";
                                            }
                                            ?>


                                        <li class="col-lg-4 mb-4">
                                            <div class="blog-card">
                                                <div class="blog-img">
                                                    <a href="{{route('blog-detail',$blog->slug)}}">
                                                        <img src="{{ $blog->image ? asset('uploads/blogs/'.$blog->image) : asset('images/blog/1.jpg') }}"
                                                             alt="{{$blog->heading}}">
                                                    </a>
                                                </div>

                                                <div class="blog-content">
                                                    <div class="blog-category">
                                                        {!! implode(', ', $cate_array) !!}
                                                    </div>

                                                    <h4 class="blog-title">
                                                        <a href="{{route('blog-detail',$blog->slug)}}">
                                                            {{$blog->heading}}
                                                        </a>
                                                    </h4>

                                                    <p class="blog-desc">
                                                        {!! \Illuminate\Support\Str::limit(strip_tags($blog->content),150) !!}
                                                    </p>

                                                    <a href="{{route('blog-detail',$blog->slug)}}" class="read-more">
                                                        Read More →
                                                    </a>
                                                </div>
                                            </div>
                                        </li>


                                            <?php $count++; ?>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <!-- Pagination -->
                        <div class="pagiWrap">
                            <nav aria-label="Page navigation example">
                                @if(isset($blogs) && count($blogs))
                                    {{ $blogs->appends(request()->query())->links() }}
                                @endif
                            </nav>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>


    @include('includes.footer')
@endsection
@push('styles')
    <style>
        .plus-minus-input {
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .plus-minus-input .input-group-field {
            text-align: center;
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            padding: 0rem;
        }

        .plus-minus-input .input-group-field::-webkit-inner-spin-button,
        .plus-minus-input .input-group-field ::-webkit-outer-spin-button {
            -webkit-appearance: none;
            appearance: none;
        }

        .plus-minus-input .input-group-button .circle {
            border-radius: 50%;
            padding: 0.25em 0.8em;
        }


        .blog-hero {
            background: linear-gradient(180deg, #0d6efd 0%, #f8fafc 100%);
            padding: 40px 0 90px 0;
        }

        .blog-hero h1 {
            color: #fff;
            font-size: 40px;
            font-weight: 700;
        }

        .blog-hero p {
            color: #e5e7eb;
            max-width: 700px;
            margin: 15px auto 0;
        }

        .blog-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
            transition: .3s ease;
            height: 100%;
        }

        .blog-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .12);
        }

        .blog-img img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: .4s ease;
        }

        .blog-card:hover .blog-img img {
            transform: scale(1.05);
        }

        .blog-content {
            padding: 20px;
        }

        .blog-category {
            font-size: 13px;
            color: #0d6efd;
            margin-bottom: 8px;
        }

        .blog-title {
            font-size: 18px;
            font-weight: 600;
            line-height: 1.4;
        }

        .blog-title a {
            color: #1f2937;
        }

        .blog-desc {
            font-size: 14px;
            color: #6b7280;
            margin: 10px 0 15px;
        }

        .read-more {
            font-weight: 600;
            font-size: 14px;
            color: #0d6efd;
        }


        .sidebar .widget {
            background: #fff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
            margin-bottom: 25px;
        }

        .widget-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;

        }

        .categories li a {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            color: #374151;
        }

        .categories li a:hover {
            color: #0d6efd;
        }
        .page-item.active .page-link {
            background: #0d6efd;
            border-color: #0d6efd;
        }
        .listpgWraper {
            background: #f8fafc;
            padding: 0 0;
        }
        .blog-filter-card{

            border: 2px solid #0769f97a;
            position:relative;
            background:#ffffff;
            padding: 12px 20px;
            border-radius:8px;
            box-shadow:0 15px 40px rgba(0,0,0,.08);
            margin-bottom:25px;
        }
        .blog-category-dropdown{
            border-radius:12px;
            padding:12px;
            cursor:pointer;
        }
        .blog-search-box{
            position:relative;
        }
        .blog-search-input{
            padding:12px 95px 12px 15px; /* right space for button */
            border-radius:12px;
        }
        .blog-search-btn{
            position:absolute;
            right:8px;
            top:50%;
            transform:translateY(-50%);
            background:#0d6efd;
            border:none;
            color:#fff;
            padding:12px 24px;
            border-radius:10px;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
        }
        .blog-search-btn:hover{
            background:#0b5ed7;
        }
        .form-control{
            height: calc(2.25em + .75rem + 2px);
        }
    </style>
@endpush
@push('scripts')
    @include('includes.immediate_available_btn')
    <script>
    </script>
@endpush