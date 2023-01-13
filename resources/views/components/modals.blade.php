<!-- MODALS -->
    <!-- Sign up Modal -->
    <div class="modal fade" id="signup-modal" tabindex="-1" aria-labelledby="signup-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signup-modalLabel">Sign Up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Main Body -->
                    <div class="container-fluid signup-container" style="padding-bottom: 0;">
                        <!-- Registeration Form -->
                        <form id="signup-form" method="POST" action="/register" enctype="multipart/form-data">
                            @csrf       
                            <div class="form-body">
                                <!-- User info -->
                                <div class="form-group">
                                    {{-- Username --}}
                                    <div class="form-group input-field">
                                        <label for="inputUserName">Username:</label>
                                        <input type="text" class="form-control" name="username" for="inputUserName"
                                            placeholder="" autocomplete="off" value="{{old('username')}}">
                                        @error('username')
                                            <p class="mt-1 small text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    {{-- Email --}}
                                    <div class="form-group input-field">
                                        <label for="inputEmail4">Email:</label>
                                        <input type="email" class="form-control" name="email" for="inputEmail4"
                                            placeholder="" autocomplete="off" value="{{old('email')}}">
                                        @error('email')
                                            <p class="mt-1 small text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    {{-- Password --}}
                                    <div class="form-group input-field">
                                        <label for="inputPassword4">Password:</label>
                                        <input type="password" class="form-control" name="password" for="inputPassword4"
                                            placeholder="">
                                        @error('password')
                                            <p class="mt-1 small text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    {{-- Confirm Password --}}
                                    <div class="form-group input-field">
                                        <label for="inputPassword5">Confirm Password:</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            for="inputPassword5" placeholder="">
                                        @error('password_confirmation')
                                            <p class="mt-1 small text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    {{-- Profile photo --}}
                                    <div class="form-group input-field">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="image" accept="image/*" value="{{old('image')}}">
                                            <label class="custom-file-label" for="customFile">Add an image</label>
                                        </div>
                                        @error('image')
                                            <p class="mt-1 small text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    {{-- Form ID --}}
                                    <input type="hidden" name="form_id" value="signup-form">
                                    {{-- Login option --}}
                                    <div class="form-group input-field">
                                        Already a member? <button id="already_registered" type="button"
                                            style="cursor: pointer; color: #00274C; text-decoration: underline;">log in</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="margin-top: 10px;">
                                <button type="submit" class="btn btn-primary" name="signup-submit">Sign up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login in Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="login-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signup-modalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Main Body -->
                    <div class="container-fluid signup-container" style="padding-bottom: 0;">
                        {{-- Login Form --}}
                        <form method="POST" action="/users/authenticate" id="login-form">
                            @csrf
                            <div class="form-body">
                                <!-- User info -->
                                <div class="form-group">
                                    <!-- Username -->
                                    <div class="form-group input-field">
                                        <label for="input4">Username:</label>
                                        <input type="text" class="form-control" name="username1" id="input4"
                                            placeholder="" autocomplete="off" value="{{old('username1')}}">
                                        @error('username1')
                                            <p class="mt-1 small text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <!-- Password -->
                                    <div class="form-group input-field">
                                        <label for="inputPassword4">Password:</label>
                                        <input type="password" class="form-control" name="password1" id="inputPassword4"
                                            placeholder="">
                                        @error('password1')
                                            <p class="mt-1 small text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    {{-- Form ID --}}
                                    <input type="hidden" name="form_id" value="login-form">
                                    <!-- Login option -->
                                    <div class="form-group input-field">
                                        New to studySpot? 
                                        <button id="no_account" type="button" style="cursor: pointer; color: #00274C; text-decoration: underline;">Register</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="margin-top: 20px;">
                                <button type="submit" class="btn btn-primary" name="login-submit">Log in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Comment Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog fetch-comments">
        </div>
    </div>

    @if (isset($cmty))
    <!-- Edit Post Modal -->
    <div class="modal fade" id="cmtyEditModal" tabindex="-1" aria-labelledby="cmtyEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cmtyEditModalLabel">Edit Community</h1>
                    <form action="/c/{{ $cmty['community_name'] }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary fa-solid fa-trash bg-danger p-1 text-light"
                            title="delete" onclick="return confirm('Are you sure you want to delete this community and all its posts?')"></button>
                    </form>
                    <button tabindex="-1" type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="POST" action="/c/{{$cmty->community_name}}" id="update-cmty" enctype="multipart/form-data">
                    @csrf                   
                    @method('PUT')

                    <div class="modal-body">
                        {{-- Cmty Name --}}
                        <div class="form-group mb-2">
                            <label for="titleInput">Community Name: </label>
                            <input type="text" class="form-control" id="titleInput" placeholder="My Fun Study Session"
                                name="community_name" autocomplete="off" value="{{ $cmty->community_name }}">
                            @error('title')
                                <p class="mt-1 small text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    
                        {{-- Cmty About --}}
                        <div class="form-group mb-2">
                            <label for="exampleFormControlTextarea1">Description:</label>
                            <textarea class="my_tinymce form-control" rows="3" name="about">{{ $cmty->about }}</textarea>
                            @error('about')
                                <p class="mt-1 small text-danger">{{$message}}</p>
                            @enderror
                        </div>

                        {{-- Add an image --}}
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="image" accept="image/*" value="{{ $cmty->image }}">
                            <label class="custom-file-label" for="customFile">Add an image</label>
                        </div>
                        <img src= {{ $cmty->image ? asset('/storage/' . $cmty->image) : asset('/images/no-image.png') }} class="img-fluid" alt="no img" style="width: 125px; height: 100px;">
                    </div>

                    <div class="modal-footer">
                        <button tabindex="-1" type="submit" name="update-cmty-submit"
                            class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Create Community Modal -->
    <div class="modal fade" id="cmtyModal" tabindex="-1" aria-labelledby="cmtyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cmtyModalLabel">Add a Community</h1>
                    <button tabindex="-1" type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="POST" action="/communities" id="new-cmty" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-body" style="padding: 15px;">
                            <!-- Cmty info -->
                            <div class="form-group">
                                <div class="form-group input-field">
                                    <label for="inputFirstName">Community Name:</label>
                                    <input type="text" class="form-control" id="inputCmtyName" name="community_name"
                                        placeholder="">
                                    @error('community_name')
                                        <p class="mt-1 small text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group input-field">
                                    <label for="inputLastName">About the Community:</label>
                                    <textarea class="form-control" id="inputAbtCmty" name="about"
                                        placeholder=""></textarea>
                                    @error('about')
                                        <p class="mt-1 small text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group input-field">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="image" accept="image/*">
                                        <label class="custom-file-label" for="customFile">Add an image</label>
                                    </div>
                                    @error('image')
                                        <p class="mt-1 small text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                {{-- Owner --}}
                                <input type="hidden" id="user_id" name="user_id" value="{{Auth::id()}}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button tabindex="-1" type="submit" name="create-cmty-submit"
                            class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Advanced Search Modal -->
    <div class="modal fade" id="advancedsearch-modal" tabindex="-1" aria-labelledby="advancedsearchLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="advancedsearch-modalLabel">Advanced Search</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Main Body -->
                    <div class="container-fluid signup-container" style="padding-bottom: 0;">
                        <form method="post" class="login-form"> <!-- action="search.php"-->
                            <div class="form-body">
                                <!-- Query info -->
                                <div class="form-group">

                                    <div class="form-group input-field">
                                        <label for="categoryToLookInto">Community to look in: * </label>
                                        <input type="text" class="form-control" name="categoryToLookInto"
                                            id="categoryToLookInto" placeholder="">
                                    </div>
                                    <div class="form-group input-field">
                                        <label for="inputInclude4">Words to include in the title: </label>
                                        <input type="text" class="form-control" name="wordsToInclude" id="inputInclude4"
                                            placeholder="">
                                    </div>
                                    <div class="form-group input-field">
                                        <label for="inputPassword4">Words to exclude in the title: </label>
                                        <input type="text" class="form-control" name="wordsToExclude" id="inputExclude4"
                                            placeholder="">
                                    </div>
                                    <div class="form-group input-field">
                                        <label for="inputPassword4">Select Posts after: </label>
                                        <input type="date" class="form-control" name="postsAfterDate" id="inputExclude4"
                                            placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="margin-top: 20px;">
                                <button type="submit" class="btn btn-primary" name="advancedsearch-submit">Search
                                    posts</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Modal -->
    <div class="modal fade" id="search-modal" tabindex="-1" aria-labelledby="searchLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchLabel">search studySpot</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Main Body -->
                    <div class="container-fluid signup-container" style="padding-bottom: 0;">
                        @php
                            if (isset($cmty)) {
                                $communityName = $cmty['community_name'];
                            } else {
                                $communityName = '';
                            }
                        @endphp
                        @include('partials._search', ['name' => $communityName])
                    </div>
                </div>
            </div>
        </div>
    </div>
    