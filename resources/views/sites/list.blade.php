<x-panel-layout>
    <x-slot name="title">
        Список сайтов
    </x-slot>

    <div class="card-header">
        <div class="row">
            <div class="col align-self-start">
                <h3 class="pb-0 mb-0">Список сайтов</h3>
            </div>
            <div class="col align-self-end text-right">
                <a href="{{ route('sites.create') }}" class="btn btn-pill btn-success btn-sm">
                    <i class="cil-plus"></i> Добавить
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-responsive-sm table-borderless table-hover table-striped">
            <thead>
                <tr class="table-info ">
                    <th>Название</th>
                    <th>Количество сайтов</th>
                    <th class="text-center">FTP хост</th>
                    <th class="text-center">FTP логин</th>
                    <th class="text-center">FTP пароль</th>
                    <th class="text-right">Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="pt-3"><input class="font-weight-bold" type="text" readonly value="Hostiq"></td>
                    <td class="pt-3"><input type="text" readonly value="532"></td>
                    <td class="text-center"><input type="text" class="text-center" readonly value="192.168.1.1:21"></td>
                    <td class="text-center"><input type="text" class="text-center" readonly value="admin"></td>
                    <td class="text-center"><input type="text" class="text-center" readonly value="password"></td>
                    <td class="text-right">
                        <button type="button" class="btn btn-pill btn-dark btn-sm">Редактировать</button>
                        <button type="button" class="btn btn-pill btn-primary btn-sm">Список сайтов</button>
                    </td>
                </tr>
                <tr>
                    <td class="pt-3"><input class="font-weight-bold" type="text" readonly value="Hostiq"></td>
                    <td class="pt-3"><input type="text" readonly value="532"></td>
                    <td class="text-center"><input type="text" class="text-center" readonly value="192.168.1.1:21"></td>
                    <td class="text-center"><input type="text" class="text-center" readonly value="admin"></td>
                    <td class="text-center"><input type="text" class="text-center" readonly value="password"></td>
                    <td class="text-right">
                        <button type="button" class="btn btn-pill btn-dark btn-sm">Редактировать</button>
                        <button type="button" class="btn btn-pill btn-primary btn-sm">Список сайтов</button>
                    </td>
                </tr>
                <tr>
                    <td class="pt-3"><input class="font-weight-bold" type="text" readonly value="Hostiq"></td>
                    <td class="pt-3"><input type="text" readonly value="532"></td>
                    <td class="text-center"><input type="text" class="text-center" readonly value="192.168.1.1:21"></td>
                    <td class="text-center"><input type="text" class="text-center" readonly value="admin"></td>
                    <td class="text-center"><input type="text" class="text-center" readonly value="password"></td>
                    <td class="text-right">
                        <button type="button" class="btn btn-pill btn-dark btn-sm">Редактировать</button>
                        <button type="button" class="btn btn-pill btn-primary btn-sm">Список сайтов</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</x-panel-layout>