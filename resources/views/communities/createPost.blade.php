@php
    use App\Models\Community;
@endphp

@include('components.modals')

<x-layout>
    <body>
        <div class="container-fluid" id="main-container">
            <!-- Navbar -->
            <x-navbar/>

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
                            <label>Create a Post</label>
                            <a tabindex="0" class="btn material-symbols-outlined create-btn" role="button"
                                id="guidelines-popover">info</a>
                        </div>
                        <form method="POST" action="/posts" id="new-post" enctype="multipart/form-data">
                            @csrf                                        
                            {{-- Post Title --}}
                            <div class="form-group mb-2">
                                <label for="titleInput">Title: </label>
                                <input type="text" class="form-control" id="titleInput" placeholder="My Fun Study Session"
                                    name="title" autocomplete="off" value="{{old('title')}}" >
                                @error('title')
                                    <p class="mt-1 small text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        
                            {{-- Post Tags --}}
                            <div class="form-group mb-2">
                                <label for="tagsInput">Tags: </label>
                                <input type="text" class="form-control" id="tagsInput" placeholder="Example: fun, study, help"
                                    name="tags" autocomplete="off" value="{{old('tags')}}">
                                @error('tags')
                                    <p class="mt-1 small text-danger">{{$message}}</p>
                                    @enderror
                            </div>
                        
                            {{-- Post Description --}}
                            <div class="form-group mb-2">
                                <label for="exampleFormControlTextarea1">Description:</label>
                                <textarea class="my_tinymce form-control" rows="3" name="description">{{old('description')}}</textarea>
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
                                        <select id="inputState" class="form-select" name="community_id">
                                            {{-- Directed from /create/post --}}
                                            @if (empty($selectedCmty))
                                                <option selected disabled>Select a Community</option>
                                                {{-- Print out all communities --}}
                                                @foreach ($communities as $community)
                                                    {{-- If there is an error, keep the old value --}}
                                                    @if (old('community_id') == $community->id)
                                                        <option selected value="{{old('community_id')}}">{{$community->community_name}}</option>
                                                    @else
                                                        <option value="{{$community->id}}">{{$community->community_name}}</option>
                                                    @endif
                                                @endforeach
                                            {{-- Directed from /c/community_name/create --}}
                                            @else
                                                <option selected value="{{$selectedCmty->id}}">{{$selectedCmty->community_name}}</option>
                                                @foreach ($communities as $community)
                                                    {{-- If there is an error, keep the old value --}}
                                                    @if (old('community_id') == $community->id)
                                                        <option selected value="{{old('community_id')}}">{{$community->community_name}}</option>
                                                        @continue
                                                    @endif
                                                    {{-- If the community is the same as the selected community, skip it --}}
                                                    @if ($community->id == $selectedCmty->id)
                                                        @continue
                                                    @endif
                                                    <option value="{{$community->id}}">{{$community->community_name}}</option>
                                                @endforeach
                                            @endif
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
                                <input type="file" class="custom-file-input" id="customFile" name="image" accept="image/*">
                                <label class="custom-file-label" for="customFile">Add an image</label>
                            </div>

                            {{-- Color --}}
                            <div class="container" style="display: flex;">
                                <label for="exampleColorInput" class="form-label">Post Color:</label>
                                <input type="color" class="form-control form-control-color" id="exampleColorInput" 
                                            value="#FFFF99" title="Choose your color" name="color">
                            </div>

                            {{-- Author --}}
                            {{-- <input type="hidden" name="user_id" value="{{Auth::id()}}"> --}}
                    
                            {{-- Submit Button --}}
                            <div class="post-btns">
                                <button type="submit" id="post-btn" name="create-post-submit" class="btn">Post</button>
                                {{-- BAck button --}}
                                <a href="{{($selectedCmty)? "/c/".$selectedCmty->community_name : "/" }}" class="btn">Back</a>
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
                        <p class="col-md-4 mb-0" style="color: #00274C; text-align: center;">&copy; 2023 studySpot, Inc</p>
                    </footer>
                </div>
            </div>

        </div>
    </body>
</x-layout>
