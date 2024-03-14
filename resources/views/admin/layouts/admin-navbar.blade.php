@php
    // UserDetails
    if(auth()->user())
    {
        $userID = encrypt(auth()->user()->id);
        $userName = auth()->user()->name;
        $userImage = auth()->user()->image;
    }
    else
    {
        $userID = '';
        $userName = '';
        $userImage = '';
    }
    $default_image = asset("public/admin_images/demo_images/profiles/profile3.png");
    $image = (Auth::user()->image) ? asset('public/images/uploads/user_images/'.Auth::user()->image) : $default_image;
    $roles = Spatie\Permission\Models\Role::where('id',Auth::user()->role_id)->first();

@endphp

<!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
        <!-- <span class="d-none d-lg-block">{{trans('label.Administrator')}}</span> -->
        <img  src="{{ asset('/public/assets/frontend/logo_image/Background - 2024-02-26T151826.204.png') }}"  alt="Logo" >
        <span>New Naveli</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ $image }}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ $userName }}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ $userName }}</h6>
              <span>{{ isset($roles->name) ? $roles->name : '' }}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>


            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit',encrypt(Auth::user()->id)) }}">
                <i class="bi bi-person"></i>
                <span>{{trans('label.My_Profile')}}</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>{{trans('label.Sign_Out')}}</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
