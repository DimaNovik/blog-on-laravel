@extends('layout')

@section('content')
    <main>
        <section class="main">
            <div class="container">
                <div class="main__area">
                    <div class="main__news">

                        <div class="main__news_top">
                            <h2>{{$post->title}}</h2>
                        </div>
                        <div class="main__news_top_img">
                            <img src="{{$post->getImage()}}" alt="">
                        </div>
                        <div class="main__post-text">
                                {!! $post->content !!}
                        </div>
                        <div class="main__news_bottom_date">
                            <p class="text">Дата публікації: <span>{{$post->date}}</span></p>
                        </div>
                    </div>

                    @include('pages._right-sidebar')
                </div>
            </div>
        </section>
    </main>
@endsection