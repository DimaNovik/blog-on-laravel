@extends('layout')

@section('content')
    <main>
        <section class="main">
            <div class="container">
                <div class="main__area">
                    <div class="main__news">
                        <div class="main__news_top">
                            <h2>Інформація та інформація відділу нотаріату</h2>
                        </div>
                        <ul>
                            <li>
                                <a href="/doruchennya-ta-informaciya-viddilu-notariatu">
                                    Доручення та інформація відділу нотаріату
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Інформаційні листи
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Методичні вказівки, рекомендації
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Узагальненні нотаріальної практики
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Накази Головного управління юстиції в Одеській області
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Перелік втрачених паспортів
                                </a>
                            </li>
                        </ul>
















                    </div>

                    @include('pages._right-sidebar')
                </div>
            </div>
        </section>
    </main>
@endsection