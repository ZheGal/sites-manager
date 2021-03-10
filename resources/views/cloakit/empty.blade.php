<x-panel-layout>
    <x-slot name="title">
        Список доменов пустой
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('cloakit.register') }}">Новая кампания</a></li> 
          <li class="breadcrumb-item active">Список доменов пустой</li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Список доменов пустой</h3>
            </div>
        </div>
    </div>
    <div class="card-body">
        <a href="{{ route('cloakit.register') }}" class="btn btn-primary">Зарегистрировать заново</a>
    </div>

</x-panel-layout>