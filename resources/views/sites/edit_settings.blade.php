<x-panel-layout>
    <x-slot name="title">
        Редактирование настроек сайта
    </x-slot>

    <x-slot name="breadcrumbps">
      <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sites.list') }}">Сайты</a></li>
          <li class="breadcrumb-item active">Редактирование настроек сайта</li>  
        </ol>
      </div>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Редактирование настроек сайта</h3>
            </div>
        </div>
    </div>
    <form action="{{ route('sites.update.settings', ['id' => $site->id]) }}" method="post">
      <div class="card-body" id="settingsArrayList">
          @csrf
          @method('PATCH')
          @foreach ($settings as $param => $val)
            @if (!is_array($val))
            <div class="form-group row">
              <label for="{{ $param }}Input" class="col-sm-2 col-form-label text-right">{{ $param }}</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="{{ $param }}Input" name="{{ $param }}" value="{{ $val }}">
              </div>
            </div>
            @endif
          @endforeach
      </div>
      <div class="card-footer">
          <button class="btn btn-primary" type="submit">Обновить</button>
          <a href="#" class="btn btn-danger">Сбросить настройки</a>
      </div>
    </form>

    <script>
      $("body").on('click', '#deleteSetting', function(){
        $(this).parent().parent().remove();
        return false;
      });
    </script>

</x-panel-layout>