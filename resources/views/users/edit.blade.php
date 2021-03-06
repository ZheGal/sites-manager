<x-panel-layout>
    <x-slot name="title">
        {{ $user->name }} - Редактирование пользователя
    </x-slot>

    <x-slot name="breadcrumbps">
      <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('users.list') }}">Пользователи</a></li>
          <li class="breadcrumb-item active">Редактирование пользователя -&nbsp;<b> {{ $user->name }}</b></li>  
        </ol>
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
                <input type="text" class="form-control" id="userLogin" name="name" required autocomplete="off" value="{{ $user->name }}">
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
            <div class="form-group row">
              <label for="userAdditional" class="col-sm-12 col-form-label">Дополнительная информация</label>
              <div class="col-sm-12">
                <textarea class="form-control" id="userAdditional" name="additional" rows="5">{{ $user->additional }}</textarea>
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