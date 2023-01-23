@props(['post', 'community', 'username'])
@php
    use App\Models\Like;
    use App\Models\User;
    use App\Models\Comment;
@endphp

{{-- Sticky Post --}}
<li class="note">
    <a class="sticky-note" data-post={{ $post }} style="background-color: {{ $post['color'] }}; color: {{ $post['textColor'] }}">
        <div class="sticky-note-info">
            <small>{{ $community->community_name }}</small>
            <button class="btn bi bi-arrows-angle-expand" data-post='{{ json_encode($post) }}' data-community='{{ json_encode($community) }}'
                data-bs-toggle="modal" data-bs-target="#noteModal-{{$post->id}}" style="color: {{ $post['textColor'] }}">
            </button>
        </div> 
        <div class="sticky-note-title">
            <h6>{{ $post->title }}</h6>
        </div>
        <div class="sticky-note-info">
            {{-- call timeSince() function --}}
            <small>{{ $username }} • {{ $post->created_at->diffForHumans() }}</small>
        </div>
        <div class="interactions">
            @php

            $likeBtnType = 'bi-hand-thumbs-up';
            $dislikeBtnType = 'bi-hand-thumbs-down';
            $liked = null;
            $comments = Comment::where('post_id', $post->id)->get();
            // loop through all comments and add user_id to array
            $commenters = [];
            foreach ($comments as $comment) {
                // Get user_id from comment
                $commenter = $comment->user_id;
                // Get username
                $commenter = User::where('id', $commenter)->get("username");
                array_push($commenters, $commenter);
            }

            // array to string
            $commenters = implode(", ", $commenters);
            // remove garbage
            $commenters = str_replace(array('{', '}','[', ']','"','username',':'), '', $commenters);
            // remove whitespace
            $commenters = preg_replace('/\s+/', '', $commenters);

            @endphp
            
            @auth
            {{-- Check if post is liked or disliked --}}
            @php

            if (Like::where('post_id', $post->id)->where('user_id', Auth::user()->id)->where('isLike', true)->exists()) {
                $liked = true;
                $likeBtnType = 'bi-hand-thumbs-up-fill';
                $dislikeBtnType = 'bi-hand-thumbs-down';
            } elseif (Like::where('post_id', $post->id)->where('user_id', Auth::user()->id)->where('isLike', false)->exists()) {
                $liked = false;
                $likeBtnType = 'bi-hand-thumbs-up';
                $dislikeBtnType = 'bi-hand-thumbs-down-fill';
            }

            @endphp

            <button tabindex="-1" class="bi {{$likeBtnType}} interaction-btn like" data-post="{{$post}}" id="likeBtn-{{$post->id}}-small">
                <span class="like-count">{{$post->likes}}</span>
            </button>
            <button tabindex="-1" class="bi {{$dislikeBtnType}} interaction-btn dislike" data-post="{{$post}}" id="dislikeBtn-{{$post->id}}-small">
                <span class="dislike-count">{{$post->dislikes}}</span>
            </button>
            <button tabindex="-1" class="bi bi-chat-left-text interaction-btn commentBtn" id="commentBtn-{{$post->id}}-small"
                data-bs-toggle="modal"
                data-bs-target="#commentModal"
                data-postid="{{$post->id}}"
                data-log="in"
                data-url="/{{$post->id}}/comments">
                <span class="comment-count">{{$post->comments}}</span>
            </button>

            {{-- NOT LOGGED IN --}}
            @else
            
            <button tabindex="-1" class="bi {{$likeBtnType}} interaction-btn like" 
                data-bs-toggle="modal" 
                data-bs-target="#signup-modal">
                <span class="like-count">{{$post->likes}}</span>
            </button>
            <button tabindex="-1" class="bi {{$dislikeBtnType}} interaction-btn dislike" 
                data-bs-toggle="modal" 
                data-bs-target="#signup-modal">
                <span class="dislike-count">{{$post->dislikes}}</span>
            </button>
            <button tabindex="-1" class="bi bi-chat-left-text interaction-btn commentBtn" id="commentBtn-{{$post->id}}-small"
                data-bs-toggle="modal"
                data-bs-target="#commentModal"
                data-postid="{{$post->id}}"
                data-log="out"
                data-url="/{{$post->id}}/comments">
                <span class="comment-count">{{$post->comments}}</span>
            </button>

            @endauth
        </div>
    </a>
</li>

<!-- Enlarged Post -->
<div class="modal fade" id="noteModal-{{$post->id}}" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered fetched-data" style="width: 450px; height: 400px;" id="enlarged-data">
        <x-enlarged-post :post="$post" :community="$community" :username="$username" :liketype="$likeBtnType" :disliketype="$dislikeBtnType" />
    </div>
</div>