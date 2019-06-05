<div class="main__right">
    <div class="main__info">
        <h2>Інформація для громадян</h2>
        <a href="https://online.minjust.gov.ua/" target="_blank">
            <img src="/images/bydjust.png" alt="Он-лайн будинок юстиції" class="img">
        </a>
        
        <div class="old">
            <a href="http://notary-just.odessa.gov.ua/" target="_blank">
                Минула версія сайту
            </a>
        </div>
    </div>
    <div class="main__anons">
        <h2>Анонси</h2>
        @foreach($anonses as $anons)
            <a href="{{route('post.anons', $anons->id)}}" class="main__anons-item">
                <div class="main__anons-date">
                    <p class="date">{{substr($anons->date,8, 2)}}</p>
                    <p class="month">{{substr($anons->date, 0,-3)}}</p>
                </div>
                <div class="main__anons-text">
                    <p>{{$anons->title}}</p>
                </div>
            </a> <!-- End anons-->
        @endforeach
    </div>
</div>