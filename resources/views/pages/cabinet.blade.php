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
                        {{--<div class="main__cards">--}}
                            {{--@foreach($posts as $post)--}}
                                {{--<a href="/" class="item" style="background-image: url('{{$post->getImage()}}')">--}}
                                    {{--<div class="description">--}}
                                        {{--<span class="time">{{$post->date}}</span>--}}
                                        {{--<h3 class="title">{{$post->title}}</h3>--}}
                                        {{--<div class="text">--}}
                                            {{--{!! $post->description  !!}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</a> <!-- End item news -->--}}
                            {{--@endforeach--}}

                        {{--</div>--}}

                        {{--{{$posts->links()}}--}}
                    </div>

                    @include('pages._right-sidebar')
                </div>
            </div>
        </section>
    </main>
@endsection