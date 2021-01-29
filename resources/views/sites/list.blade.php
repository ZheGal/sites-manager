<x-panel-layout>
    <x-slot name="title">
        Список сайтов
    </x-slot>

    <x-slot name="breadcrumbps">
      <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active">Сайты</li>  
        </ol>
      </div>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Список сайтов</h3>
            </div>
            <div class="col align-self text-center">
                <form action="{{ route('sites.list') }}">
                    <div class="input-group">
                        <input class="form-control" id="input1-group2" type="text" 
                        @if (!empty($search_domain))
                        value="{{ $search_domain }}"
                        @endif name="search_domain" placeholder="Домен сайта" autocomplete="username">
                        <span class="input-group-append">
                            <button class="btn btn-primary" type="submit">Поиск</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col align-self-end text-right">
                @if (Auth::user()->role == 1)
                <a href="{{ route('sites.create') }}" class="btn btn-pill btn-success btn-sm">
                    <i class="cil-plus"></i> Добавить
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        @if ($sites->isEmpty())
            Список сайтов пустой
        @else
        <table class="table table-responsive-sm table-borderless table-hover table-striped">
            <thead>
                <tr class="table-info ">
                    <th>ID</th>
                    <th>Домен</th>
                    <th>Кампания</th>
                    @if (Auth::user()->role == 1)
                    <th class="text-center">Пользователь</th>
                    @endif
                    <th class="text-center">Хостер</th>
                    <th class="text-center">Регистратор домена</th>
                    <th class="text-center">Метрика</th>
                    <th class="text-center">Пиксель</th>
                    <th class="text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sites as $site)
                    <tr>
                        <td class="pt-3">{{ $site->id }}</td>

                        <td class="pt-3">
                            <a href="//{{ $site->domain }}" style="cursor:pointer;" target="_blank">
                                <input class="font-weight-bold" type="text" style="cursor:pointer;" readonly value="{{ $site->domain }}">
                            </a>
                        </td>
                        
                        <td class="pt-3">
                            <a href="{{ request()->fullUrlWithQuery(['campaign_id' => $site->campaign_id]) }}">
                                @if (is_null($site->campaign))
                                    <input type="text" readonly value="Без кампании"
                                        style="color: darkgrey;font-style: italic;cursor:pointer;">
                                @else
                                    <input type="text" readonly value="{{ $site->campaign->language }} - {{ $site->campaign->title }}"
                                        style="cursor:pointer;color:#000;">
                                @endif
                            </a>
                        </td>

                        @if (Auth::user()->role == 1)
                        <td class="text-center">
                            <a class="text-center" href="{{ request()->fullUrlWithQuery(['user_id' => $site->user_id]) }}">
                                @if (!is_null($site->user))
                                    <span style="cursor:pointer;color:#000;">{{ $site->user->name }}</span>
                                @else
                                    <span style="color: darkgrey;font-style: italic;cursor:pointer;">Без пользователя</span>
                                @endif
                            </a>
                        </td>
                        @endif

                        <td class="text-center">
                            <a class="text-center" href="{{ request()->fullUrlWithQuery(['hoster_id' => $site->hoster_id]) }}">
                                @if (!is_null($site->hoster))
                                    <span style="cursor:pointer;color:#000;">{{ $site->hoster->title }}</span>
                                @else
                                    <span style="color: darkgrey;font-style: italic;cursor:pointer;">Не указан</span>
                                @endif
                            </a>
                        </td>

                        <td class="text-center">
                            <a class="text-center" href="{{ request()->fullUrlWithQuery(['hoster_id_domain' => $site->hoster_id_domain]) }}">
                                @if (!is_null($site->hoster_domain))
                                    <span style="cursor:pointer;color:#000;">{{ $site->hoster_domain->title }}</span>
                                @else
                                    <span style="color: darkgrey;font-style: italic;cursor:pointer;">Не указан</span>
                                @endif
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="https://metrika.yandex.ru/dashboard?id={{ $site->yandex }}" target="_blank">
                                {{ $site->yandex }}
                            </a>
                        </td>
                        <td class="text-center">{{ $site->facebook }}</td>
                        <td class="text-right">
                            <button type="button" id="openModalFtp" class="btn btn-pill btn-info btn-sm" 
                                data-toggle="modal" 
                                data-target="#ftpAccessModal"
                                data-ftp-name="{{ $site->domain }}"
                                data-ftp-host="{{ $site->ftp_host }}"
                                data-ftp-user="{{ $site->ftp_user }}"
                                data-ftp-pass="{{ $site->ftp_pass }}">
                                    FTP Доступы
                            </button>
                            <button type="button" id="transferSite" class="btn btn-pill btn-danger btn-sm"
                                data-toggle="modal" 
                                data-target="#transferSiteUserModal"
                                data-domain="{{ $site->domain }}"
                                data-siteid="{{ $site->id }}"
                                data-userid="{{ $site->user_id }}">
                                    Передать сайт
                            </button>
                            @if (Auth::user()->role == 1)
                            <a href="{{ route('sites.edit', ['id' => $site->id ]) }}" class="btn btn-pill btn-dark btn-sm">Редактировать</a>
                            @endif
                            <a href="{{ route('sites.edit.settings', ['id' => $site->id ]) }}" class="btn btn-pill btn-primary btn-sm">Настройки сайта</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Вывод модалки с доступами сайта --}}
    <x-ftp-access-modal />

    {{-- Вывод модалки для передачи сайта --}}
    <x-transfer-modal />
    
</x-panel-layout>