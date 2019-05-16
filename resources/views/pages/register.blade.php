
    <div class="auth__popup" id="auth">

        <form  action="{{route('login')}}" class="auth__form" id="auth-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h2>Особистий кабінет</h2>

            <ul class="error-area"></ul>

            @if(session('status'))
                {{session('status')}}
                @endif
            <p>
                <label>
                    <input type="text" name="email" class="input" placeholder="E-mail" value="{{old('email')}}">
                </label>
            </p>
            <p>
                <label>
                    <input type="password" name="password" class="input" placeholder="Пароль">
                </label>
            </p>
            <p>
                <input type="submit" class="submit" value="Увійти">
            </p>
            <p>
                <a href="#" class="reg" id="change-popup">Реєстрація</a>
            </p>
        </form>
    </div>

    <div class="auth__popup" id="reg-popup">

        <form class="auth__form" action="{{route('register')}}" id="reg-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <h2>Реєстрація особистого кабінету</h2>

            <ul class="error-area"></ul>
            <p>
                <label>
                    <input type="text" name="name" class="input" placeholder="ПІБ" value="{{old('fio')}}">
                </label>
            </p>
            <p>
                <label>
                    <input type="email" name="email" class="input" placeholder="E-mail" value="{{old('email')}}">
                </label>
            </p>
            <p>
                <label>
                    <input type="number" name="phone" class="input" placeholder="Телефон" value="{{old('phone')}}">
                </label>
            </p>
            <p>
                <label>
                    <input type="password" name="password" class="input" placeholder="Пароль" value="{{old('password')}}">
                </label>
            </p>
            <p>
                <input type="submit" class="submit" value="Зареєструвати">
            </p>
        </form>
    </div>