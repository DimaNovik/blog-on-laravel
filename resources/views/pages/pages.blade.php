@extends('layout')

@section('content')
    <main>
        <section class="main">
            <div class="container">
                <div class="main__area">
                    <div class="main__news">

                        <div class="main__news_top">
                            <h2>{{$pages->title}}</h2>
                        </div>
                        <div class="main__post-text">
                            {!! $pages->content !!}
                        </div>
                    </div>

                    @include('pages._right-sidebar')
                </div>
            </div>
        </section>
    </main>
@endsection