<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6 d-none d-md-block">
                <h1 class="m-0">
                    Dashboard
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @foreach ($paths as $index=>$p)
                    <li class="breadcrumb-item @if ($p == $path)active @endif">
                    @if ($p !== $path)
                        @php
                            $url = [];
                            while($index >-1){
                                $url[]= $paths[$index];
                                $index-=1;
                            }
                            $url = array_reverse($url);
                            $url = implode('/', $url);
                        @endphp
                        <a href="{{url($url)}}">{{Str::ucfirst($p)}}</a>
                        @else
                        {{Str::ucfirst($p)}}
                     @endif
                    </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
