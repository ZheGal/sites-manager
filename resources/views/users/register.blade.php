<x-panel-layout>
    <x-slot name="title">
        Зарегистрировать пользователя
    </x-slot>

    <x-slot name="breadcrumbps">
      <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('users.list') }}">Пользователи</a></li>
          <li class="breadcrumb-item active">Зарегистрировать пользователя</li>  
        </ol>
      </div>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Зарегистрировать пользователя</h3>
            </div>
        </div>
    </div>
    <form action="{{ route('users.store') }}" method="post">
        <div class="card-body">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">{{ $error }}</div>
                @endforeach
            @endif
            @csrf
            <div class="form-group row">
              <label for="userLogin" class="col-sm-2 col-form-label">Логин</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userLogin" name="name" required autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label for="userEmail" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userEmail" name="email" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="userPassword" class="col-sm-2 col-form-label">Пароль</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userPassword" name="password" required autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label for="userRole" class="col-sm-2 col-form-label">Права доступа</label>
              <div class="col-sm-10">
                <select class="form-control" id="userRole" name="role">
                    <option value="0">Неактивный</option>
                    <option value="3" selected>Пользователь</option>
                    <option value="2">Модератор</option>
                    <option value="1">Администратор</option>
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="userYandex" class="col-sm-2 col-form-label">Яндекс Логин</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userYandex" name="yandex_login">
              </div>
            </div>
            <div class="form-group row">
              <label for="userTelegram" class="col-sm-2 col-form-label">Телеграм Логин</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userTelegram" name="telegram_login">
              </div>
            </div>
            <div class="form-group row">
              <label for="userPid" class="col-sm-2 col-form-label">PID</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="userPid" name="pid">
              </div>
            </div>
            <div class="form-group row">
              <label for="userAdditional" class="col-sm-12 col-form-label">Дополнительная информация</label>
              <div class="col-sm-12">
                <textarea class="form-control" id="userAdditional" name="additional" rows="5"></textarea>
              </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-success" type="submit">Зарегистрировать</button>
        </div>
    </form>

</x-panel-layout>