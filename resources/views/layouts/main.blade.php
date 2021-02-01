<!doctype html>
<html lang="ru">
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- CoreUI CSS -->
    <link rel="stylesheet" href="{{ asset('assets/coreui/css/coreui.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
    
    <title>{{ $title }}</title>
 </head>
 <body class="c-app">

    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-lg-down-none">
            <!--  -->
        </div>
        <ul class="c-sidebar-nav ps ps--active-y">
            @if ( Auth::user()->role != 3)
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('sites.list') }}">
                    <span class="c-sidebar-nav-icon"><i class="cil-globe-alt"></i></span>
                    <span>Сайты</span>
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('hosters.list') }}">
                    <span class="c-sidebar-nav-icon"><i class="cil-flag-alt"></i></span>
                    <span>Хостеры</span>
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('campaigns.list') }}">
                    <span class="c-sidebar-nav-icon"><i class="cil-bank"></i></span>
                    <span>Кампании</span>
                </a>
            </li>
            @if ( Auth::user()->role == 1)
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('users.list') }}">
                    <span class="c-sidebar-nav-icon"><i class="cil-user"></i></span>
                    <span>Пользователи</span>
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('metrika.index') }}">
                    <span class="c-sidebar-nav-icon"><i class="cib-yandex"></i></span>
                    <span>Метрика</span>
                </a>
            </li>
            @endif
            @endif
            <li class="c-sidebar-nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="c-sidebar-nav-link" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        <span class="c-sidebar-nav-icon"><i class="cil-walk"></i></span>
                        <span>Выйти</span>
                    </a>
                </form>
            </li>
        </ul>
        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
    </div>
    <div class="c-wrapper c-fixed-components">
        <div class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
            <span class="c-icon c-icon-lg">
                <i class="cil-menu"></i>
            </span>
        </button>
        </div>
        
        @if (isset($breadcrumbps))
            {{ $breadcrumbps }}
        @endif 

        <div class="c-body">
        <main class="c-main">
        <div class="container-fluid">
        <div class="fade-in">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    {{ $slot }}
                </div>
            </div>
        </div>
        </div>
        </div>
        </main>
            <footer class="c-footer">
                <div>Текст для футера (c) {{ date("Y") }}</div>
            </footer>
        </div>
        </div>
    </div>

     
 <!-- Optional JavaScript -->
 <!-- Popper.js first, then CoreUI JS -->
 <script src="https://unpkg.com/@popperjs/core@2"></script>
 <script src="{{ asset('assets/coreui/js/coreui.min.js') }}"></script>
 </body>
</html>