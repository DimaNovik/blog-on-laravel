@extends('layout')

@section('content')
    <main>
        <section class="main">
            <div class="container">
                <div class="main__area">
                    <div class="main__news">

                        <div class="main__news_top">
                            <h2>{{$category->title}}</h2>
                        </div>

                        @foreach($documents as $doc)
                            <div class="main__post-text" style="margin-bottom: 10px;">
                                    <p>{{$doc->title}}</p>
                                    <p>{!!$doc->file!!}</p>

                            </div>
                        @endforeach
                    </div>

                    @include('pages._right-sidebar')
                </div>
            </div>
        </section>
    </main>
@endsection