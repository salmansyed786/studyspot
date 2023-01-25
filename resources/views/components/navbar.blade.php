<nav class="d-flex flex-column flex-shrink-0 bg-light my-navbar" style="width: 4.5rem;">
    <!-- studySpot Brand and Icon -->
    <a class="navbar-brand border-bottom" href="/">
        <div class="brand-wrapper">
            <img src="{{ asset('images/study.png') }}" alt="studySpot Logo" width="35" title="studySpot">
        </div>
    </a>
    <!-- Options -->
    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
        @auth
        {{-- Create Post --}}
        <li class="nav-item">
            <button tabindex="-1" onclick="location.href='/create/post'" type="button"
                class="btn material-symbols-outlined create-btn" data-toggle="tooltip" data-placement="right"
                title="Create Post" id="createPostBtn">
                library_add
            </button>
        </li>
        {{-- Create Community --}}
        <li class="nav-item">
            <button tabindex="-1" data-bs-toggle="modal" data-bs-target="#cmtyModal" type="button"
                class="btn material-symbols-outlined create-btn" data-toggle="tooltip" data-placement="right"
                title="Create Community" id="createCmtyBtn">
                group_add
            </button>
        </li>
        {{-- Your Posts --}}
        <li class="nav-item">
            <button tabindex="-1" type="button" onclick="location.href='/manage/posts'" class="btn material-symbols-outlined create-btn"
                data-toggle="tooltip" data-placement="right" title="Manage Posts">
                settings
            </button>
        </li>
        @else
        {{-- Log in --}}
        <li class="nav-item">
            <!-- Log in btn trigger modal -->
            <button type="button" class="btn navbar-btn create-btn material-symbols-outlined"
                data-bs-toggle="modal" data-bs-target="#login-modal" data-toggle="tooltip"
                data-placement="right" title="Login">
                Login
            </button>
        </li>
        {{-- Sign up --}}
        <li class="nav-item">
            <!-- Sign up btn trigger modal -->
            <button type="button" class="btn navbar-btn create-btn material-symbols-outlined"
                data-bs-toggle="modal" data-bs-target="#signup-modal" data-toggle="tooltip"
                data-placement="right" title="Sign Up">
                person_add
            </button>
        </li>
        @endauth
        {{-- Search --}}
        <li class="nav-item">
            <!-- Search btn trigger modal data-bs-target="#advancedsearch-modal"-->
            <button type="button" class="btn navbar-btn create-btn material-symbols-outlined"
                data-bs-toggle="modal" data-toggle="tooltip"
                data-placement="right" title="Search studySpot">
                search
            </button>
        </li>
    </ul>
    <!-- User settings, logout -->
    @auth
    <div class="dropdown border-top user-settings">
        <a href="#" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none dropdown-toggle"
            id="dropdownUser3" data-bs-toggle="dropdown">
            <img src={{ auth()->user()->image ? asset('/storage/' . auth()->user()->image) : asset('../../public/images/no-image.png') }} alt="mdo" width="24" height="24" class="rounded-circle">
        </a>
        <ul class="dropdown-menu text-small shadow settings-dropdown" style="z-index: 5;" aria-labelledby="dropdownUser3">
            <b style="margin-left: 15px;">Welcome {{auth()->user()->username}}!</b>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Help</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <form action="/logout" class="logout-form" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item logout-submit">
                        <span class="material-symbols-outlined">logout</span>Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
    @endauth
</nav>