<x-panel-layout>
    <x-slot name="title">
        {{ $user->name }} - Редактирование пользователя
    </x-slot>

    <x-slot name="breadcrumbps">
      <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('users.list') }}">Пользователи</a></li>
          <li class="breadcrumb-item active">Редактирование пользователя - <b>{{ $user->name }}</b></li>  
        </ol>
      </div>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Редактирование пользователя - <b>{{ $user->name }}</b></h3>
            </div>
        </div>
    </div>
    <form action="{{ route('users.update', ['id' => $user->id]) }}" method="post">
        <div class="card-body">
            @csrf
            @method('PATCH')
            <div class="form-group row">
              <label for="userLogin" class="col-sm-2 col-form-label">Логин</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userLogin" name="name" required autocomplete="off" value="{{ $user->name }}">
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
            </div>
            <div class="form-group row">
              <label for="userRole" class="col-sm-2 col-form-label">Права доступа</label>
              <div class="col-sm-10">
                <select class="form-control" id="userRole" name="role">
                    <option value="0" @if ($user->role == 0) selected @endif>Неактивный</option>
                    <option value="3" @if ($user->role == 3) selected @endif>Пользователь</option>
                    <option value="2" @if ($user->role == 2) selected @endif>Модератор</option>
                    <option value="1" @if ($user->role == 1) selected @endif>Администратор</option>
                  </select>
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
        </div>
        <div class="card-footer">
            <button class="btn btn-success" type="submit">Обновить</button>
        </div>
    </form>
    <div class="card-footer">
        <form action="{{ route('users.destroy', ['id' => $user->id]) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Удалить пользователя</button>
        </form>
    </div>

</x-panel-layout>