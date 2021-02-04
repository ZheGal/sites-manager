<x-panel-layout>
    <x-slot name="title">
        Добавить хост
    </x-slot>

    <x-slot name="breadcrumbps">
      <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('hosters.list') }}">Хостеры</a></li>
          <li class="breadcrumb-item active">Добавить хост</li>  
        </ol>
      </div>
    </x-slot>

    

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Добавить хост</h3>
            </div>
            <div class="col align-self-end text-right">
            </div>
        </div>
    </div>
    <form action="{{ route('hosters.store') }}" method="post">
        <div class="card-body">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">{{ $error }}</div>
                @endforeach
            @endif
            @csrf
            <div class="form-group row">
              <label for="hosterTitle" class="col-sm-2 col-form-label">Название хостера</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="hosterTitle" name="title" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="hosterUrl" class="col-sm-2 col-form-label">Адрес хостера</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="hosterUrl" name="url" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="hosterLogin" class="col-sm-2 col-form-label">Логин</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="hosterLogin" name="username">
              </div>
            </div>
            <div class="form-group row">
              <label for="hosterPassword" class="col-sm-2 col-form-label">Пароль</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="hosterPassword" name="password">
              </div>
            </div>
            <div class="form-group row">
              <label for="multiHoster" class="col-sm-2 col-form-label">Мультихост:</label>
              <div class="col-sm-10">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="multihost" id="multiHoster">
                </div>
              </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Добавить</button>
        </div>
    </form>

</x-panel-layout>