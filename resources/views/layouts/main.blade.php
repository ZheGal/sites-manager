<!doctype html>
<html lang="ru">
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- CoreUI CSS -->
    <link rel="stylesheet" href="{{ asset('assets/coreui/css/coreui.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@2.0.0-beta.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
    
    <title>{{ $title }}</title>
 </head>
 <body class="c-app">

    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-lg-down-none">
            <div class="top_logo">NEO SITES PANEL</div>
            <div class="top_logo_mini">NSP</div>
        </div>
        <ul class="c-sidebar-nav ps ps--active-y">
            @if ( Auth::user()->role != 0)
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link 
                    @if (\Request::route()->getName() == 'sites.list')
                        c-active
                    @endif" href="{{ route('sites.list') }}">
                        <span class="c-sidebar-nav-icon"><i class="cil-globe-alt"></i></span>
                        <span>Сайты</span>
                </a>
            </li>
            {{-- <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link 
                    @if (\Request::route()->getName() == 'sites.list')
                        c-active
                    @endif" href="{{ route('sites.list') }}">
                        <span class="c-sidebar-nav-icon"><i class="cil-globe-alt"></i></span>
                        <span>Прелэнды</span>
                </a>
            </li> --}}
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link 
                @if (\Request::route()->getName() == 'hosters.list')
                    c-active
                @endif" href="{{ route('hosters.list') }}">
                    <span class="c-sidebar-nav-icon"><i class="cil-flag-alt"></i></span>
                    <span>Хостеры</span>
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link 
                @if (\Request::route()->getName() == 'offers.list')
                    c-active
                @endif" href="{{ route('offers.list') }}">
                    <span class="c-sidebar-nav-icon"><i class="cil-bank"></i></span>
                    <span>Офферы</span>
                </a>
            </li>
            @if ( Auth::user()->role == 1 || Auth::user()->role == 2 )
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link 
                @if (\Request::route()->getName() == 'users.list')
                    c-active
                @endif" href="{{ route('users.list') }}">
                    <span class="c-sidebar-nav-icon"><i class="cil-user"></i></span>
                    <span>Пользователи</span>
                </a>
            </li>
            @endif
            @if ( Auth::user()->role == 1)
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link 
                @if (\Request::route()->getName() == 'metrika.index')
                    c-active
                @endif" href="{{ route('metrika.index') }}">
                    <span class="c-sidebar-nav-icon"><i class="cib-yandex"></i></span>
                    <span>Метрика</span>
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link 
                @if (\Request::route()->getName() == 'hostiq.index')
                    c-active
                @endif" href="{{ route('hostiq.index') }}">
                    <span class="c-sidebar-nav-icon"><i class="cil-link"></i></span>
                    <span>HOSTiQ</span>
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link 
                @if (\Request::route()->getName() == 'settings.index')
                    c-active
                @endif" href="{{ route('settings.index') }}">
                    <span class="c-sidebar-nav-icon"><i class="cil-settings"></i></span>
                    <span>Настройки</span>
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
            @if (isset($breadcrumbps))
                {{ $breadcrumbps }}
            @endif 
            <ul class="c-header-nav ml-auto mr-4">
                <li style="margin-right:6px;">
                    @if (Auth::user()->role == 1)
                    Администратор
                    @elseif (Auth::user()->role == 2)
                    Модератор
                    @elseif (Auth::user()->role == 3)
                    Пользователь
                    @endif
                </li>
                <li style="font-weight:bold;">{{ Auth::user()->name }}</li>
            </ul>
        </div>
        

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
                {{-- <div>Текст для футера (c) {{ date("Y") }}</div> --}}
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