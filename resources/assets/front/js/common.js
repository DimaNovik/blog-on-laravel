window.addEventListener('load', function () {

    (function togglePopup() {
        var link = document.querySelector(' #login');
        var popup = document.querySelector('.auth__popup');
        var popupReg = document.querySelector('#reg-popup');
        var overlay = document.querySelector('.overlay');
        var reglink = document.querySelector('#change-popup');

       if(link) {
           link.addEventListener('click', function (e) {
            e.preventDefault();

            if(!popup.classList.contains('active')) popup.classList.add('active');

            if(!overlay.classList.contains('active')) overlay.classList.add('active');
        });

       }

        reglink.addEventListener('click', function (e) {
            e.preventDefault();

            if(popup.classList.contains('active')) {
                popup.classList.remove('active');
                popupReg.classList.add('active');
            }


        });

        overlay.addEventListener('click', function () {
            popup.classList.remove('active');
            popupReg.classList.remove('active');
            this.classList.remove('active');
        })
    })();

    (function toogleMenu() {
        var nav = document.querySelector('.header__nav');
        var burger = document.querySelector('.header__nav_mob .burger');
        var menu = document.querySelectorAll('.header__list .link');

        burger.addEventListener('click', function (e) {
            e.preventDefault();
            nav.classList.toggle('active');
        });

        menu.forEach(function (item) {
            item.addEventListener('click', function () {
                this.nextElementSibling.classList.toggle('active');
            })
        })

    })();

    (function sendRegister() {
        var popupReg = document.querySelector('#reg-popup');
        var regSubmit = document.querySelector('#reg-form');
        var overlay = document.querySelector('.overlay');
        var errorArea = document.querySelector('#reg-popup .error-message');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        regSubmit.addEventListener('submit', function (e) {
            e.preventDefault();


            $.ajax({
                type:'post',
                url:$(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    popupReg.classList.remove('active');
                    overlay.classList.remove('active');
                },
                error: function (error) {
                    errorArea.innerText = 'Логін чи Email вже існує в базі'
                }
            })
        })
    })();

    (function sendLogin() {
        var popupLogin = document.querySelector('#auth');
        var loginSubmit = document.querySelector('#auth-form');
        var overlay = document.querySelector('.overlay');
        var errorArea = loginSubmit.querySelector('.error-message');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        loginSubmit.addEventListener('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type:'post',
                url:$(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    popupLogin.classList.remove('active');
                    overlay.classList.remove('active');
                    document.location.reload(true);
                },
                error: function (error) {
                    errorArea.innerText = 'Логін чи Пароль не знайден'
                }
            });
        })
    })();

    (function appendLogo() {
        var navList = document.querySelectorAll('.header__list-item');
        var li = document.createElement('li');
        var link = document.createElement('a');
        var img = document.createElement('img');

        link.setAttribute('href', '/');
        link.setAttribute('class', 'link link--logo');

        img.setAttribute('src', '/images/main-logo.png');
        img.setAttribute('class', 'logo');
        img.setAttribute('alt', 'Нотаріат одеської області');

        link.append(img);

        li.append(link);

        for(var i=0; i<navList.length; i++) {

            if(i === 2) {

                navList[i].after(li);

            }
        }

    })();

    (function toggleMenu() {
        var menuItem = document.querySelectorAll('.header__list .header__list-item .link');
        var dropdown = document.querySelectorAll('.header__down');

        menuItem.forEach(function (item) {

            if(item.nextElementSibling === null) return;

            item.addEventListener('click', function (event) {
                event.preventDefault();

                    dropdown.forEach(function (item) {

                    if(item.classList.contains('active')) {
                        item.classList.remove('active');
                    }
                });
                    this.nextElementSibling.classList.add('active');
            }
            )
        })

    })();

    (function targetAwayMenu() {

        window.addEventListener('click', function(event) {
            if(!event.target.matches('.header__down') && !event.target.matches('.header__list-item')  && !event.target.matches('a.link')) {
               var dropdown = document.querySelectorAll('.header__down');

               dropdown.forEach(function (item) {
                   item.classList.remove('active');
               })
           }
        })

    })();

});