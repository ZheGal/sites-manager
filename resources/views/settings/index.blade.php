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
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {!! Session::get('message') !!}
            </div>
        @endif
        <form action="{{ route('settings.update') }}" method="post">
            @csrf
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="hostiqToken" class="col-sm-4 col-form-label">HOSTiQ API Token</label>
                    <div class="col-sm-6">
                    <input type="text" readonly class="form-control" id="hostiqToken" value="@php echo env('HOSTIQ_API') @endphp">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="yandexToken" class="col-sm-4 col-form-label">Yandex API Token (Основной)</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="yandexToken" name="yandex_token" @if(isset($settings['yandex_token']) && !empty($settings['yandex_token'])) value="{{ $settings['yandex_token'] }}" @endif>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="yandexTokenAdd" class="col-sm-4 col-form-label">Yandex API Token (Дополнительные)</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="yandexTokenAdd" name="yandex_token_add" @if(isset($settings['yandex_token_add']) && !empty($settings['yandex_token_add'])) value="{{ $settings['yandex_token_add'] }}" @endif>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row pt-3">
                    <label for="neogaraLogin" class="col-sm-4 col-form-label">Neogara Логин</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="neogaraLogin" value="@php echo env('NEO_USERNANE') @endphp" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="neogaraPassword" class="col-sm-4 col-form-label">Neogara Пароль</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="neogaraPassword" value="@php echo env('NEO_PASSWORD') @endphp" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <strong>Neogara Auth Token: </strong>  @if(isset($settings['neogara_token']) && !empty($settings['neogara_token'])) <div class="coded">{{ $settings['neogara_token'] }}</div> @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row pt-3">
                    <label for="cloakItLogin" class="col-sm-4 col-form-label">Cloak IT Логин</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="cloakItLogin" value="@php echo env('CLO_USERNAME') @endphp" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cloakItPass" class="col-sm-4 col-form-label">Cloak IT Пароль</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="cloakItPass" value="@php echo env('CLO_PASSWORD') @endphp" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="testingApi" class="col-sm-4 col-form-label">Адрес API для тестирования</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" id="testingApi" value="@php echo env('TEST_API_URL') @endphp" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>

</x-panel-layout>