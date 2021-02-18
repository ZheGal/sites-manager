<x-panel-layout>
    <x-slot name="title">
        Добавить сайт
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sites.list') }}">Сайты</a></li>
          <li class="breadcrumb-item active">Добавить сайт</li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Добавить сайт</h3>
            </div>
            <div class="col align-self-end text-right">
                @if (Auth::user()->role == 1)
                <a href="{{ route('sites.group') }}" class="btn btn-pill btn-success btn-sm">
                    <i class="cil-plus"></i> Групповое добавление
                </a>
                @endif
            </div>
        </div>
    </div>
    <form action="{{ route('sites.store') }}" method="post">
        <div class="card-body">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">{{ $error }}</div>
                @endforeach
            @endif
            @csrf
            <div class="form-group row">
              <label for="siteDomain" class="col-sm-2 col-form-label">Домен сайта</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="siteDomain" name="domain" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteFtpHost" class="col-sm-2 col-form-label">FTP хост</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="siteFtpHost" name="ftp_host">
              </div>
            </div>
            <div class="form-group row">
              <label for="siteFtpUser" class="col-sm-2 col-form-label">FTP пользователь</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="siteFtpUser" name="ftp_user">
              </div>
            </div>
            <div class="form-group row">
              <label for="siteFtpPass" class="col-sm-2 col-form-label">FTP пароль</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="siteFtpPass" name="ftp_pass">
              </div>
            </div>
            <div class="form-group row">
              <label for="siteCampaign" class="col-sm-2 col-form-label">Кампания</label>
              <div class="col-sm-10">
                <select class="form-control" id="siteCampaign" name="campaign_id">
                    <option value="0">Без кампании</option>
                    @foreach ($campaigns as $campaign)
                    <option value="{{ $campaign->id }}">@if ($campaign->language != '0'){{ $campaign->language }} - @endif{{ $campaign->title }} @if(isset($campaign->group))({{ $campaign->group }})@endif</option>
                    @endforeach
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteHoster" class="col-sm-2 col-form-label">Хостер</label>
              <div class="col-sm-10">
                <select class="form-control" id="siteHoster" name="hoster_id">
                    @foreach ($hosters as $hoster)
                    <option value="{{ $hoster->id }}">{{ $hoster->title }}</option>
                    @endforeach
                    <option value="0">Без хостера</option>
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteHosterDomain" class="col-sm-2 col-form-label">Хостер домена</label>
              <div class="col-sm-10">
                <select class="form-control" id="siteHosterDomain" name="hoster_id_domain">
                  @foreach ($hosters as $hoster)
                  <option value="{{ $hoster->id }}">{{ $hoster->title }}</option>
                  @endforeach
                  <option value="0">Без хостера</option>
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteUser" class="col-sm-2 col-form-label">Пользователь</label>
              <div class="col-sm-10">
                <select class="form-control" id="siteUser" name="user_id">
                    <option value="0">Без пользователя</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} @if ($user->pid != '') ({{ $user->pid }}) @endif</option>
                    @endforeach
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteMetrika" class="col-sm-2 col-form-label">Яндекс Метрика</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="siteMetrika" name="yandex">
              </div>
            </div>
            <div class="form-group row">
              <label for="sitePixel" class="col-sm-2 col-form-label">Facebook Пиксель</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="sitePixel" name="facebook">
              </div>
            </div>
            <div class="form-group row">
              <label for="cleanHost" class="col-sm-2 col-form-label">Чистый хост</label>
              <div class="col-sm-10">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="1" name="clean_host" id="cleanHost">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteStatus" class="col-sm-2 col-form-label">Статус сайта</label>
              <div class="col-sm-10">
                <select class="form-control" id="siteStatus" name="status">
                    <option value="1">Сайт активен</option>
                    <option value="0">Сайт неактивен</option>
                  </select>
              </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Добавить</button>
        </div>
    </form>

</x-panel-layout>