@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end -->
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('Blog')])
<!-- Inner Page Title end -->

<header id="blog-headerwrap" class="text-center">
{{--    <div class="container-fluid">--}}
{{--        <section id="blog-header" class="text-center">--}}
{{--            <h1>{{$serach_result}}</h1>--}}
{{--        </section>--}}
{{--    </div>--}}
    <div class="container-fluid p-0 m-0">
        <div class="row blog-hero m-0">
            <section id="joblisting-header" class="text-center">
                <h1>{{$serach_result}}</h1>
            </section>
        </div>
    </div>
</header>

<section id="blog-content">
    <div class="container">


        <div class="row blog-filter-row mt-4">
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



        <!-- Blog start -->
        <div class="row">
            <div class="col-lg-9 mt-4">
                <!-- Blog List start -->
                <div class="blogwrapper">

                    <ul class="blogList row">
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
                       
                       <li class="col-lg-6">
                            <div class="">
                                <div class="blog-card">
                                <div class="postimg">{{$blog->printBlogImage()}}</div>

                                <div class="blog-content">
                                    <h4><a href="{{route('blog-detail',$blog->slug)}}">{{$blog->heading}}</a></h4>
                                    <div class="postmeta">Category : {!!implode(', ',$cate_array)!!}
                                    </div>
                                    <p>{!! \Illuminate\Support\Str::limit($blog->content, $limit = 150, $end = '...') !!}</p>
                                </div>


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
                        {{ $blogs->appends(request()->query())->links() }} @endif
                    </nav>
                </div>
            </div>
{{--			 <div class="col-lg-3">--}}

{{--				 <div class="sidebar">--}}
{{--          <!-- Search -->--}}
{{--          <div class="widget">--}}
{{--            <h5 class="widget-title">Search</h5>--}}
{{--            <div class="search">--}}
{{--              <form action="{{route('blog-search')}}" method="GET">--}}
{{--                <input type="text" class="form-control" placeholder="Search" name="search">--}}
{{--                <button type="submit" class="btn"><i class="fa fa-search"></i></button>--}}
{{--              </form>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--          <!-- Categories -->--}}
{{--          @if(null!==($categories))--}}
{{--          <div class="widget">--}}
{{--            <h5 class="widget-title">Categories</h5>--}}
{{--            <ul class="categories">--}}
{{--            @foreach($categories as $category)--}}
{{--              <li><a href="{{url('/blog/category/').'/'.$category->slug}}">{{$category->heading}}</a></li>--}}
{{--            @endforeach--}}
{{--            </ul>--}}
{{--          </div>--}}
{{--          @endif--}}
{{--        </div>--}}
{{--			</div>--}}
        </div>
		<div class="py-5"></div>
    </div>
</section>




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



.blog-filter-card{
    margin-left: 4px;
    margin-right: 4px;
    border: 2px solid #0769f97a;
    position:relative;
    background:#ffffff;
    padding: 12px 20px;
    border-radius:8px;
    box-shadow:0 15px 40px rgba(0,0,0,.08);
    /*margin-bottom:25px;*/
}
.blog-category-dropdown{
    border-radius:12px;
    padding:12px;
    cursor:pointer;
}

.blog-search-box{
    position:relative;
}
.form-control{
    height: calc(2.25em + .75rem + 2px);
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

.blog-hero {
    background: linear-gradient(180deg, #0d6efd 0%, #f8fafc 100%);
    padding: 20px 0 20px 0;
    display: flex;
    align-items: center;      /* vertical center */
    justify-content: center;
    min-height: 100px;
}

.blog-hero h1 {
    color: #fff;
    font-size: 40px;
    font-weight: 700;
}


.blog-card:hover .blog-img img {
    transform: scale(1.05);
}


.blog-card {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
    transition: .3s ease;
    height: 100%;
}


.blog-content {
    padding: 20px;
}


section#joblisting-header h1 {
    margin-top: 0 !important;
}

</style>
@endpush
@push('scripts')
@include('includes.immediate_available_btn')
<script>
</script>
@endpush
