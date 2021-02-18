<x-panel-layout>
    <x-slot name="title">
        Список сайтов
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active">Сайты</li>  
        </ol>
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

    @if (!empty($filters))
    <div class="card-body">
        Фильтры: 
        @foreach($filters as $filter)
        <a href="{{ remove_query_params([$filter[2]]) }}" type="button" class="btn btn-square btn-light"><b>{{ $filter[0] }}:</b> {{ $filter[1] }}</a>
        @endforeach
    </div>
    @endif

    <div class="card-body">

        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {!! Session::get('message') !!}
            </div>
        @endif
        @if ($sites->isEmpty())
            Список сайтов пустой
        @else
        <table class="table table-responsive-sm table-borderless table-hover table-striped">
            <thead>
                <tr class="table-info ">
                    <th>Домен</th>
                    <th>Кампания</th>
                    @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                    <th class="text-center">Пользователь</th>
                    @endif
                    <th class="text-center">Хостер / домен</th>
                    <th class="text-right"></th>
                    <th class="text-center">Тесты</th>
                    <th class="text-right">Статус</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sites as $site)

                @if ($site->status == 0)
                    <tr class="unactive_site">
                @else
                    <tr>
                @endif

                        <td class="pt-3">
                            <a href="//{{ $site->domain }}" class="font-weight-bold" style="cursor:pointer;cursor:pointer;" target="_blank">
                                {{ $site->domain }}
                            </a>
                        </td>
                        
                        <td class="pt-3">
                            <a href="{{ request()->fullUrlWithQuery(['campaign_id' => $site->campaign_id]) }}">
                                @if (is_null($site->campaign))
                                    <span style="color: darkgrey;font-style: italic;cursor:pointer;">Без кампании</span>
                                @else
                                    @if ($site->campaign->language == '0')
                                    <span style="cursor:pointer;color:#000;">{{ $site->campaign->title }}</span>
                                    @else
                                    <span style="cursor:pointer;color:#000;">{{ $site->campaign->language }} - {{ $site->campaign->title }}</span>
                                    @endif
                                @endif
                            </a>
                        </td>

                        @if (Auth::user()->role == 1 || Auth::user()->role == 2 )
                        <td class="text-center pt-3">
                            <a class="text-center" href="{{ request()->fullUrlWithQuery(['user_id' => $site->user_id]) }}">
                                @if (!is_null($site->user))
                                    <span style="cursor:pointer;color:#000;">{{ $site->user->name }}</span>
                                @else
                                    <span style="color: darkgrey;font-style: italic;cursor:pointer;">Без пользователя</span>
                                @endif
                            </a>
                        </td>
                        @endif

                        <td class="text-center pt-3">
                            <a class="text-center" href="{{ request()->fullUrlWithQuery(['hoster_id' => $site->hoster_id]) }}">
                                @if (!is_null($site->hoster))
                                    <span style="cursor:pointer;color:#000;">{{ $site->hoster->title }}</span>
                                @else
                                    <span style="color: darkgrey;font-style: italic;cursor:pointer;">Не указан</span>
                                @endif
                            </a>
                            /
                            <a class="text-center" href="{{ request()->fullUrlWithQuery(['hoster_id_domain' => $site->hoster_id_domain]) }}">
                                @if (!is_null($site->hoster_domain))
                                    <span style="cursor:pointer;color:#000;">{{ $site->hoster_domain->title }}</span>
                                @else
                                    <span style="color: darkgrey;font-style: italic;cursor:pointer;">Не указан</span>
                                @endif
                            </a>
                        </td>
                        
                        <td class="text-center">
                            <div class="d-flex justify-content-between flex-wrap">
                                    <button type="button" id="openModalFtp" class="btn btn-pill btn-info btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#ftpAccessModal"
                                        data-ftp-name="{{ $site->domain }}"
                                        data-ftp-host="{{ $site->ftp_host }}"
                                        data-ftp-user="{{ $site->ftp_user }}"
                                        data-ftp-pass="{{ $site->ftp_pass }}"
                                        data-yandex="{{ $site->yandex }}"
                                        data-facebook="{{ $site->facebook }}"
                                        @if ($site->creator_id != 0)
                                        data-creator="{{ $site->creator->name }}"
                                    @endif 
                                        @if ($site->updator_id != 0)
                                        data-updator="{{ $site->updator->name }}"
                                    @endif data-createdat="{{ $site->created_at }}"
                                        data-updatedat="{{ $site->updated_at }}"
                                    >
                                        Информация
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
                            </div>
                        </td>
                        <td class="text-center pt-3">
                            <button type="button" id="siteStatusButton" class="btn btn-pill btn-danger btn-sm">
                                Недоступно
                            </button>
                        </td>
                        <td class="text-right pt-3">
                            @if ($site->status == 1)
                                <a href="{{ request()->fullUrlWithQuery(['status' => $site->status]) }}" style="color:green;">Активен</a>
                            @else
                                <a href="{{ request()->fullUrlWithQuery(['status' => $site->status]) }}" style="color:red;">Не активен</a>
                            @endif    
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        {{ $sites->links() }}
    </div>

    {{-- Вывод модалки с доступами сайта --}}
    <x-ftp-access-modal />

    {{-- Вывод модалки для передачи сайта --}}
    <x-transfer-modal />
    
</x-panel-layout>