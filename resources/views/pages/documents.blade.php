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
                                    <div class="item">
                                        <span class="icon">
                                            <img src="/images/doc.png" alt="Doc">
                                        </span>
                                        <span>
                                            <a href="{{$doc->getImage()}}" download class="file-link">{{$doc->title}}</a>
                                            <p>
                                                <span class="text-sm"><b>Дата публікації: </b><span class="text-sm">{{$doc->created_at}}</span></span>
                                            </p>
                                        </span>
                                    </div>
                            </div>
                        @endforeach

                    </div>

                    @include('pages._right-sidebar')
                </div>
            </div>
        </section>
    </main>
@endsection