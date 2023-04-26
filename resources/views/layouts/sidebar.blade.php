<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="">
                {{-- <img src="{{ asset('assets/images/logo-perkim.png') }}" alt="" class="avatar-md"> --}}
            </div>
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">{{ Auth::guard($guard)->user()->name }}</h4>
                <span class="text-muted"><i class="ri-record-circle-line align-middle font-size-14 text-success"></i>
                    Online</span>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route($guard.'.dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                @if ($guard == 'admin')
                <li>
                    <a href="{{ route('admin.customer.index') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Customer</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.merchant.index') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Merchant</span>
                    </a>
                </li>
                @endif



                @if ($guard == 'customer')
                <li>
                    <a href="{{ route('qrcode', Auth::guard($guard)->user()->id) }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>QrCode</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('customer.coupons') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Tukar Poin</span>
                    </a>
                </li>
                @endif

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-share-line"></i>
                        <span>Administrator</span>
                    </a>
                </li>


                <li>
                    <a href="{{ route($guard.'.logout') }}" class="waves-effect" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ri-dashboard-line"></i>
                        <span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route($guard.'.logout') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
