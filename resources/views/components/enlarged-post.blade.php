@props(['post', 'community', 'username', 'liketype', 'disliketype'])

<div class="modal-content" style="width: 100%; height: 400px; padding: 15px; border-radius: 5px; background-color: {{ $post['color'] }}; color: {{ $post['textColor'] }}">
    <div class="modal-header border-0">
        <h1 class="modal-title fs-5" id="noteModalLabel">{{$post['title']}} </h1>
        {{-- <a href= "/c/{{ $community['community_name'] }}/{{ $post['id'] }}/edit">
            <i class="fa-solid fa-pencil" title="edit" style="color: {{ $post['textColor'] }}"></i>
        </a> --}}

        {{-- <form action="/c/{{ $community['community_name'] }}/{{ $post['id'] }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-primary fa-solid fa-trash bg-danger p-1 text-light"
                title="delete" onclick="return confirm('Are you sure you want to delete this post?')"></button>
        </form> --}}

    </div>
    <div class="modal-body">
        <div class="container" style="padding-left: 15px;">
            <div id="descrip">
                <h6>{{$post['description'] }}</h6>
                @if ($post['image'] != null)
                    <img src="{{ asset('/storage/' . $post['image']) }}" class="img-fluid" alt="no img" style="width: 125px; height: 100px;">
                @endif
            </div>
            
            <p style="font-size: 12px;">{{ $community['community_name'] }} • {{ $username }} • {{ $post->created_at->diffForHumans() }}</p>
            <div class="interactions">
                <button tabindex="-1" class="bi {{$liketype}} interaction-btn like" data-post="{{$post}}" id="likeBtn-{{$post->id}}-enlarge">
                    <span class="like-count">{{$post->likes}}</span>
                </button>
                <button tabindex="-1" class="bi {{$disliketype}} interaction-btn dislike" data-post="{{$post}}" id="dislikeBtn-{{$post->id}}-enlarge">
                    <span class="dislike-count">{{$post->dislikes}}</span>
                </button>
                <button tabindex="-1" class="bi bi-chat-left-text interaction-btn">
                    <span class="comment-count">{{$post['comments'] }}</span>
                </button>
            </div>
        </div>
    </div>		
</div>