<x-panel-layout>
    <x-slot name="title">
        Заказать сайт на HOSTiQ
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sites.list') }}">Сайты</a></li>
          <li class="breadcrumb-item active">Заказть хост</li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Заказать хост</h3>
            </div>
        </div>
    </div>
    <form action="{{ route('hostiq.store') }}" method="post">
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
                  <input type="text" class="form-control" id="siteDomain" name="domain" required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <label for="siteDatacenter" class="col-sm-3 col-form-label">Датацентр</label>
                <div class="col-sm-9">
                    <select class="form-control" id="siteDatacenter" name="datacenter">
                        <option value="EU">Европа</option>
                        <option value="US">США</option>
                        <option value="UA">Украина</option>
                    </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="siteDedic" class="col-sm-3 col-form-label">Выделенный IP-адрес</label>
                <div class="col-sm-9">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="dedicated" id="siteDedic">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="useBalance" class="col-sm-3 col-form-label">Использовать баланс</label>
                <div class="col-sm-9">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="usebalance" id="useBalance" checked>
                  </div>
                </div>
              </div>
              </div>
              </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Добавить</button>
        </div>
    </form>

</x-panel-layout>