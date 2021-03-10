<x-panel-layout>
    <x-slot name="title">
        CloakIT - Новая кампания
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active">Новая кампания</li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">CloakIT - Новая кампания</h3>
            </div>
        </div>
    </div>
    <form action="{{ route('cloakit.register') }}" method="post">
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
                <label for="domains" class="col-sm-3 col-form-label">Список доменов</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="domains" name="domains" rows="10"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="vpnProxy" class="col-sm-3 col-form-label">VPN/Прокси</label>
                <div class="col-sm-9">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="proxyvpn" id="vpnProxy">
                  </div>
                </div>
              </div>
                <div class="form-group row">
                <label for="cloakitCountries" class="col-sm-3 col-form-label">Страны (на англ.)</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="cloakitCountries" name="cloakitCountries" rows="4"></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="alert alert-danger mt-3" role="alert">Если домен присутствует в базе, к нему будет автоматически добавлен id клоаки. В противном случае это придётся делать вручную. Для применения клоаки на FTP, необходимо вручную сохранить настройки сайта.</div>
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
      });
    </script>

</x-panel-layout>