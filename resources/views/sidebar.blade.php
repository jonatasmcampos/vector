<style>
    aside {
        /* background-color: #f8f9fa; */
        background-color: #f1f6fa;
        width: 250px;
        height: 100vh;
        padding: 20px 0;
        position: relative;
        border-right: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
    }

    .sidebar-header {
        text-align: center;
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 35px;
        color: #333;
    }

    .sidebar-section-title {
        color: #6c757d;
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 600;
        margin: 20px 0 10px 15px;
    }

    .sidebar-options {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .option {
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 15px;
        display: block;
        transition: background 0.2s ease, color 0.2s ease;
        color: #333;
    }

    .option i {
        margin-right: 8px;
        font-size: 16px;
    }

    .option:hover {
        background-color: #e6ebed;
        color: #000;
    }

    .active {
        background-color: #89aaac !important;
        color: #fff !important;
    }

    footer {
        margin-top: auto;
        padding: 20px 15px;
        border-top: 1px solid #ddd;
        text-align: center;
    }

    footer p {
        margin: 0;
        font-size: 14px;
        font-weight: 500;
    }

    #btn_deslogar {
        margin-top: 12px;
    }

    a{
        text-decoration: none
    }

    nav{
        padding: 0 7px
    }
</style>

<aside>
    
    <div class="sidebar-header">VECTOR</div>

    <nav>
        @if (session('permissions'))
            @foreach (session('permissions') as $menu => $permissions)
                <div class="sidebar-section-title">{{$menu}}</div>
                @foreach ($permissions as $permission)
                    <a href="{{ route($permission['route']) }}"
                        class="option @if(Request::segment(1) == $permission["process"]) active @endif">
                        <i class="{{$permission['icon']}}"></i> {{$permission['name']}}
                    </a>
                @endforeach
            @endforeach
        @endif
    </nav>

    <footer>
        @php
            $names = explode(' ', session('user.name'));
            $first_name = $names[0];
            $last_name = $names[count($names) - 1];
        @endphp

        <div class="d-flex justify-content-center align-items-center mb-2">
            <i class="bi bi-person-circle me-2" style="font-size:18px;"></i>
            <p>{{$last_name.', '.$first_name.'.'}}</p>
        </div>

        <button class="btn btn-outline-dark w-100" id="btn_deslogar">
            <i class="bi bi-box-arrow-right"></i> Sair
        </button>
    </footer>

</aside>

<script>
    $(function(){
        $('#btn_deslogar').on('click', function(){
            disableButton('btn_deslogar');
            $.ajax({
                url: @json(route('auth.logout')),
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                method: 'GET',
                success: function(){
                    window.location.href = @json(route('view.login'));
                },
                error: function(err){
                    toastr.error(err.responseJSON.message);
                    enableButton('btn_deslogar');
                }
            });
        });
    });
</script>
