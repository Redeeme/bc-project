<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css.css?v=') . time() }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style type="text/css">
        html, body {
            height: 100%;
            padding: 0px;
            margin: 0px;
            overflow: hidden;
        }

        .containerFooter {
            text-align: center;
            color: white;
            position: static;
            background-color: #4854cc;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            min-height: 150px;
            max-height: 160px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: auto;
        }

        .footerText {
            color: white;
            font-size: clamp(1rem, 2.5vw, 2rem);
            width: 50%;
        }

        .bottom-right {
            position: static;
            bottom: 8px;
            right: 16px;
            color: black;
        }

        .black-text {
            color: black !important;
        }

        #loading-spinner-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        #loading-spinner {
            width: 3rem;
            height: 3rem;
        }

        .hidden {
            display: none;
        }
    </style>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"></script>
    <script>
        function validateForm(inputCategoryId) {
            const inputCategory = document.getElementById(inputCategoryId);
            if (inputCategory.value === "") {
                alert("Please select an option");
                return false;
            }
            return true;
        }
    </script>
    <!-- Fonts -->
    <title>@yield('pageTitle')</title>


</head>
<body style="display:flex; flex-direction:column;overflow:auto ">
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href={{route('welcome-page')}}>Bakalárska práca</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href={{route('welcome-page')}}>Domov</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href={{route('get-datasets')}}>Ganttov
                            diagram</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href={{route('select-table-view')}}>Dáta</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle black-text" href="#" id="navbarDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Grafikon
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href={{route('select-schedule-grafikon')}}>Grafikon 1</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href={{route('select-schedule-stations-grafikon')}}>Grafikon
                                    2</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href={{route('get-stats')}}>Štatistiky </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href={{route('import-upload')}}>Import dát</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href={{route('datasets')}}>Správa datasetov</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<main class="py-4">
    @yield('content')
</main>
</body>
<div class="containerFooter">
    <div class="footerText">
        <h6>
            Tento footer obsahuje odkazy na sociálne siete, kontaktné údaje spoločnosti a informácie o autorských
            právach.
        </h6>
    </div>
    <div class="bottom-right">
        <h6>Autor</h6>
        <h6>Jozef Forgáč</h6>
    </div>
</div>
</html>
