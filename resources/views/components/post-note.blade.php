@props(['post', 'community'])

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
            <small>{{$post->author}} • {{$post->created_at}}</small>
        </div>
        <div class="interactions">
            <button tabindex="-1"
                class="bi bi-hand-thumbs-up interaction-btn like like_{{$post->id}}"
                id="like_{{$post->id}}">
                <span class="like-count likes_{{$post->id}}"
                    id="likes_{{$post->id}}">{{$post->likes}}</span>
            </button>
            <button tabindex="-1"
                class="bi bi-hand-thumbs-down-fill selected interaction-btn unlike unlike_{{$post->id}}"
                id="unlike_{{$post->id}}">
                <span class="dislike-count unlikes_{{$post->id}}"
                    id="unlikes_{{$post->id}}">{{$post->dislikes}}</span>
            </button>
            <button tabindex="-1" class="bi bi-chat-left-text interaction-btn"
                data-id='{{$post->id}}' data-bs-toggle="modal"
                data-bs-target="#commentModal">
                <span class="comment-count">{{$post->comments}}</span>
            </button>
        </div>
    </a>
</li>

<!-- Enlarged Post -->
<div class="modal fade" id="noteModal-{{$post->id}}" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered fetched-data" style="width: 450px; height: 400px;" id="enlarged-data">
        <x-enlarged-post :post="$post" :community="$community" />
    </div>
</div>