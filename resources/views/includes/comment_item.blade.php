
<div class="comment-item reply" id="comment-{{ $comment->id }}">
    <div class="comment-avatar">
        <img src="{{ asset('user_images/'.($comment->user->image ?: 'default.png')) }}" alt="{{ $comment->user->name }}">
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
<div class="reply-form d-none mt-3">
    <form class="ajax-reply-form">
        @csrf
        <input type="hidden" name="blog_id" value="{{ $comment->blog_id }}">
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <div class="reply-input-box">
            <textarea name="comment" class="form-control" rows="2" required placeholder="Reply to {{ $comment->user->name }}..."></textarea>
        </div>
        <div class="mt-2 text-right">
            <button type="submit" class="btn btn-primary btn-sm">Post Reply</button>
            <button type="button" class="btn btn-light btn-sm reply-cancel ml-2">Cancel</button>
        </div>
    </form>
</div>
<div class="comment-replies mt-2" id="replies-{{ $comment->id }}">
    @if($comment->replies)
        @foreach($comment->replies as $nestedReply)
            @include('includes.comment_item', ['comment' => $nestedReply])
        @endforeach
    @endif
</div>
</div>
</div>