<div class="hor-header header">
    <div class="container">
        <div class="d-flex">
            <a class="animated-arrow hor-toggle horizontal-navtoggle"><span></span></a>
            <a class="header-brand" href="index.html">
                <img src="{{asset('assets/images/brand/favicon.png')}}" height="45px"
                        class="header-brand-img desktop-lgo" alt="Dayonelogo">
                <img src="{{asset('assets/images/brand/favicon.png')}}"
                        class="header-brand-img dark-logo" alt="Dayonelogo">
                <img src="{{asset('assets/images/brand/favicon.png')}}"
                        class="header-brand-img mobile-logo" alt="Dayonelogo" style="height: 45px">
                <img src="{{asset('assets/images/brand/favicon.png')}}"
                        class="header-brand-img darkmobile-logo" alt="Dayonelogo">
            </a>
            <div class="d-flex order-lg-2 my-auto mr-auto">
                <div class="dropdown header-fullscreen">
                    <a class="nav-link icon full-screen-link">
                        <i class="feather feather-maximize fullscreen-button fullscreen header-icons"></i>
                        <i class="feather feather-minimize fullscreen-button exit-fullscreen header-icons"></i>
                    </a>
                </div>
                <div class="dropdown header-fullscreen">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button style="border: none; display: flex; justify-content: center; align-items: center;"
                            title="خروج" class="nav-link icon full-screen-link">
                            <i class="feather feather-power fs-16"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>