<nav class="mb-4 bg-white shadow navbar navbar-expand navbar-light topbar static-top">
   <h4>

        @if (Auth::user()->department_index == 1)
            დისტრიბუციის
        @else
            კორპორატიული გაყიდვების
        @endif
        @if (Auth::user()->role == 1)
            პრისელერი
        @else
            ადმინისტრატორი
        @endif
    
    </h4>
   <ul class="nav-ul">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle"
                    src="https://cdn-icons-png.freepik.com/512/8188/8188362.png">
                <span class="mr-2 text-gray-600 d-none d-lg-inline medium">{{ Auth::user()->NAME }}</span>
            </a>
            <!-- Dropdown - User Information -->
            {{-- <div class="shadow dropdown-menu dropdown-menu-right animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="mr-2 text-gray-400 fas fa-user fa-sm fa-fw"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="mr-2 text-gray-400 fas fa-cogs fa-sm fa-fw"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="mr-2 text-gray-400 fas fa-list fa-sm fa-fw"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="mr-2 text-gray-400 fas fa-sign-out-alt fa-sm fa-fw"></i>
                    Logout
                </a>
            </div> --}}
        </li>

    </ul>

</nav>