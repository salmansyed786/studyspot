@php
    use App\Models\Community;
    use App\Models\User;
    use App\Models\Post;
    use App\Models\Membership;
@endphp

@include('components.modals', $cmty)

<x-layout>
    <!-- Community Page:  -->
    <div class="container-fluid main-body p-0">
        <!-- Body --> 
        <div class="container m-0" style="display: flex; min-width: 90%;">
            <!-- Post --> 
            <div class="container body-wrapper">
                <div class="card text-center" style="height: 100%;">
                    <div class="card-header">
                        <!-- Dropdown Cmty -->
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                aria-expanded="false" style="background-color:#00274C; color:#FFCB05">
                                <label style="font-size: 25px;">
                                    {{ $cmty['community_name'] }}            
                                </label>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <li>
                                    <div class="cmty-search">
                                        <!-- Community Search Bar -->
                                        <div class="container p-0" id="cmty-searchbar" style="width: 300px;">
                                            <div class="" style="width: 100%;">
                                                <div class="form-wrapper m-0 p-1">
                                                    <form action="/search" method="GET" class="search-form">
                                                        <a href="/" class="btn material-symbols-outlined home-btn" id="takeMeHome">home</a>
                                                        <input type="search" class="form-control form-input" name="community" placeholder="community search..." autocomplete="off"
                                                        style="text-indent: 50px;">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                @unless (count($communities) == 0)
                                    @foreach ($communities as $community)
                                        @if (is_object($community))
                                            <li>
                                                <a class="dropdown-item" href="/c/{{ $community['community_name'] }}">
                                                    {{ $community['community_name'] }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                    @else
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                No Communities Found
                                            </a>
                                        </li>
                                @endunless
                                    
                            </ul>
                        </div>
                        <!-- Search bar -->
                        <div class="container" id="all-searchbar">
                            <div class="row height d-flex justify-content-center align-items-center" style="width: 100%;">
                                <div class="col-md-6 form-wrapper">
                                    <form action="/" method="GET" class="search-form">
                                        <i class="fa fa-search"></i>
                                        <input type="text" class="form-control form-input" name="search" placeholder="search anything..." autocomplete="off">
                                        {{-- <span class="left-pan"><i class="fa fa-microphone"></i></span> --}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="display: flex; align-items: center; flex-direction: column;">
                        <div class="container stickies-wrapper">
                            <!-- Get all posts from DB -->
                            <ul class="sticky-notes">
                                @foreach ($posts as $post)
                                    @php
                                        $community = Community::where('id', $post->community_id)->first();
                                        $username = User::find($post->user_id)->username;
                                    @endphp
                                    <x-post-note :post="$post" :community="$community" :username="$username" />
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="mt-g p-4">
                        {{-- Pagination --}}
                        {{ $posts->links() }} 
                    </div>
                </div>
            </div>
            <!-- Side -->
            <div class="container body-wrapper" id="side">
                <!-- About the Cmty -->
                <div class="container" style="margin-bottom: 10px;">
                    <div class="card text-center" id="cmty-card">
                        <div class="card-header" style="display: flex; justify-content: center; max-height: 200px">
                            <img class="card-img-top img-fluid" 
                                src="{{ $cmty->image ? asset('/storage/' . $cmty->image) : asset('/images/study.png') }} " 
                                alt="Community Image" 
                                style="border-radius: 2px; height: 150px; width: 150px;">
                        </div>

                        <div class="card-body" style="display: flex; align-items: center; flex-direction: column;">
                            <span>
                                <h5 class="card-title">
                                    {{$cmty['community_name']}}
                                </h5>
                                <button data-bs-toggle="modal" data-bs-target="#cmtyEditModal" class="fa-solid fa-pencil btn" title="edit"></button>
                            </span>

                            <p class="card-text" style="width: 75%; margin: 0;">
                                {{$cmty['about']}}
                            </p>

                            @auth
                            {{-- Leave/Join Btns --}}
                            {{-- Check if current user is a member of the community --}}
                            @php
                            Membership::where('user_id', Auth::user()->id)->where('community_id', $cmty->id)->exists() ? $isMember = true : $isMember = false;
                            @endphp
                            @if ($isMember)
                            <form action="/c/{{ $cmty['community_name'] }}/leave" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn submit" style="background-color: #00274C; color:#FFCB05;" title="leave" onclick="return confirm('Are you sure you want to leave?')">Leave</button> 
                            @else
                            <form action="/c/{{ $cmty['community_name'] }}/join" method="POST">
                                @csrf
                                @method('POST')
                                <button class="btn submit" style="background-color: #00274C; color:#FFCB05;" title="join">Join</button>
                            @endif
                            </form>
                            @else
                            <button type="button" class="btn" style="background-color: #00274C; color:#FFCB05;"
                            data-bs-toggle="modal" data-bs-target="#signup-modal">Join</button>
                            @endAuth
                        </div>
                        
                        <div class="card-footer text-muted">
                            @php
                                $total_member_count = Membership::where('community_id', $cmty->id)->count();
                                $total_post_count = Post::where('community_id', $cmty->id)->count();
                                
                                if ($total_member_count == 1 && $total_post_count == 1) {
                                    echo $total_member_count.' Member • '.$total_post_count.' Post';
                                }
                                else if ($total_member_count == 1) {
                                    echo $total_member_count.' Member • '.$total_post_count.' Posts';
                                }
                                else if($total_post_count == 1) {
                                    echo $total_member_count.' Members • '.$total_post_count.' Post';
                                }
                                else {
                                    echo $total_member_count.' Members • '.$total_post_count.' Posts';
                                }
                            @endphp
                        </div>
                    </div>
                </div>
                <!-- Tags and Similar Communities -->
                <div class="container">
                    <div class="card text-center" id="cmty-card">
                        <div class="card-header" style="display: flex; justify-content: center;">
                            <label style="color:#FFCB05; font-size: 17px; padding: 10px;">
                                Recommended
                            </label>
                        </div>
                        <div class="card-body" style="">
                            {{-- Recommended Communities --}}
                            <div class="list-group">                                    
                                @foreach ($communities as $community)
                                    <a href="/c/{{ $community->community_name }}" class="list-group-item list-group-item-action" 
                                        style="">
                                        {{ $community->community_name }}
                                    </a>
                                @endforeach
                            </div>
                            {{-- Tags --}}
                            <div class="container tags" style="display: flex; justify-content: center; align-items: center; margin: 10px; flex-wrap:wrap;">
                                @php
                                    $colors = array(['red', 'white'], ['green', 'white'], ['blue', 'white'], ['yellow', 'black'], ['orange', 'black'], ['purple', 'white'], ['pink', 'black'], ['brown', 'white'], ['grey', 'white'], ['bisque', 'black']);
                                    $index = 0;
                                    $total_tags = 0;
                                    $all_tags = '';
                                    foreach ($posts as $post)
                                            $all_tags .= $post->tags;
                                    $all_tags = explode(' ', $all_tags);
                                    $tags = array_unique($all_tags);
                                @endphp
                                @foreach ($tags as $tag)
                                    <a href="./{{ $cmty['community_name'] }}?tag={{ $tag }}" class="badge badge-dark" style="background-color: {{ $colors[$index][0] }}; color: {{ $colors[$index][1] }}; margin: 2px;">{{ $tag }}</a>
                                    @php
                                        if ($total_tags > 20)
                                            break;
                                        $index++;
                                        if ($index == 10) {
                                            $index = 0;
                                        }
                                    @endphp
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="container footer-wrapper">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top" id="footer">
                <a href="/"
                    class="col-md-4 d-flex align-items-center justify-content-center mb-3 link-dark text-decoration-none"
                    id="title-img">
                    <img src="{{ asset('images/study.png') }}" alt="" width="40">
                </a>
                <p class="col-md-4 mb-0" style="color: #00274C; text-align: center;">&copy; 2023 studySpot, Inc</p>
            </footer>
        </div>
    </div>
</x-layout>
