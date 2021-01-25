<x-panel-layout>
    <x-slot name="title">
        Редактирование кампании
    </x-slot>

    <x-slot name="breadcrumbps">
      <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('campaigns.list') }}">Кампании</a></li>
          <li class="breadcrumb-item active">Редактирование кампании</li>  
        </ol>
      </div>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Редактирование кампании</h3>
            </div>
            <div class="col align-self-end text-right">
            </div>
        </div>
    </div>
    <form action="{{ route('campaigns.update', ['id' => $campaign->id]) }}" method="post">
        <div class="card-body">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">{{ $error }}</div>
                @endforeach
            @endif
            @csrf
            @method('PATCH')
            <div class="form-group row">
              <label for="campaignTitle" class="col-sm-2 col-form-label">Название кампании</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="campaignTitle" name="title" required value="{{ $campaign->title }}" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label for="campaignLang" class="col-sm-2 col-form-label">Язык кампании</label>
              <div class="col-sm-10">
                <select class="form-control" id="campaignLang" name="language">

                    {{ $campaign->language }}
                    <option value="EN"@if ($campaign->language == 'EN') selected @endif>EN - Английский</option>
                    <option value="PL"@if ($campaign->language == 'PL') selected @endif>PL - Польский</option>
                    <option value="RU"@if ($campaign->language == 'RU') selected @endif>RU - Русский</option>
                    <option value="IT"@if ($campaign->language == 'IT') selected @endif>IT - Итальянский</option>
                    <option value="PT"@if ($campaign->language == 'PT') selected @endif>PT - Португальский</option>
                    <option value="ES"@if ($campaign->language == 'ES') selected @endif>ES - Испанский</option>
                    <option value="DE"@if ($campaign->language == 'DE') selected @endif>DE - Немецкий</option>
                    <option>Другой / не указывать</option>
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="campaignGroup" class="col-sm-2 col-form-label">Группа (если требуется)</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="campaignGroup" name="group" required value="{{ $campaign->title }}" autocomplete="off">
              </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Сохранить</button>
        </div>
    </form>
    <div class="card-footer">
        <form action="{{ route('campaigns.destroy', ['id' => $campaign->id]) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Удалить хост</button>
        </form>
    </div>

</x-panel-layout>