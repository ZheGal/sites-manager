<x-panel-layout>
    <x-slot name="title">
        Групповое добавление
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sites.list') }}">Сайты</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sites.create') }}">Добавить новый сайт</a></li>
          <li class="breadcrumb-item active">Групповое добавление сайтов</li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Групповое добавление сайтов</h3>
            </div>
            <div class="col align-self-end text-right">
                @if (Auth::user()->role == 1)
                <a href="{{ route('sites.create') }}" class="btn btn-pill btn-success btn-sm">
                    <i class="cil-plus"></i> Единичное добавление
                </a>
                @endif
            </div>
        </div>
    </div>
    <form action="{{ route('sites.group_store') }}" method="post">
        <div class="card-body">
            @csrf
            <div class="form-group row">
              <label for="siteCampaign" class="col-sm-2 col-form-label">Оффер</label>
              <div class="col-sm-10">
                <select id="siteCampaign" name="campaign_id">
                    <option value="0">Без оффера</option>
                    @foreach ($offers as $offer)
                    <option value="{{ $offer->id }}">{{ $offer->id }}. {{ $offer->languages[0]->alpha3 }} - {{ $offer->name }}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteHoster" class="col-sm-2 col-form-label">Хостер</label>
              <div class="col-sm-10">
                <select id="siteHoster" name="hoster_id">
                    @foreach ($hosters as $hoster)
                    <option value="{{ $hoster->id }}">{{ $hoster->title }} ({{ $hoster->url }})</option>
                    @endforeach
                    <option value="0">Без хостера</option>
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteHosterDomain" class="col-sm-2 col-form-label">Хостер домена</label>
              <div class="col-sm-10">
                <select id="siteHosterDomain" name="hoster_id_domain">
                  @foreach ($hosters as $hoster)
                  <option value="{{ $hoster->id }}">{{ $hoster->title }} ({{ $hoster->url }})</option>
                  @endforeach
                  <option value="0">Без хостера</option>
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteUser" class="col-sm-2 col-form-label">Пользователь / PID</label>
              <div class="col-sm-10">
                <select id="siteUser" name="user_id">
                    <option value="0">Без пользователя</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->realname }} ({{ $user->name }}) / {{ $user->pid }}</option>
                    @endforeach
                  </select>
              </div>
            </div>
                <div class="form-group row">
                  <label for="siteType" class="col-sm-2 col-form-label">Тип сайта</label>
                  <div class="col-sm-10">
                    <select class="form-control" id="siteType" name="type">
                        <option value="land">Лэнд</option>
                        <option value="preland">Прелэнд</option>
                        <option value="prelandWithLand">Лэнд с прелэндом</option>
                      </select>
                  </div>
                </div>
            
            <div class="form-group row">
                <label for="siteUser" class="col-sm-12 col-form-label">Сайты</label>
                <div class="col-sm-12">
                    <textarea class="form-control" id="groupTextarea" name="group_sites" rows="10"></textarea>
                </div>
              </div>
              <div class="form-group">
                <span>Формат: (через табы)</span>
                <div class="coded mt-2">домен_сайта  фтп_адрес фтп_логин фтп_пароль  яндекс_метрика  cloakit_id</div>
                <div class="alert alert-danger mt-3" role="alert">При групповом добавлении настройки не синхронизируются с хостом. Для синхронизации требуется ручное редактирование настроек сайта.</div>
              </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Добавить</button>
        </div>
    </form>

  <script>
    $(document).ready(function(){
      $('#siteCampaign').selectize();
      $('#siteHoster').selectize();
      $('#siteHosterDomain').selectize();
      $('#siteUser').selectize();
    });
  </script>

</x-panel-layout>