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
                            @foreach($categories as $category)
                            <li>
                                <a href="{{route('doc.show', $category->id)}}">
                                   {{$category->title}}
                                </a>
                            </li>
                            @endforeach
                        </ul>

                    </div>

                    @include('pages._right-sidebar')
                </div>
            </div>
        </section>
    </main>
@endsection