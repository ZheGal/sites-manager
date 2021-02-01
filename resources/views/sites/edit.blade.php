<x-panel-layout>
    <x-slot name="title">
        Редактирование сайта
    </x-slot>

    <x-slot name="breadcrumbps">
      <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sites.list') }}">Сайты</a></li>
          <li class="breadcrumb-item active">Редактирование сайта</li>  
        </ol>
      </div>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Редактирование сайта</h3>
            </div>
        </div>
    </div>
    <form action="{{ route('sites.update', ['id' => $site->id]) }}" method="post">
        <div class="card-body">
            @csrf
            @method('PATCH')
            <div class="form-group row">
              <label for="siteDomain" class="col-sm-2 col-form-label">Домен сайта</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="siteDomain" name="domain" required value="{{ $site->domain }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="siteFtpHost" class="col-sm-2 col-form-label">FTP хост</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="siteFtpHost" name="ftp_host" required value="{{ $site->ftp_host }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="siteFtpUser" class="col-sm-2 col-form-label">FTP пользователь</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="siteFtpUser" name="ftp_user" required value="{{ $site->ftp_user }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="siteFtpPass" class="col-sm-2 col-form-label">FTP пароль</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="siteFtpPass" name="ftp_pass" required value="{{ $site->ftp_pass }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="siteCampaign" class="col-sm-2 col-form-label">Кампания</label>
              <div class="col-sm-10">
                <select class="form-control" id="siteCampaign" name="campaign_id">
                    <option value="0" @if ($site->campaign_id == 0) selected @endif>Без кампании</option>
                    @foreach ($campaigns as $campaign)
                    <option value="{{ $campaign->id }}" @if ($site->campaign_id == $campaign->id) selected @endif>{{ $campaign->language }} - {{ $campaign->title }}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteHoster" class="col-sm-2 col-form-label">Хостер</label>
              <div class="col-sm-10">
                <select class="form-control" id="siteHoster" name="hoster_id">
                    <option value="0" @if ($site->hoster_id == 0) selected @endif>Без хостера</option>
                    @foreach ($hosters as $hoster)
                    <option value="{{ $hoster->id }}" @if ($site->hoster_id == $hoster->id) selected @endif>{{ $hoster->title }} ({{ $hoster->url }})</option>
                    @endforeach
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteHosterDomain" class="col-sm-2 col-form-label">Хостер домена</label>
              <div class="col-sm-10">
                <select class="form-control" id="siteHosterDomain" name="hoster_id_domain">
                  <option value="0" @if ($site->hoster_id_domain == 0) selected @endif>Без хостера</option>
                  @foreach ($hosters as $hoster)
                  <option value="{{ $hoster->id }}" @if ($site->hoster_id_domain == $hoster->id) selected @endif>{{ $hoster->title }} ({{ $hoster->url }})</option>
                  @endforeach
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteUser" class="col-sm-2 col-form-label">Пользователь</label>
              <div class="col-sm-10">
                <select class="form-control" id="siteUser" name="user_id">
                    <option value="0" @if ($site->user_id == 0) selected @endif>Без пользователя</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}" @if ($site->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteMetrika" class="col-sm-2 col-form-label">Яндекс Метрика</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="siteMetrika" name="yandex" value="{{ $site->yandex }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="sitePixel" class="col-sm-2 col-form-label">Facebook Пиксель</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="sitePixel" name="facebook" value="{{ $site->facebook }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="siteStatus" class="col-sm-2 col-form-label">Статус сайта</label>
              <div class="col-sm-10">
                <select class="form-control" id="siteStatus" name="status">
                    <option value="1" @if ($site->status == 1) selected @endif>Сайт активен</option>
                    <option value="0" @if ($site->status == 0) selected @endif>Сайт неактивен</option>
                  </select>
              </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Обновить</button>
        </div>
    </form>
    <div class="card-footer">
        <form action="{{ route('sites.destroy', ['id' => $site->id]) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Удалить сайт</button>
        </form>
    </div>

</x-panel-layout>