<x-panel-layout>
    <x-slot name="title">
        Добавить сайт
    </x-slot>

    <x-slot name="breadcrumbps">
      <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sites.list') }}">Сайты</a></li>
          <li class="breadcrumb-item active">Добавить сайт</li>  
        </ol>
      </div>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Добавить сайт</h3>
            </div>
        </div>
    </div>
    <form action="{{ route('sites.store') }}" method="post">
        <div class="card-body">
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
                <input type="text" class="form-control" id="siteFtpHost" name="ftp_host" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteFtpUser" class="col-sm-2 col-form-label">FTP пользователь</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="siteFtpUser" name="ftp_user" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteFtpPass" class="col-sm-2 col-form-label">FTP пароль</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="siteFtpPass" name="ftp_pass" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteCampaign" class="col-sm-2 col-form-label">Кампания</label>
              <div class="col-sm-10">
                <select class="form-control" id="siteCampaign" name="campaign_id">
                    <option value="0">Без кампании</option>
                    <option value="1">PL - Maximzier</option>
                    <option value="2">RU - Общее дело</option>
                    <option value="3">PL - Cotydzien</option>
                    <option value="4">EN - Bitcoin Union</option>
                    <option value="5">PL - Bitcoin Pro</option>
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
                  </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="siteUser" class="col-sm-2 col-form-label">Пользователь</label>
              <div class="col-sm-10">
                <select class="form-control" id="siteUser" name="user_id">
                    <option value="0">Без пользователя</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
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
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Добавить</button>
        </div>
    </form>

</x-panel-layout>