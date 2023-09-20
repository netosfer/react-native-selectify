<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link square-link" data-widget="pushmenu" href="#" role="button"><i data-feather="menu"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li><a href="{{ url('/') }}" target="_blank" class="btn btn-primary float-left mr-3">Siteyi Görüntüle</a></li>
        <li class="nav-item dropdown">
            <div class="pr-50" data-toggle="dropdown" href="#">
                <div class="user-infos text-right">
                    <img src="{{ (new MainHelper())->image_url(Auth::user()->profile_photo_path, 40, 40) }}"
                         class="img-circle border-1" alt="User Image" class="ms-2 me-auto">
                </div>
            </div>
            <div class="dropdown-menu dropdown-menu-lg user-settings dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <p class="float-left p-3 w-100" style="border-bottom: 1px solid #dedede">
                    <b>{{ Auth::user()->name }}</b><br/>
                    <span>IP Adresiniz : {{ \Request::getClientIp(true) }}</span>
                </p>
                <div class="dropdown-divider"></div>
                <a href="/user/profile" class="dropdown-item">
                    <i data-feather="user" class="mr-2"></i> Profil Bilgileri
                </a>
                <div class="dropdown-divider"></div>
            </div>
        </li>
    </ul>
</nav>
