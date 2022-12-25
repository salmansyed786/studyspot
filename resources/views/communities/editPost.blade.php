@php
    use App\Models\Community;
@endphp

@include('components.modals')

<x-layout>
    <body>
        <div class="container-fluid" id="main-container">
            <!-- Navbar -->
            <nav class="d-flex flex-column flex-shrink-0 bg-light my-navbar" style="width: 4.5rem;">
                <!-- studySpot Brand and Icon -->
                <a class="navbar-brand border-bottom" href="/">
                    <div class="brand-wrapper">
                        <img src="{{ asset('images/study.png') }}" alt="studySpot Logo" width="35" title="studySpot">
                    </div>
                </a>
                <!-- Options: create post, create cmty, browse cmties, and help -->
                <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
                    <li class="nav-item">
                        <button tabindex="-1" onclick="location.href='/create/post'" type="button"
                            class="btn material-symbols-outlined create-btn" data-toggle="tooltip" data-placement="right"
                            title="Create Post" id="createPostBtn">
                            library_add
                        </button>
                    </li>
                    <li class="nav-item">
                        <button tabindex="-1" data-bs-toggle="modal" data-bs-target="#cmtyModal" type="button"
                            class="btn material-symbols-outlined create-btn" data-toggle="tooltip" data-placement="right"
                            title="Create Community" id="createCmtyBtn">
                            group_add
                        </button>
                    </li>
                    <li class="nav-item">
                        <!-- Log in btn trigger modal -->
                        <button type="button" class="btn navbar-btn create-btn material-symbols-outlined"
                            data-bs-toggle="modal" data-bs-target="#advancedsearch-modal" data-toggle="tooltip"
                            data-placement="right" title="Search studySpot">
                            search
                        </button>
                    </li>
                    <li class="nav-item">
                        <button tabindex="-1" type="button" class="btn material-symbols-outlined create-btn"
                            data-toggle="tooltip" data-placement="right" title="Help">
                            help
                        </button>
                    </li>
                </ul>

            </nav>

            <!-- Post Guidelines (Hidden Content) -->
            <div id="guidelines-popover-content" class="hidden-info">
                <div>
                    <!-- Guidelines -->
                    <ol class="list-group list-group-numbered posts">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Respect other members</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Read the community's rules</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Look for the original source of content</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Foster meaningful and genuine interactions</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Have fun!</div>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Main Body -->
            <div class="container-fluid main-body" id="create-mbody">
                <!-- Body -->
                <div class="container" id="create-field">
                    <!-- Rules and Guidelines -->
                    <div class="container-fluid side-content-wrapper">
                        <div class="container-fluid side-content">
                            <div class="container side-content-header">
                                studySpot
                            </div>
                            <ol class="list-group list-group-numbered posts">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Respect other members</div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Read the community's rules</div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Look for the original source of content</div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Foster meaningful and genuine interactions</div>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Have fun!</div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>

                    <!-- Create a post -->
                    <div class="container-fluid create-post-wrapper">
                        <div class="create-title">
                            <label>Edit Post</label>
                            <a tabindex="0" class="btn material-symbols-outlined create-btn" role="button"
                                id="guidelines-popover">info</a>
                        </div>
                        <form method="post" action="/c/{{$cmty->community_name}}/{{$post->id}}" id="new-post" enctype="multipart/form-data">
                            @csrf                   
                            @method('PUT')
                            {{-- Post Title --}}
                            <div class="form-group mb-2">
                                <label for="titleInput">Title: </label>
                                <input type="text" class="form-control" id="titleInput" placeholder="My Fun Study Session"
                                    name="title" autocomplete="off" value="{{ $post->title }}" required>
                                @error('title')
                                    <p class="mt-1 small text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        
                            {{-- Post Tags --}}
                            <div class="form-group mb-2">
                                <label for="tagsInput">Tags: </label>
                                <input type="text" class="form-control" id="tagsInput" placeholder="Example: fun, study, help"
                                    name="tags" autocomplete="off" value="{{ $post->tags }}">
                                @error('tags')
                                    <p class="mt-1 small text-danger">{{$message}}</p>
                                    @enderror
                            </div>
                        
                            {{-- Post Description --}}
                            <div class="form-group mb-2">
                                <label for="exampleFormControlTextarea1">Description:</label>
                                <textarea class="my_tinymce form-control" rows="3" name="description">{{ $post->description }}</textarea>
                                @error('description')
                                    <p class="mt-1 small text-danger">{{$message}}</p>
                                @enderror
                            </div>
            
                            {{-- Community --}}
                            <div class="form-group mb-2">
                                <div class="forum-options" id="community-options">
                                    <label for="inputState">Community:</label>
                                    <div class="form-group col-md-8" style="display: flex;">
                                        {{-- Select a Community --}}
                                        <select id="inputState" class="form-select" name="community_id" required>
                                            @foreach ($communities as $community)
                                                @if ($community->id == $cmty->id)
                                                    <option selected value="{{$cmty->id}}">{{$cmty->community_name}}</option>
                                                @else
                                                    <option value="{{$community->id}}">{{$community->community_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        {{-- Create a Community --}}
                                        <button tabindex="-1" data-bs-toggle="modal" data-bs-target="#cmtyModal" type="button"
                                            class="btn material-symbols-outlined" title="Create a Community" id="add-cmty-btn"
                                            style="color:#FFCB05;">group_add
                                        </button>
                                    </div>
                                </div>

                                @error('community_id')
                                    <p class="mt-1 small text-danger">{{$message}}</p>
                                @enderror
                            </div>

                            {{-- Add an image --}}
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="image" accept="image/*" value="{{ $post->image }}">
                                <label class="custom-file-label" for="customFile">Add an image</label>
                            </div>
                            <img src= {{ $post->image ? asset('/storage/' . $post->image) : asset('/images/no-image.png') }} class="img-fluid" alt="no img" style="width: 125px; height: 100px;">


                            {{-- Color --}}
                            <div class="container" style="display: flex;">
                                <label for="exampleColorInput" class="form-label">Post Color:</label>
                                <input type="color" class="form-control form-control-color" id="exampleColorInput" 
                                            value="{{ $post->color }}" title="Choose your color" name="color">
                            </div>

                            {{-- Author --}}
                            <input type="hidden" id="author" name="author" value="john">
                    
                            {{-- Submit Button --}}
                            <div class="post-btns">
                                <button type="submit" id="post-btn" name="create-post-submit" class="btn">Update</button>
                                {{-- Back Button --}}
                                <a href="/c/{{$cmty->community_name}}" class="btn">Back</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <div class="container footer-wrapper">
                    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top"
                        id="footer">
                        <a href="/"
                            class="col-md-4 d-flex align-items-center justify-content-center mb-2 link-dark text-decoration-none"
                            id="title-img">
                            <img src="{{ asset('images/study.png') }}" alt="" width="40">
                        </a>
                        <p class="col-md-4 mb-0" style="color: #00274C; text-align: center;">&copy; 2022 studySpot, Inc</p>
                    </footer>
                </div>
            </div>

        </div>
    </body>
</x-layout>



