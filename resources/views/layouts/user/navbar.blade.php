<div class="hor-header header">
    <div class="container">
        <div class="d-flex">
            <a class="animated-arrow hor-toggle horizontal-navtoggle"><span></span></a>
           
            <div class="d-flex order-lg-2 my-auto mr-auto">
                <div class="dropdown header-fullscreen">
                    <a class="nav-link icon full-screen-link">
                        <i class="feather feather-maximize fullscreen-button fullscreen header-icons"></i>
                        <i class="feather feather-minimize fullscreen-button exit-fullscreen header-icons"></i>
                    </a>
                </div>
                <div class="dropdown header-fullscreen">
                    <form method="POST" action="{{ route('user.logout') }}">
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