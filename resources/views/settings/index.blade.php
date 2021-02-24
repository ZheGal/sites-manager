<x-panel-layout>
    <x-slot name="title">
        Редактирование сайта
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active">Настройки</li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Настройки</h3>
            </div>
            <div class="col align-self-end text-right">

            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="/" method="post">
            @csrf
            <div class="col-md-6">
                
            <div class="form-group row">
                <h4 class="col-md-12">Данные от Neogara</h4>
            </div>
            <div class="form-group row">
              <label for="neogaraLogin" class="col-sm-2 col-form-label">Логин</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="neogaraLogin" name="neogara_login">
              </div>
            </div>
            <div class="form-group row">
              <label for="neogaraPassword" class="col-sm-2 col-form-label">Пароль</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="neogaraPassword" name="neogara_password">
              </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <hr>
                </div>
            </div>
            </div>
            <div class="col-md-6">
                
                <div class="form-group row">
                    <label for="hostiqToken" class="col-sm-3 col-form-label">HOSTiQ API Token</label>
                    <div class="col-sm-7">
                    <input type="text" class="form-control" id="hostiqToken" name="hostiq_token">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="yandexToken" class="col-sm-3 col-form-label">Yandex API Token</label>
                    <div class="col-sm-7">
                    <input type="text" class="form-control" id="yandexToken" name="yandex_token">
                    </div>
                </div>
            </div>
        </form>
    </div>

</x-panel-layout>