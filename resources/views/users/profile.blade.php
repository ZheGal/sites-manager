<x-panel-layout>
    <x-slot name="title">
        {{ $user->name }} - Редактирование профиля
    </x-slot>

    <x-slot name="breadcrumbps">
      <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active">Редактирование профиля -&nbsp;<b> {{ $user->name }}</b></li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Редактирование профиля - <b>{{ $user->name }}</b></h3>
            </div>
        </div>
    </div>
    <form action="{{ route('profile.update', ['id' => $user->id]) }}" method="post">
        <div class="card-body">
            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {!! Session::get('message') !!}
                </div>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">{{ $error }}</div>
                @endforeach
            @endif
            @csrf
            @method('PATCH')
            <div class="form-group row">
              <label for="userLogin" class="col-sm-2 col-form-label">Логин</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userLogin" readonly="true" value="{{ $user->name }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="userName" class="col-sm-2 col-form-label">Имя</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userName" name="realname" required autocomplete="off" value="{{ $user->realname }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="userEmail" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userEmail" name="email" required value="{{ $user->email }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="userPassword" class="col-sm-2 col-form-label">Пароль</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userPassword" name="password" autocomplete="off">
              </div>
                <div class="col-md-12" style="font-size:11px;">При изменении пароля необходимо будет произвести повторную авторизацию!</div>
            </div>
            <div class="form-group row">
              <label for="userRole" class="col-sm-2 col-form-label">Права доступа</label>
              <div class="col-sm-10">
				@if ($user->role == 0)	
                <input type="text" class="form-control" id="userRole" readonly="true" value="Неактивный">
				@elseif ($user->role == 3)
                <input type="text" class="form-control" id="userRole" readonly="true" value="Пользователь">
				@elseif ($user->role == 2)
                <input type="text" class="form-control" id="userRole" readonly="true" value="Модератор">
				@elseif ($user->role == 1)
                <input type="text" class="form-control" id="userRole" readonly="true" value="Администратор">
				@endif
              </div>
            </div>
            <div class="form-group row">
              <label for="userYandex" class="col-sm-2 col-form-label">Яндекс Логин</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userYandex" name="yandex_login" value="{{ $user->yandex_login }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="userTelegram" class="col-sm-2 col-form-label">Телеграм Логин</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userTelegram" name="telegram_login" value="{{ $user->telegram_login }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="userPid" class="col-sm-2 col-form-label">PID</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userPid" name="pid" value="{{ $user->pid }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="userAdditional" class="col-sm-12 col-form-label">Дополнительная информация (гугл таблицы и прочие полезные данные)</label>
              <div class="col-sm-12">
                <textarea class="form-control" id="userAdditional" name="additional" rows="5">{{ $user->additional }}</textarea>
              </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-success" type="submit">Сохранить настройки</button>
        </div>
    </form>

</x-panel-layout>