<x-panel-layout>
    <x-slot name="title">
        Список сайтов
    </x-slot>

    <x-slot name="breadcrumbps">
        <ol class="c-header-nav ml-4">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="/">Список сайтов</a></li>
          <li class="breadcrumb-item active">Результаты тестов</li>  
        </ol>
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Результаты тестов</h3>
            </div>
        </div>
    </div>

    <div class="card-body">

        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {!! Session::get('message') !!}
            </div>
        @endif
        @if (!$tests->isEmpty())
        <table class="table table-responsive-sm table-borderless table-striped">
            <thead>
                <tr class="table-info ">
                    <th>Резульаты последних тестов за {{ $tests[0]->created_at }}</th>
                </tr>
            </thead>
            <tbody>
                    @php
                        $test = $tests[0];
                        $result = json_decode($test->result, 1);
                        $result = $result[array_key_first($result)];
                        $devices = $result['testResult'];
                    @endphp
                    <tr>
                        <td>
                            <strong>Пройден успешно:</strong>
                            @if ($result['passed'] == true)
                                +
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                @foreach ($devices[0] as $key => $value)
                                <th scope="col">{{ $key }}</th>
                                @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($devices as $device)
                                <tr>
                                    @foreach ($device as $key => $value)
                                    <td>{{ $value }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Проверка на вирусы:</strong>
                                @if (isset($result['virusTotal']))
                                    {{ $result['virusTotal'] }}
                                @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Тестовый лид в неогару (для лэндов):</strong>
                            @if ($result['neogaraResults'] == true)
                                +
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Доступность сайта: </strong> {{ $result['checkAvailability']['counts'] }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Консольные ошибки:</strong>
                            @if (!empty($result['consoleErrors']['messageErrors']))
                                @foreach($result['consoleErrors']['messageErrors'] as $error)
                                <div class="alert alert-danger">
                                    <div><strong>Level:</strong> {{ $error['level'] }}</div>
                                    <div><strong>Message:</strong> {{ $error['message'] }}</div>
                                    <div><strong>URL:</strong> {{ $error['URL'] }}</div>
                                </div>
                                @endforeach
                            @else
                            отсутствуют
                            @endif
                        </td>
                    </tr>
            </tbody>
        </table>
        <hr>
        <!-- <h5>Предыдущие проверки</h5> -->
        @else
        <h4>Тесты на данном сайте не проводились</h4>
        @endif
        <a href="{{ route('sites.testrun', ['id' => $id]) }}" class="btn btn-primary">Запустить тест</a>
    </div>
    
</x-panel-layout>