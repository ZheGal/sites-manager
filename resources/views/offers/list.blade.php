<x-panel-layout>
    <x-slot name="title">
        Групповые офферы
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active">Групповые офферы</li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Групповые офферы</h3>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if ($offers->isEmpty())
            Список офферов пуст
        @else
        <table class="table table-responsive-sm table-borderless table-hover table-striped">
            <thead>
                <tr class="table-info ">
                    <th>ID группы</th>
                    <th>Языки кампании</th>
                    <th>Имя кампании</th>
                    <th class="text-center">Количество сайтов</th>
                    <th class="text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offers as $offer)
                <tr>
                    <td class="pt-3">{{ $offer->id }}</td>
                    <td class="pt-3"><input type="text" readonly value="@foreach ($offer->languages as $lang){{ $lang->alpha3 }} - {{ $lang->name }}@endforeach" style="text-align: left;">
                    </td>
                    <td class="pt-3"><input type="text" readonly value="{{ $offer->name }}" style="font-weight: bold;"></td>
                    <td class="pt-3 text-center">{{ $count[$offer->id] }}</td>
                    <td class="text-right">
                        @if ( $count[$offer->id] != 0 )
                        <a href="{{ route('sites.list', ['campaign_id' => $offer->id]) }}" type="button" class="btn btn-pill btn-primary btn-sm">Список сайтов</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</x-panel-layout>