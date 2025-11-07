{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <link rel="stylesheet" href="{{asset('css/custom.css')}}">
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
        <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/toastr.min.js') }}"></script>
        <script src="{{ asset('js/helper.js') }}" defer></script>

        <style>
            body{
                min-height: 100vh;
                width: 100vw;
            }

            main{
                display: flex;
                max-width: 100vw;
                height: 100%;
            }

            .main-content{
                width: 100%;
                height: 100vh;
                padding: 0 10px;
                padding: 20px 0;
            }

        </style>
    </head>
    <body>
        <main>
            @include('sidebar')
            <div class="main-content">
                <section class="mb-4">
                    @foreach (Request::segments() as $index => $segment)
                        @php
                            $isId = is_numeric($segment);
                            $texto = ucfirst(str_replace('-', ' ', $segment));
                        @endphp
                        @if (!$isId)
                            <span>{{ $texto }}</span>

                            @if (!$loop->last)
                                <span> <i class="bi bi-caret-right"></i> </span>
                            @endif
                        @endif
                    @endforeach
                </section>
                @yield('content')
            </div>
        </main>
    </body>
</html> --}}


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">

    <!-- JS -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/helper.js') }}" defer></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}" defer></script>

    <style>
       body {
            height: 100vh;
            overflow: hidden; /* impede barra geral */
        }

        main {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        aside {
            height: 100vh;
            overflow-y: auto; /* sidebar rola se passar */
        }

        .main-content {
            flex: 1;
            height: 100vh;
            overflow-y: auto; /* APENAS o conteúdo rola */
            padding: 25px 35px;
        }

        /* Breadcrumb */
        .breadcrumb-custom span{
            font-size: 0.9rem;
            color: #666;
        }
        .breadcrumb-custom i{
            font-size: 0.8rem;
            color: #aaa;
        }
    </style>
</head>

<body>
    <main>

        {{-- Sidebar --}}
        @include('sidebar')

        {{-- Conteúdo --}}
        <div class="main-content">

            {{-- Breadcrumb --}}
            <section class="breadcrumb-custom mb-4">
                @foreach (Request::segments() as $index => $segment)
                    @php
                        $isId = is_numeric($segment);
                        $texto = ucfirst(str_replace('-', ' ', $segment));
                    @endphp

                    @if (!$isId)
                        <span>{{ $texto }}</span>

                        @if (!$loop->last)
                            <i class="bi bi-chevron-right mx-2"></i>
                        @endif
                    @endif
                @endforeach
            </section>

            {{-- Conteúdo da página --}}
            @yield('content')
        </div>
    </main>
</body>
</html>
