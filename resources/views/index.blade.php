<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Главная страница</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body class="bg-light">
    <header class="navbar navbar-expand-md bg-dark shadow">
        <div class="container-fluid">
            <h3 class="text-light pt-2 pb-2">Панель управления сайтами</h3>
            <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link text-light" href="#">Пользователь</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light" href="#">Настройки</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-light" href="#">Выйти</a>
                </li>
              </ul>
        </div>
    </header>

    <main class="container-fluid">
        <div class="card mt-4 shadow-sm">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="pt-2 pb-1">Список сайтов</h3>
                    </div>
                    <div class="col-md-6 d-flex p-2 flex-row-reverse">
                        <a href="{{ route('sites.create') }}" class="btn btn-primary">Добавить новый</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>