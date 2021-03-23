<x-panel-layout>
    <x-slot name="title">
        Список хостеров
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active">Хостеры</li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Список хостеров</h3>
            </div>
            @if ( Auth::user()->role == 1)
            <div class="col align-self-end text-right">
                <x-small-button-link class="success" route="hosters.create" icon="cil-plus" value="Добавить" />
            </div>
            @endif
        </div>
    </div>
    <div class="card-body">
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {!! Session::get('message') !!}
            </div>
        @endif
        @if ($hosters->isEmpty())
            Список хостов пустой
        @else
        <table class="table table-responsive-sm table-borderless table-hover table-striped">
            <thead>
                <tr class="table-info ">
                    <th></th>
                    <th>Название</th>
                    <th class="text-center">Количество сайтов</th>
                    @if ( Auth::user()->role == 1)
                    <th class="text-center">Логин</th>
                    <th class="text-center">Пароль</th>
                    @endif
                    <th class="text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hosters as $hoster)
                    <tr>
                        <td class="pt-3">{{ $loop->iteration }}</td>
                        <td class="pt-3"><a href="//{{ $hoster->url }}" target="_blank" style="cursor:pointer;"><input class="font-weight-bold" type="text" readonly value="{{ $hoster->title }}" style="cursor:pointer;"></a></td>
                        <td class="pt-3"><input type="text" readonly value="{{ $hoster->sites->count() }}" class="text-center"></td>
                        @if ( Auth::user()->role == 1)
                        <td class="text-center"><input type="text" class="text-center" readonly value="{{ $hoster->username }}"></td>
                        <td class="text-center"><input type="text" class="text-center" readonly value="{{ $hoster->password }}"></td>
                        @endif
                        <td class="text-right">
                            @if ( Auth::user()->role == 1)
                                <button type="button" id="openAdditionalModal" class="btn btn-pill btn-info btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#additionalModal"
                                        data-additional="{{ $hoster->additional }}">
                                        Информация
                                    </button>
                            <a href="{{ route('hosters.edit', ['id' => $hoster->id]) }}" type="button" class="btn btn-pill btn-dark btn-sm">Редактировать</a>
                            @endif
                            <a href="{{ route('sites.list', ['hoster_id' => $hoster->id]) }}" type="button" class="btn btn-pill btn-primary btn-sm">Список сайтов</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Вывод модалки с доп инфой --}}
    <x-additional-hoster-modal />

</x-panel-layout>