<x-panel-layout>
    <x-slot name="title">
        Регистрация завершена
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('cloakit.register') }}">Новая кампания</a></li> 
          <li class="breadcrumb-item active">Регистрация завершена</li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Регистрация завершена</h3>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-responsive-sm table-borderless table-hover table-striped">
            <thead>
                <tr class="table-info ">
                    <th>ID</th>
                    <th>Домен</th>
                    <th>Имя кампании</th>
                    <th>Black</th>
                    <th>White</th>
                    <th class="text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $site)
                <tr>
                    <td class="pt-3"><a href="https://panel.cloakit.space/statistic/{{$site['id']}}">{{ $site['id'] }}</a></td>
                    <td class="pt-3"><a href="https://{{ $site['domain'] }}">{{ $site['domain'] }}</a></td>
                    <td class="pt-3"><a href="https://panel.cloakit.space/statistic/{{$site['id']}}">{{ $site['name'] }}</a></td>
                    <td class="pt-3">
                        <a href="https://{{ $site['domain'] }}/{{ $site['black'] }}">{{ $site['domain'] }}/{{ $site['black'] }}</a>
                    </td>
                    <td class="pt-3">
                        <a href="https://{{ $site['domain'] }}/{{ $site['white'] }}">{{ $site['domain'] }}/{{ $site['white'] }}</a>
                    </td>
                    <td class="pt-3"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-panel-layout>