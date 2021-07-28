<div class="super w-full">
    <div class="big-nav w-full">
        @foreach ($superShopCats as $sc)
        <div class="main-cat w-full">
            <a href="{{route('shop.cat.show', $sc->slug)}}" class="block w-full">
                {{$sc->name}}
            </a>
            @if ($sc->parents->count() >0)
                <div class="sub-cat p-3 absolute bg-gray-100">
                        <div class="w-full flex-wrap flex">
                    @foreach ($sc->parents as $p)
                        <ul class="list-none w-1/3">
                            <li class="font-bold text-black">
                                <a class="font-bold text-black" href="{{route('shop.cat.show', $p->slug)}}">{{$p->name}}</a>
                            </li>
                            @foreach ($p->children as $c)
                            <li>
                                <a class="text-red-700" href="{{route('shop.cat.show', $c->slug)}}">{{$c->name}}</a>
                            </li>
                            @endforeach
                        </ul>
                    @endforeach
                        </div>
                </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
