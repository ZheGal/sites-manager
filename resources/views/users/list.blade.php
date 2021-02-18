<x-panel-layout>
    <x-slot name="title">
        Список пользователей
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active">Пользователи</li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Список пользователей</h3>
            </div>
            <div class="col align-self text-center">
            </div>
            <div class="col align-self-end text-right">
                @if (Auth::user()->role == 1)
                <a href="{{ route('users.create') }}" class="btn btn-pill btn-success btn-sm">
                    <i class="cil-plus"></i> Зарегистрировать
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {!! Session::get('message') !!}
            </div>
        @endif
        @if ($users->isEmpty())
            Пользователи не найдены (лол это как вообще?)
        @else
        <table class="table table-responsive-sm table-borderless table-hover table-striped">
            <thead>
                <tr class="table-info ">
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Почта</th>
                    <th>Статус</th>
                    <th>Логин Яндекс</th>
                    <th>Логин Telegram</th>
                    <th>PID</th>
                    
                    <th class="text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="pt-3">{{ $user->id }}</td>
                    <td class="pt-3">{{ $user->name }}</td>
                    <td class="pt-3">{{ $user->email }}</td>
                    <td class="pt-3">
                        @if ($user->role == 1) Администратор 
                        @elseif ($user->role == 2) Модератор
                        @elseif ($user->role == 3) Пользователь
                        @else Неактивный @endif
                    </td>
                    <td class="pt-3">{{ $user->yandex_login }}</td>
                    <td class="pt-3">{{ $user->telegram_login }}</td>
                    <td class="pt-3">{{ $user->pid }}</td>

                    <td class="text-right">
                        @if (Auth::user()->role == 1)
                        <a href="{{ route('users.edit', ['id' => $user->id ]) }}" class="btn btn-pill btn-dark btn-sm">Редактировать</a>
                        @endif
                        <a href="{{ route('sites.list', ['user_id' => $user->id ]) }}" class="btn btn-pill btn-info btn-sm">Список сайтов</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @endif
    </div>

</x-panel-layout>