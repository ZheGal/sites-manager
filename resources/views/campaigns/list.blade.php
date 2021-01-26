<x-panel-layout>
    <x-slot name="title">
        Список кампаний
    </x-slot>

    <x-slot name="breadcrumbps">
      <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active">Кампании</li>  
        </ol>
      </div>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Список кампаний</h3>
            </div>
            <div class="col align-self-end text-right">
                <a href="{{ route('campaigns.create') }}" class="btn btn-pill btn-success btn-sm">
                    <i class="cil-plus"></i> Добавить
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        @if ($campaigns->isEmpty())
            Список кампаний пустой
        @else
        <table class="table table-responsive-sm table-borderless table-hover table-striped">
            <thead>
                <tr class="table-info ">
                    <th></th>
                    <th>Язык кампании</th>
                    <th>Имя кампании</th>
                    <th>Номер группы</th>
                    <th class="text-center">Количество сайтов</th>
                    <th class="text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($campaigns as $campaign)
                <tr>
                    <td class="pt-3">{{ $loop->iteration }}</td>
                    <td class="pt-3"><input type="text" readonly value="{{ $campaign->language }}"></td>
                    <td class="pt-3"><input type="text" readonly value="{{ $campaign->title }}"></td>
                    <td class="pt-3"><input type="text" readonly value="{{ $campaign->group }}"></td>
                    <td class="pt-3"><input type="text" readonly value="{{ $campaign->sites->count() }}" class="text-center" style="width:100%;"></td>
                    <td class="text-right">
                        <a href="{{ route('campaigns.edit', ['id' => $campaign->id]) }}" type="button" class="btn btn-pill btn-dark btn-sm">Редактировать</a>
                        <a href="{{ route('sites.list', ['campaign_id' => $campaign->id]) }}" type="button" class="btn btn-pill btn-primary btn-sm">Список сайтов</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</x-panel-layout>