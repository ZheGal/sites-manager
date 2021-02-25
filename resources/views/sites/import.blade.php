<x-panel-layout>
    <x-slot name="title">
        Редактирование сайта
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sites.list') }}">Сайты</a></li>
          <li class="breadcrumb-item"><a href="{{ route('sites.edit', ['id' => $site->id]) }}">Редактирование сайта</a></li>
          <li class="breadcrumb-item active">Импортировать сайт</li>
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Импортировать сайт</h3>
            </div>
        </div>
    </div>
    <form action="{{ route('sites.import', ['id' => $site->id]) }}" method="post">
        <div class="card-body">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">{{ $error }}</div>
                @endforeach
            @endif
            @csrf
            <div class="form-group row">
              <label for="siteDomain" class="col-sm-2 col-form-label">Импортируемый сайт</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="siteDomain" name="domain" required>
              </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Импортировать</button>
        </div>
    </form>

</x-panel-layout>