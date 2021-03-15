<x-panel-layout>
    <x-slot name="title">
        Добавить сайт
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sites.list') }}">Сайты</a></li>
          <li class="breadcrumb-item active">Добавить новый сайт</li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Добавить новый сайт</h3>
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
            <div class="row">
              <div class="col-md-6">
              
              <div class="form-group row">
                <label for="siteDomain" class="col-sm-3 col-form-label">Домен сайта</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="siteDomain" name="domain" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="siteFtpHost" class="col-sm-3 col-form-label">FTP хост</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="siteFtpHost" name="ftp_host">
                </div>
              </div>
              <div class="form-group row">
                <label for="siteFtpUser" class="col-sm-3 col-form-label">FTP пользователь</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="siteFtpUser" name="ftp_user">
                </div>
              </div>
              <div class="form-group row">
                <label for="siteFtpPass" class="col-sm-3 col-form-label">FTP пароль</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="siteFtpPass" name="ftp_pass">
                </div>
              </div>
              <div class="form-group row">
                <label for="siteCampaign" class="col-sm-3 col-form-label">Оффер</label>
                <div class="col-sm-9">
                  <select id="siteCampaign" name="campaign_id">
                      <option value="0">Без оффера</option>
                      @foreach ($offers as $offer)
                      <option value="{{ $offer->id }}">{{ $offer->id }}. {{ $offer->languages[0]->alpha3 }} - {{ $offer->name }}</option>
                      @endforeach
                    </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="siteHoster" class="col-sm-3 col-form-label">Хостер</label>
                <div class="col-sm-9">
                  <select id="siteHoster" name="hoster_id">
                      @foreach ($hosters as $hoster)
                      <option value="{{ $hoster->id }}">{{ $hoster->title }}</option>
                      @endforeach
                      <option value="0">Без хостера</option>
                    </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="siteHosterDomain" class="col-sm-3 col-form-label">Хостер домена</label>
                <div class="col-sm-9">
                  <select id="siteHosterDomain" name="hoster_id_domain">
                    @foreach ($hosters as $hoster)
                    <option value="{{ $hoster->id }}">{{ $hoster->title }}</option>
                    @endforeach
                    <option value="0">Без хостера</option>
                    </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="siteUser" class="col-sm-3 col-form-label">Пользователь</label>
                <div class="col-sm-9">
                  <select id="siteUser" name="user_id">
                      <option value="0">Без пользователя</option>
                      @foreach ($users as $user)
                      <option value="{{ $user->id }}">{{ $user->name }} @if ($user->pid != '') ({{ $user->pid }}) @endif</option>
                      @endforeach
                    </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="siteMetrika" class="col-sm-3 col-form-label">Яндекс Метрика</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="siteMetrika" name="yandex">
                </div>
              </div>
              <div class="form-group row">
                <label for="sitePixel" class="col-sm-3 col-form-label">Facebook Пиксель</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="sitePixel" name="facebook">
                </div>
              </div>
              <div class="form-group row">
                <label for="siteCloakit" class="col-sm-3 col-form-label">Cloak IT</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="siteCloakit" name="cloakit">
                </div>
              </div>
              <div class="form-group row">
                <label for="cleanHost" class="col-sm-3 col-form-label">Чистый хост</label>
                <div class="col-sm-9">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="clean_host" id="cleanHost">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="siteStatus" class="col-sm-3 col-form-label">Статус сайта</label>
                <div class="col-sm-9">
                  <select class="form-control" id="siteStatus" name="status">
                      <option value="1">Сайт активен</option>
                      <option value="0">Сайт неактивен</option>
                    </select>
                </div>
              </div>
                <div class="form-group row">
                  <label for="siteType" class="col-sm-3 col-form-label">Тип сайта</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="siteType" name="type">
                        <option value="land" selected>Лэнд</option>
                        <option value="preland">Прелэнд</option>
                        <option value="prelandWithLand">Лэнд с прелэндом</option>
                      </select>
                  </div>
                </div>
              </div>
            <div class="col-md-6">
                <div class="form-group row">
                  <div>
                    <label class="col-sm-12 col-form-label" style="font-weight:bold;">Дополнительные настройки</label>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteReturn" class="col-sm-3 col-form-label">Перенаправлять</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="siteReturn" name="return" value="thanks.php">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteintlToken" class="col-sm-3 col-form-label">intlToken</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="siteintlToken" name="intlToken">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteRelink" class="col-sm-3 col-form-label">Ссылка для прелэнда</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="siteRelink" name="relink">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub1" class="col-sm-3 col-form-label">sub1</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub1" name="sub1">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub2" class="col-sm-3 col-form-label">sub2</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub2" name="sub2">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub3" class="col-sm-3 col-form-label">sub3</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub3" name="sub3">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub4" class="col-sm-3 col-form-label">sub4</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub4" name="sub4">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub5" class="col-sm-3 col-form-label">sub5</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub5" name="sub5">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub6" class="col-sm-3 col-form-label">sub6</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub6" name="sub6">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub7" class="col-sm-3 col-form-label">sub7</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub7" name="sub7">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub8" class="col-sm-3 col-form-label">sub8</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub8" name="sub8">
                  </div>
                </div>
              </div>
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