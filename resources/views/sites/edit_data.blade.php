<x-panel-layout>
    <x-slot name="title">
        Редактирование сайта - {{ $site->domain }}
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sites.list') }}">Сайты</a></li>
          <li class="breadcrumb-item active">Редактирование сайта -&nbsp;<strong>{{ $site->domain }}</strong></li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Редактирование сайта - <strong>{{ $site->domain }}</strong></h3>
            </div>
            <div class="col align-self-end text-right">
              @if (Auth::user()->role == 1)
              <a href="{{ route('sites.importfrom', ['id' => $site->id ]) }}" class="btn btn-pill btn-primary btn-sm">
                  <i class="cil-loop-circular"></i> Импортировать сайт
              </a>
              <a href="{{ route('sites.update.functions', ['id' => $site->id ]) }}" class="btn btn-pill btn-success btn-sm">
                  <i class="cil-loop-circular"></i> Обновить функции
              </a>
              @endif
            </div>
        </div>
    </div>
    <form action="{{ route('sites.update', ['id' => $site->id]) }}" method="post">
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
                    <input type="text" class="form-control" id="siteDomain" name="domain" @if (Auth::user()->role != 1) readonly @endif required value="{{ $site->domain }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteFtpHost" class="col-sm-3 col-form-label">FTP хост</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="siteFtpHost" name="ftp_host" @if (Auth::user()->role != 1) readonly @endif required value="{{ $site->ftp_host }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteFtpUser" class="col-sm-3 col-form-label">FTP пользователь</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="siteFtpUser" name="ftp_user" @if (Auth::user()->role != 1) readonly @endif required value="{{ $site->ftp_user }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteFtpPass" class="col-sm-3 col-form-label">FTP пароль</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="siteFtpPass" name="ftp_pass" @if (Auth::user()->role != 1) readonly @endif required value="{{ $site->ftp_pass }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="siteStatus" class="col-sm-3 col-form-label">Статус сайта</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="siteStatus" name="status">
                        <option value="1" @if (isset($site->status)) selected @endif>Сайт активен</option>
                        <option value="0" @if (!isset($site->status)) selected @endif>Сайт неактивен</option>
                      </select>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Обновить</button>
        </div>
    </form>
    @if (Auth::user()->role == 1)
    <div class="card-footer">
        <form action="{{ route('sites.destroy', ['id' => $site->id]) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit">Удалить сайт</button>
        </form>
    </div>
    @endif

</x-panel-layout>