<div class="w-full super">
    <div class="w-full big-nav">
        @foreach ($superShopCats as $sc)
        <div class="w-full main-cat">
            <a href="{{route('shop.cat.show', $sc->slug)}}" class="block w-full">
                {{$sc->name}}
            </a>
            @if ($sc->parents->count() >0)
            <div class="absolute p-3 bg-gray-100 sub-cat">
                <div class="flex flex-col flex-wrap justify-start w-full h-full">
                    @foreach ($sc->parents as $p)
                    <div class="w-1/3 pl-3 bg-green-200">
                        <ul class="list-none">
                            <li class="font-bold text-black">
                                <a class="font-bold text-black"
                                    href="{{route('shop.cat.show', $p->slug)}}">{{$p->name}}</a>
                            </li>
                            @foreach ($p->children as $c)
                            <li>
                                <a class="text-red-700" href="{{route('shop.cat.show', $c->slug)}}">{{$c->name}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
