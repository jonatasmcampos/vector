<!DOCTYPE html>
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
                height: 100vh;
                width: 100vw;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #86aaac
            }

            main{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                padding: 50px;
                background-color: #fff;
                border-radius: 7px
            }

            .logo{
                width: 230px;
                height: 100px;
            }
        </style>
    </head>
    <body>
        <main>
            <img src="{{asset('img/logo.jpg')}}" alt="Logo do sistema de controle financeiro" class="logo">
            <h1>Entrar</h1>
            <input type="text" class="form-control mb-2 mt-4" id="input_login" name="login" placeholder="Digite seu login ...">
            <div class="position-relative">
                <input type="password" class="form-control" id="input_password" name="password" placeholder="Informe sua senha ...">
                <button class="btn position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0 bg-transparent" id="see_password_btn" type="button"><i id="see_password_icon" class="bi bi-eye"></i></button>
            </div>
            <button class="btn btn-dark w-100 mt-5" id="btn_entrar"> <i class="bi bi-arrow-right"></i> Entrar</button>
        </main>

        <script>
            $(document).ready(function(){
                togglePassword('see_password_btn', 'input_password', 'see_password_icon');
                $('#btn_entrar').on('click', function(){
                    disableButton('btn_entrar');

                    if(!validarCampos()){
                        return;
                    }

                    $.ajax({
                        url: @json(route('auth.login')),
                        headers:{
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        method: 'POST',
                        data: {
                            login: $('#input_login').val(),
                            password: $('#input_password').val()
                        },
                        success: function(resposta){
                            window.location.href = @json(route('view.home'));
                        },
                        error: function(err){
                            toastr.error(err.responseJSON.message);
                            enableButton('btn_entrar');
                        }
                    });
                });
            });

            function validarCampos(){
                if($('#input_login').val() === '' || $('#input_password').val() === ''){
                    toastr.warning('Preencha os campos!');
                    enableButton('btn_entrar');
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>
