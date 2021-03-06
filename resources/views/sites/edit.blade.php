<x-panel-layout>
    <x-slot name="title">
        Редактирование сайта - {{ $settings->domain }}
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sites.list') }}">Сайты</a></li>
          <li class="breadcrumb-item active">Редактирование сайта - <strong>{{ $settings->domain }}</strong></li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Редактирование сайта - <strong>{{ $settings->domain }}</strong></h3>
            </div>
            <div class="col align-self-end text-right">
              @if (Auth::user()->role == 1)
              <a href="{{ route('sites.importfrom', ['id' => $settings->id ]) }}" class="btn btn-pill btn-primary btn-sm">
                  <i class="cil-loop-circular"></i> Импортировать сайт
              </a>
              <a href="{{ route('sites.update.functions', ['id' => $settings->id ]) }}" class="btn btn-pill btn-success btn-sm">
                  <i class="cil-loop-circular"></i> Обновить функции
              </a>
              @endif
            </div>
        </div>
    </div>
    <form action="{{ route('sites.update', ['id' => $settings->id]) }}" method="post">
        <div class="card-body">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">{{ $error }}</div>
                @endforeach
            @endif
            @csrf
            @method('PATCH')
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label for="siteDomain" class="col-sm-3 col-form-label">Домен сайта</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="siteDomain" name="domain" @if (Auth::user()->role != 1) readonly @endif required value="{{ $settings->domain }}">
                  </div>
                </div>
                @if (Auth::user()->role == 1 or Auth::user()->role == 2)
                <div class="form-group row">
                  <label for="siteFtpHost" class="col-sm-3 col-form-label">FTP хост</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="siteFtpHost" name="ftp_host" @if (Auth::user()->role != 1) readonly @endif required value="{{ $settings->ftp_host }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteFtpUser" class="col-sm-3 col-form-label">FTP пользователь</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="siteFtpUser" name="ftp_user" @if (Auth::user()->role != 1) readonly @endif required value="{{ $settings->ftp_user }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteFtpPass" class="col-sm-3 col-form-label">FTP пароль</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="siteFtpPass" name="ftp_pass" @if (Auth::user()->role != 1) readonly @endif required value="{{ $settings->ftp_pass }}">
                  </div>
                </div>
                @endif
                <div class="form-group row">
                  <label for="siteCampaign" class="col-sm-3 col-form-label">Оффер</label>
                  <div class="col-sm-9">
                    <select id="siteCampaign" name="campaign_id">
                        <option value="0" @if ($settings->campaign_id == 0) selected @endif>Без оффера</option>
                        @foreach ($offers as $offer)
                        <option value="{{ $offer->id }}" @if ($settings->campaign_id == $offer->id) selected @endif>{{ $offer->id }}. {{ $offer->languages[0]->alpha3 }} - {{ $offer->name }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>
                @if (Auth::user()->role == 1 or Auth::user()->role == 2)
                <div class="form-group row">
                  <label for="siteHoster" class="col-sm-3 col-form-label">Хостер</label>
                  <div class="col-sm-9">
                    <select id="siteHoster" name="hoster_id">
                        <option value="0" @if ($settings->hoster_id == 0) selected @endif>Без хостера</option>
                        @foreach ($hosters as $hoster)
                        <option value="{{ $hoster->id }}" @if ($settings->hoster_id == $hoster->id) selected @endif>{{ $hoster->title }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteHosterDomain" class="col-sm-3 col-form-label">Хостер домена</label>
                  <div class="col-sm-9">
                    <select id="siteHosterDomain" name="hoster_id_domain">
                      <option value="0" @if ($settings->hoster_id_domain == 0) selected @endif>Без хостера</option>
                      @foreach ($hosters as $hoster)
                      <option value="{{ $hoster->id }}" @if ($settings->hoster_id_domain == $hoster->id) selected @endif>{{ $hoster->title }}</option>
                      @endforeach
                      </select>
                  </div>
                </div>
                @endif
                <div class="form-group row">
                  <label for="siteUser" class="col-sm-3 col-form-label">Пользователь / PID</label>
                  <div class="col-sm-9">
                    <select id="siteUser" name="user_id">
                        <option value="0" @if ($settings->user_id == 0) selected @endif>Без пользователя</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" @if ($settings->user_id == $user->id) selected @endif>{{ $user->realname }} ({{ $user->name }}) / {{ $user->pid }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteMetrika" class="col-sm-3 col-form-label">Яндекс Метрика</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" id="siteMetrika" name="yandex" value="{{ $settings->yandex }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sitePixel" class="col-sm-3 col-form-label">Facebook Пиксель</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" id="sitePixel" name="facebook" value="{{ $settings->facebook }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteCloakit" class="col-sm-3 col-form-label">Cloak IT</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" id="siteCloakit" name="cloakit" value="{{ $settings->cloakit }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteStatus" class="col-sm-3 col-form-label">Статус сайта</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="siteStatus" name="status">
                        <option value="1" @if (isset($settings->status)) selected @endif>Сайт активен</option>
                        <option value="0" @if (!isset($settings->status)) selected @endif>Сайт неактивен</option>
                      </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteType" class="col-sm-3 col-form-label">Тип сайта</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="siteType" name="type">
                        <option value="land" @if ($settings->type == 'land') selected @endif>Лэнд</option>
                        <option value="preland" @if ($settings->type == 'preland') selected @endif>Прелэнд</option>
                        <option value="prelandWithLand" @if ($settings->type == 'prelandWithLand') selected @endif>Лэнд с прелэндом</option>
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
                    <input type="text" class="form-control" id="siteReturn" name="return" value="{{ $settings->return }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteRelink" class="col-sm-3 col-form-label">Ссылка для прелэнда</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="siteRelink" name="relink" value="{{ $settings->relink }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub1" class="col-sm-3 col-form-label">sub1</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub1" name="sub1" value="{{ $settings->sub1 }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub2" class="col-sm-3 col-form-label">sub2</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub2" name="sub2" value="{{ $settings->sub2 }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub3" class="col-sm-3 col-form-label">sub3</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub3" name="sub3" value="{{ $settings->sub3 }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub4" class="col-sm-3 col-form-label">sub4</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub4" name="sub4" value="{{ $settings->sub4 }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub5" class="col-sm-3 col-form-label">sub5</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub5" name="sub5" value="{{ $settings->sub5 }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub6" class="col-sm-3 col-form-label">sub6</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub6" name="sub6" value="{{ $settings->sub6 }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub7" class="col-sm-3 col-form-label">sub7</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub7" name="sub7" value="{{ $settings->sub7 }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sub8" class="col-sm-3 col-form-label">sub8</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="sub8" name="sub8" value="{{ $settings->sub8 }}">
                  </div>
                </div>
              </div>
            </div>
            
            <div class="alert alert-danger" role="alert">Настройки для сайта берутся из базы данных и суммируются с файлом <strong>settings.json</strong>, который находится на FTP в корне сайта.<br />Приоритетные настройки из файла <strong>settings.json</strong>, если он существует.</div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Обновить</button>
        </div>
    </form>
    @if (Auth::user()->role == 1)
    <div class="card-footer">
        <form action="{{ route('sites.destroy', ['id' => $settings->id]) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Удалить сайт</button>
        </form>
    </div>
    @endif

<script>
  $(document).ready(function(){
    $('#siteCampaign').selectize();
    $('#siteHoster').selectize();
    $('#siteHosterDomain').selectize();
    $('#siteUser').selectize();
  });
</script>

</x-panel-layout>