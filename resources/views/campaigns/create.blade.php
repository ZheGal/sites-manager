<x-panel-layout>
    <x-slot name="title">
        Добавить кампанию
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('campaigns.list') }}">Кампании</a></li>
          <li class="breadcrumb-item active">Добавить кампанию</li>  
        </ol>
    </x-slot>

    

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Добавить кампанию</h3>
            </div>
            <div class="col align-self-end text-right">
            </div>
        </div>
    </div>
    <form action="{{ route('campaigns.store') }}" method="post">
        <div class="card-body">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">{{ $error }}</div>
                @endforeach
            @endif
            @csrf
            <div class="form-group row">
              <label for="campaignTitle" class="col-sm-2 col-form-label">Имя кампании</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="campaignTitle" name="title" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="campaignLang" class="col-sm-2 col-form-label">Язык кампании</label>
              <div class="col-sm-10">
                <select class="form-control" id="campaignLang" name="language">
                    <option value="EN">EN - Английский</option>
                    <option value="PL">PL - Польский</option>
                    <option value="RU">RU - Русский</option>
                    <option value="IT">IT - Итальянский</option>
                    <option value="PT">PT - Португальский</option>
                    <option value="ES">ES - Испанский</option>
                    <option value="DE">DE - Немецкий</option>
                    <option value="0">Другой / не указывать</option>
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="campaignGroup" class="col-sm-2 col-form-label">Группа (если требуется)</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="campaignGroup" name="group">
              </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Добавить</button>
        </div>
    </form>

</x-panel-layout>