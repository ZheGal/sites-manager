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
    <form action="/" method="post">
      <div class="card-body" id="settingsArrayList">
          @csrf
          @method('PATCH')

          @foreach ($settings as $setting => $val)
          <div class="form-group row">
            <div class="col-md-2">
              <input type="text" class="text-right form-control" name="param[]" required value="{{ $setting }}">
            </div>
            <div class="col-sm-8">
              @if(!is_array($val))
                <input type="text" class="form-control" name="value[]" required value="{{ $val }}">
              @else
                @foreach ($val as $val_param => $val_inner)
                  <div>
                    <input type="radio" id="huey" name="{{ $val_param }}" value="{{ $val_param }}"
                           >
                    <label for="huey">{{ $val_param }}</label>
                  </div>
                @endforeach
              @endif
            </div>
            <div class="col-sm-2">
              <a href="#" id="deleteSetting" class="btn btn-primary">Удалить параметр</a>
            </div>
          </div>
          @endforeach
      </div>
      <div class="card-footer">
          <button class="btn btn-primary" type="submit">Обновить</button>
          <a href="#" class="btn btn-danger">Сбросить настройки</a>
          <a href="#" id="addNewParam" class="btn btn-success">Добавить параметр</a>
      </div>
    </form>

    <script>
      $("body").on('click', '#deleteSetting', function(){
        $(this).parent().parent().remove();
        return false;
      });

      $("body").on('click', '#addNewParam', function(){
        return false;
      });
    </script>

</x-panel-layout>