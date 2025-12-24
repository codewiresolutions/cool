@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title'=>__('Blog Detail')])
    <!-- Inner Page Title end -->
    @if(null!==($blog))


        {{--<div class="listpgWraper">--}}

        <div class="listpgWraper blog-detail-page">

            <section id="blog-content">
                <div class="container">
                        <?php
                        $cate_ids = explode(",", $blog->cate_id);
                        $data = DB::table('blog_categories')->whereIn('id', $cate_ids)->get();
                        $cate_array = array();
                        foreach ($data as $cat) {
                            $cate_array[] = "<a href='" . url('/blog/category/') . "/" . $cat->slug . "'>$cat->heading</a>";
                        }
                        ?>
                            <!-- Blog start -->
                    <div class="row">

                        <div class="col-lg-9">
                            <!-- Blog List start -->
                            <div class="blogWraper">
                                <ul class="blogList">
                                    <li>


                                        <div class="blog-detail-card">

                                            <!-- Featured Image -->
                                            <div class="blog-detail-image">
                                                {{$blog->printBlogImage()}}
                                            </div>

                                            <!-- Content -->
                                            <div class="blog-detail-content">

                                                <div class="blog-detail-meta">
                                                    {!! implode(' , ', $cate_array) !!}
                                                </div>

                                                <h1 class="blog-detail-title">
                                                    {{$blog->heading}}
                                                </h1>

                                                <div class="blog-detail-body">
                                                    {!! $blog->content !!}
                                                </div>

                                            </div>

                                        </div>



                                        {{--                            <div class="bloginner">--}}


                                        {{--                                <div class="postimg">{{$blog->printBlogImage()}}</div>--}}


                                        {{--                                <div class="post-header">--}}
                                        {{--                                    <h2>{{$blog->heading}}</h2>--}}
                                        {{--                                    <div class="postmeta">Category : {!!implode(', ',$cate_array)!!}</div>--}}
                                        {{--                                </div>--}}
                                        {{--                                <p>{!! $blog->content !!}</p>--}}


                                        {{--                            </div>--}}
                                    </li>

                                </ul>
                            </div>


                        </div>

                        <div class="col-lg-3">

                            <div class="sidebar">
                                <!-- Search -->


                                <div class="widget">
                                    <h5 class="widget-title">Search</h5>
                                    <div class="search">
                                        <form action="{{route('blog-search')}}" method="GET">
                                            <input type="text" class="form-control" placeholder="Search" name="search">
                                            <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                                        </form>
                                    </div>
                                </div>


                                {{--          <div class="widget">--}}
                                {{--            <h5 class="widget-title">Search</h5>--}}
                                {{--            <div class="search">--}}
                                {{--              <form action="{{route('blog-search')}}" method="GET">--}}
                                {{--                <input type="text" class="form-control" placeholder="Search" name="search">--}}
                                {{--                <button type="submit" class="btn"><i class="fa fa-search"></i></button>--}}
                                {{--              </form>--}}
                                {{--            </div>--}}
                                {{--          </div>--}}
                                <!-- Categories -->
                                @if(null!==($categories))
                                    <div class="widget">
                                        <h5 class="widget-title">Categories</h5>
                                        <ul class="categories">
                                            @foreach($categories as $category)
                                                <li><a href="{{url('/blog/category/').'/'.$category->slug}}">{{$category->heading}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>


                    </div>


                    <div class="blog-comments pro-comments">

                        <h3 class="comments-title">Comments</h3>

                        <!-- New Comment -->
                        <div class="comment-input">
                            <form id="main-comment-form">
                                @csrf
                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                <textarea name="comment" class="comment-textarea" placeholder="Write a comment..." required></textarea>
                                <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
                            </form>
                        </div>

                        <!-- Comment List -->
                        <div class="comment-list" id="comment-container">

                            <!-- Root Comments -->
                            @foreach($comments as $comment)
                                <div class="comment-item" id="comment-{{ $comment->id }}">
                                    <div class="comment-avatar">
                                        <img src="{{ asset('user_images/'.($comment->user->image ?: 'default.png')) }}"
                                             alt="{{ $comment->user->name }}">
                                    </div>

                                    <div class="comment-body w-100">
                                        <div class="comment-author">
                                            {{ $comment->user->name }}
                                            <span class="comment-meta ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>

                                        <div class="comment-text">
                                            {{ nl2br(e($comment->comment)) }}
                                        </div>

                                        <div class="comment-meta mt-2">
                                            <a href="#" class="like-btn" data-id="{{ $comment->id }}">
                                                <i class="fa fa-thumbs-up"></i> Like (<span class="like-count">{{ $comment->likes->count() }}</span>)
                                            </a>

                                            <button type="button" class="btn btn-link btn-sm p-0 reply-toggle text-decoration-none" style="color: #0d6efd; font-weight: 500;">
                                                Reply
                                            </button>
                                        </div>

                                        <!-- Form to reply to THIS comment -->
                                        <div class="reply-form d-none mt-3">
                                            <form class="ajax-reply-form">
                                                @csrf
                                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                <div class="reply-input-box">
                                                    <textarea name="comment" class="form-control" rows="2" required placeholder="Write a reply..."></textarea>
                                                </div>
                                                <div class="mt-2 text-right">
                                                    <button type="submit" class="btn btn-primary btn-sm">Post Reply</button>
                                                    <button type="button" class="btn btn-light btn-sm reply-cancel ml-2">Cancel</button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Container for Nested Replies -->
                                        <div class="comment-replies mt-3" id="replies-{{ $comment->id }}">
                                            @foreach($comment->replies as $reply)
                                                @include('includes.comment_item', ['comment' => $reply])
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                </div>


        </div>
        </section>





        </div>

    @endif
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

        .blog-detail-page .blog-detail-card{
            background:#fff;
            padding:30px;
            border-radius:18px;
            box-shadow:0 12px 30px rgba(0,0,0,.06);
        }

        .blog-detail-page .blog-detail-image img{
            width:100%;
            height:auto;
            border-radius:16px;
            margin-bottom:25px;
        }

        .blog-detail-page .blog-detail-meta{
            font-size:14px;
            color:#0d6efd;
            margin-bottom:10px;
        }

        .blog-detail-page .blog-detail-title{
            font-size:32px;
            font-weight:700;
            line-height:1.3;
            margin-bottom:20px;
            color:#1f2937;
        }

        .blog-detail-page .blog-detail-body{
            font-size:16px;
            line-height:1.8;
            color:#374151;
        }

        .blog-detail-page .blog-detail-body p{
            margin-bottom:18px;
        }

        .blog-detail-page .blog-comments{
            margin-top:50px;
            background:#f8fafc;
            padding:30px;
            border-radius:16px;
        }

        .blog-detail-page .comments-title{
            font-size:22px;
            font-weight:600;
            margin-bottom:20px;
        }

        .blog-detail-page .comment-form .form-control{
            margin-bottom:15px;
            border-radius:12px;
            padding:12px;
        }

        .blog-detail-page .comment-submit{
            padding:10px 28px;
            border-radius:12px;
            font-weight:600;
        }

        /* Blog Detail Page – Search Bar */
        .blog-detail-page .blog-search-widget{
            background:#fff;
            padding:20px;
            border-radius:16px;
            box-shadow:0 10px 25px rgba(0,0,0,.05);
        }

        .blog-detail-page .blog-search-box{
            position:relative;
        }

        .blog-detail-page .blog-search-input{
            border-radius:12px;
            padding:12px 45px 12px 15px;
            font-size:14px;
        }

        .blog-detail-page .blog-search-btn{
            position:absolute;
            top:50%;
            right:10px;
            transform:translateY(-50%);
            background:#0d6efd;
            border:none;
            color:#fff;
            padding:8px 12px;
            border-radius:10px;
            cursor:pointer;
        }

        .blog-detail-page .blog-search-btn:hover{
            background:#084298;
        }


        .sidebar .widget{
            background:#fff;
            padding:20px;
            border-radius:16px;
            box-shadow:0 10px 25px rgba(0,0,0,.05);
            margin-bottom:25px;
        }
        .widget-title{
            font-size:18px;
            font-weight:600;
            margin-bottom:15px;
        }
        .categories li a{
            display:flex;
            justify-content:space-between;
            padding:8px 0;
            color:#374151;
        }
        .categories li a:hover{
            color:#0d6efd;
        }
        .sidebar{
            position:sticky;
            top:50px;
        }


        .blog-detail-page .pro-comments{
            background:#fff;
            padding:30px;
            border-radius:18px;
            box-shadow:0 12px 30px rgba(0,0,0,.06);
            margin-top:50px;
        }

        .blog-detail-page .comment-input,
        .blog-detail-page .comment-item{
            display:flex;
            gap:15px;
            margin-bottom:25px;
        }

        .blog-detail-page .comment-avatar img{
            width:45px;
            height:45px;
            border-radius:50%;
        }

        .blog-detail-page .comment-textarea,
        .blog-detail-page .reply-box textarea{
            width:100%;
            border-radius:12px;
            padding:12px;
            resize:none;
        }

        .blog-detail-page .comment-author{
            font-weight:600;
            margin-bottom:5px;
        }

        .blog-detail-page .comment-text{
            background:#f8fafc;
            padding:12px;
            border-radius:12px;
            margin-bottom:8px;
        }

        .blog-detail-page .comment-meta{
            font-size:13px;
            color:#6b7280;
        }

        .blog-detail-page .comment-meta a{
            margin-right:15px;
            color:#0d6efd;
            font-weight:500;
        }

        .blog-detail-page .reply-box{
            display:none;
            margin-top:10px;
        }

        .blog-detail-page .comment-replies{
            margin-top:20px;
        }

        .blog-detail-page .comment-item.reply {
            margin-left: 45px;
            border-left: 2px solid #e5e7eb;
            padding-left: 15px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .blog-detail-page .comment-replies {
            margin-top: 10px;
        }

        .like-btn.active {
            color: #0d6efd !important;
            font-weight: bold;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            function generateHtml(comment, isReply = false) {
                let avatar = comment.user.image ? comment.user.image : 'default.png';
                return `
                <div class="comment-item ${isReply ? 'reply' : ''}" id="comment-${comment.id}">
                    <div class="comment-avatar"><img src="/user_images/${avatar}"></div>
                    <div class="comment-body w-100">
                        <div class="comment-author">${comment.user.name} <span class="comment-meta ml-2">Just now</span></div>
                        <div class="comment-text">${comment.comment}</div>
                        <div class="comment-meta mt-2">
                            <a href="#" class="like-btn" data-id="${comment.id}"><i class="fa fa-thumbs-up"></i> Like (<span class="like-count">0</span>)</a>
                            <button type="button" class="btn btn-link btn-sm p-0 reply-toggle text-decoration-none" style="color:#0d6efd; font-weight:500;">Reply</button>
                        </div>
                        <div class="reply-form d-none mt-3">
                            <form class="ajax-reply-form">
                                <input type="hidden" name="blog_id" value="${comment.blog_id}">
                                <input type="hidden" name="parent_id" value="${comment.id}">
                                <textarea name="comment" class="form-control" rows="2" required placeholder="Write a reply..."></textarea>
                                <div class="mt-2 text-right">
                                    <button type="submit" class="btn btn-primary btn-sm">Post Reply</button>
                                    <button type="button" class="btn btn-light btn-sm reply-cancel ml-2">Cancel</button>
                                </div>
                            </form>
                        </div>
                        <div class="comment-replies mt-2" id="replies-${comment.id}"></div>
                    </div>
                </div>`;
            }

            // Post Root Comment
            $('#main-comment-form').on('submit', function(e) {
                e.preventDefault();
                $.post('/comment', $(this).serialize(), function(data) {
                    if(data.success) {
                        $('#comment-container').prepend(generateHtml(data.comment));
                        $('#main-comment-form textarea').val('');
                    }
                });
            });

            // Post Reply (any level)
            $(document).on('submit', '.ajax-reply-form', function(e) {
                e.preventDefault();
                let form = $(this);
                let parentId = form.find('input[name="parent_id"]').val();
                $.post('/comment', form.serialize(), function(data) {
                    if(data.success) {
                        $(`#replies-${parentId}`).append(generateHtml(data.comment, true));
                        form.find('textarea').val('');
                        form.closest('.reply-form').addClass('d-none');
                    }
                });
            });

            // Like (any level)
            $(document).on('click', '.like-btn', function(e) {
                e.preventDefault();
                let btn = $(this);
                $.post('/comment-like/' + btn.data('id'), function(data) {
                    if(data.success) {
                        btn.find('.like-count').text(data.likes_count);
                        btn.toggleClass('active', data.status === 'liked');
                    }
                });
            });

            // Toggles
            $(document).on('click', '.reply-toggle', function() {
                $(this).closest('.comment-body').find('.reply-form').first().toggleClass('d-none');
            });
            $(document).on('click', '.reply-cancel', function() {
                $(this).closest('.reply-form').addClass('d-none');
            });
        });
    </script>
@endpush