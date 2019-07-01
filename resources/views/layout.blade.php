<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Нотаріат Одеської області</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!--<link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">-->

    <meta property="og:title" content="Нотаріат Одеської області"/>
    <meta property="og:description" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content=""/>
    <meta property="og:image" content=""/>

    <meta http-equiv='pragma' content='no-cache'>
    <meta http-equiv='cache-control' content='no-cache'>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no, minimal-ui"/>

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <link rel="stylesheet" href="/css/front.css">
    <style>
        @media screen and (min-width: 769px) {
            #app {
                font-size: .77vw;
            }
        }

        @media screen and (max-width: 768px) {
            #app {
                font-size: 2.134vw;
            }
        }

        @font-face {
            font-family: 'FuturaNewDemi';
            src: url("/fonts/FuturaNewDemi-Reg.woff2") format("woff2"),
            url("/fonts/FuturaNewDemi-Reg.woff") format("woff"),
            url("/fonts/FuturaNewDemi-Reg.ttf") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'FuturaNewBook';
            src: url("/fonts/FuturaNewBook-Reg.woff2") format("woff2"),
            url("/fonts/FuturaNewBook-Reg.woff") format("woff"),
            url("/fonts/FuturaNewBook-Reg.ttf") format("truetype");
            font-weight: normal;
            font-style: normal;
        }
    </style>

    <script>
        window.addEventListener('load', function () {

            (function togglePopup() {
                var link = document.querySelector('.header__auth .link');
                var popup = document.querySelector('.auth__popup');
                var overlay = document.querySelector('.overlay');

                link.addEventListener('click', function (e) {
                    e.preventDefault();

                    if (!popup.classList.contains('active')) popup.classList.add('active');

                    if (!overlay.classList.contains('active')) overlay.classList.add('active');
                });

                overlay.addEventListener('click', function () {
                    popup.classList.remove('active');
                    this.classList.remove('active');
                })
            })();

        });
    </script>

</head>

<body>

<div id="app">

    <header class="header">
        <div class="header__top_bg">
            <div class="container">
                <div class="header__top">
                    <div class="header__search">
                    <span class="text">
                        <input type="text" name="search" placeholder="Пошук...">
                    </span>
                        <span class="icon">
                        <img src="/svg/search.svg" alt="Пошук">
                    </span>
                    </div>
                    <div class="header__auth">
                    <a href="http://facebook.com" target="_blank" class="icon">
                        <img src="/images/fb-icon.png" alt="Користувач">
                    </a>
                    <span class="icon">
                        <img src="/svg/user.svg" alt="Користувач">
                    </span>

                        @if(Auth::check())
                            <a href="/pages/cabinet" class="link-cabinet">Особистий кабінет</a>
                            &nbsp;&nbsp;
                            <a href="/pages/logout" class="link-cabinet">Вийти</a>
                        @else
                            <a href="#" class="link" id="login">Увійти</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @include('pages._navigate')

    </header>

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="footer__area">
                <div class="footer__item">
                    <p>&copy; Нотаріат Одеської області</p>
                    <p>вул. Богдана Хмельницького, 34,
                        <br/>м. Одеса, 65007</p>
                    <div class="footer__item-area">
                        <div class="footer__item-work">
                            <p><a href="mailto:info@od.minjust.gov.ua">

                                    info@od.minjust.gov.ua

                                </a>
                            </p>
                            <p>Час роботи:
                                <br/>ПН-ЧТ: з 9:00 до 18:00
                                <br/>ПТ: з 9:00 до 16:45
                                <br/>Обідня перерва: з 13:00 до 13:45</p>
                        </div>
                        <div class="footer__item-work">
                            <p><a href="tel:048-705-18-21">(048) 705-18-21</a> - «гаряча» телефонна лінія</p>
                            <p>Час роботи:
                                <br/>ПН-ЧТ: з 10:00 до 16:00
                                <br/>Обідня перерва: з 13:00 до 13:45
                                <br/> <a href="tel:048-705-18-00">(048) 705-18-00</a> - тел. приймальні
                                <br/> <a href="tel:048-705-18-01">(048) 705-18-01</a> - тел./факс</p>
                        </div>
                    </div>
                </div>
                <div class="footer__item">
                    <h2 class="title">Про відділ</h2>
                    <ul class="list">
                        <li><a href="/pro-viddil" class="link">Склад відділу</a></li>
                        <li><a href="#" class="link">Правові засади діяльності</a></li>
                        <li><a href="/kontakti" class="link">Контакти</a></li>
                    </ul>
                </div>
                <div class="footer__item">
                    <h2 class="title">Посилання</h2>
                    <ul class="list">
                        <li>
                            <a href="/allposts">Новини</a>
                        </li>
                    </ul>
                </div>
                <div class="footer__item">
                    <h2 class="title">Корисна інформація</h2>
                    <ul class="list">
                        <li><a href="#" class="link">Єдиний реєстр нотаріусів</a></li>
                        <li><a href="#" class="link">Консультативно-матодична Рада</a></li>
                        <li><a href="/old/index.php" class="link">Форум</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    @include('pages.register')


    <div class="overlay"></div>
    <script src="/js/front.js"></script>
</body>
</html>
