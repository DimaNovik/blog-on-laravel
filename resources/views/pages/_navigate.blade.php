<div class="header__nav_bg">
    <div class="container">
        <div class="header__nav_mob">
            <a href="/" class="logo">
                <img src="/images/main-logo.png" alt="Нотаріат одеської області" class="logo">
            </a>
            <div class="burger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <nav class="header__nav">

            <ul class="header__list">
                @foreach($menu->where('parent', 0) as $parent_item)
                    <li class="header__list-item">
                        <a href="{{ $parent_item->link }}" class="link">{{ $parent_item->title }}</a>
                        @php
                            $children = $menu->where('parent', $parent_item->id);
                        @endphp
                        @if(!$children->isEmpty())
                            <ul class="header__down">
                                @foreach($children as $child)
                                    <li><a href="/{{ $child->link }}" class="link">{{ $child->title }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>

        </nav>
    </div>
</div>