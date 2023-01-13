@php
    use App\Models\Community;
    use App\Models\Post;
    use App\Models\User;
@endphp

@include('components.modals')

<x-layout>
    @if (isset($signup) and $signup == true)
    <script>
        $(document).ready(function() {
            // Modal Signup Modal
            $('#signup-modal').modal('show');
        });
    </script>
    @elseif (isset($login) and $login == true)
    <script>
        $(document).ready(function() {
            // Modal Signup Modal
            $('#login-modal').modal('show');
        });
    </script>
    @endif

    <!-- Community Page:  -->
    <div class="container-fluid main-body">
        <div class="container" style="display: flex;">
            <!-- Body --> 
            <div class="container body-wrapper">
                <div class="card text-center" style="height: 100%;">
                    <div class="card-header">
                        <!-- Dropdown Cmty -->
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                aria-expanded="false" style="background-color:#00274C; color:#FFCB05">
                                <label style="font-size: 25px;">
                                    Home            
                                </label>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <li>
                                    <a class="dropdown-item searching">
                                        <a href="/" class="btn material-symbols-outlined" id="takeMeHome">home</a>
                                        <form class="d-flex" role="search" method="GET" action="/search">
                                            <input class="form-control me-2 search-bar" type="search"
                                                placeholder="community search" aria-label="Search" name="community"
                                                autocomplete="off">
                                        </form>
                                    </a>
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
                        <div class="container" id="searchbar">
                            <button type="button" class="btn navbar-btn create-btn material-symbols-outlined"
                                data-bs-toggle="modal" data-bs-target="#search-modal" data-toggle="tooltip"
                                data-placement="right" title="search">
                                search
                            </button>
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
                        <div class="mt-g p-4">
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Side -->
            <div class="container body-wrapper" id="side">
                <!-- About the Cmty -->
                <div class="container" style="margin-bottom: 10px;">
                    <div class="card text-center" id="cmty-card">
                        <div class="card-header" style="display: flex; justify-content: center; max-height: 200px">
                            <img class="card-img-top" src="{{ asset('images/study.png') }}" alt="Community Image" style="border: 1px #FFCB05 solid; border-radius: 2px; height: 150px; width: 150px;">
                        </div>

                        <div class="card-body" style="display: flex; align-items: center; flex-direction: column;">
                            <h5 class="card-title">
                                Welcome to studySpot
                            </h5>
                            <p class="card-text" style="width: 75%; margin: 0;">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                                Voluptatibus natus cupiditate nam perspiciatis cum. Facilis,
                                magnam similique, pariatur unde sunt praesentium distinctio 
                                quasi non exercitationem necessitatibus, porro sed illo temporibus.
                            </p>

                            {{-- Leave/Join Btns --}}
                            <button class="btn" style="background-color: #00274C; color:#FFCB05;">Join</button> {{--or Leave--}}
                        </div>
                        
                        <div class="card-footer text-muted">
                            @php
                                $total_member_count = 0;
                                $total_post_count = 0;

                                foreach ($communities as $community) {
                                    $total_member_count +=$community->members;
                                    $total_post_count += $community->posts;
                                }
                                
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
                <!-- Recommended Communities -->
                <div class="container">
                    <div class="card text-center" id="cmty-card">
                        <div class="card-header" style="display: flex; justify-content: center;">
                            <label style="color:#FFCB05; font-size: 17px; padding: 10px;">
                                Recommended
                            </label>
                        </div>

                        <div class="card-body" style="">
                            <div class="list-group">                                    
                                @foreach ($communities as $community)
                                    <a href="/c/{{ $community->community_name }}" class="list-group-item list-group-item-action" 
                                        style="">
                                        {{ $community->community_name }}
                                    </a>
                                @endforeach
                            </div>
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
                                    <a href="/?tag={{ $tag }}" class="badge badge-dark" style="background-color: {{ $colors[$index][0] }}; color: {{ $colors[$index][1] }}; margin: 2px;">{{ $tag }}</a>
                                    @php
                                        // if total tags is more than 20, break
                                        if ($total_tags > 20)
                                            break;
                                            
                                        $index++;
                                        $total_tags++;
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
                <p class="col-md-4 mb-0" style="color: #00274C; text-align: center;">&copy; 2022 studySpot, Inc</p>
            </footer>
        </div>
    </div>
</x-layout>

