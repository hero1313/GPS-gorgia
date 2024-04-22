<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="mx-3 sidebar-brand-text">GPS GORGIA</div>
    </a>

    <!-- Divider -->
    <hr class="my-0 sidebar-divider">

    <!-- Nav Item - Dashboard -->
    @if(Auth::user()->role == 2)
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>დეშბორდი</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('locations.index') }}" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <span>ლოკაციები</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
            </svg>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('users.index') }}" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <span>იუზერები</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
            </svg>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('tasks.index') }}" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <span>დავალებები</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
            </svg>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('records.index') }}"  data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <span>ჩექინები</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
            </svg>
        </a>
    </li>
    @else
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('my.records.index') }}" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <span>ჩემი ჩექინები</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"/>
            </svg>
        </a>
    </li>
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="border-0 rounded-circle" id="sidebarToggle"></button>
    </div>
</ul>