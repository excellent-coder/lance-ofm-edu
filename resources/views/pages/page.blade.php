@extends('layouts.app')
@section('content')
<div class="container">
    <div class="grid">
        <div>
            <h1>{{$page->title}}</h1>
        </div>
        <div>
            {!! $page->body !!}
        </div>
    </div>
</div>
@endsection
