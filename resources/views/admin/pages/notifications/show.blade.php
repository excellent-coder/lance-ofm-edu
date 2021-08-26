@extends('layouts.admin')

@section('css')
<style>
    .reply{
        border-left: 2px solid red;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <x-admin-card-tool :title="$notice->subject">
                <a href="{{route('admin.notifications.create')}}" class="text-white btn btn-success btn-sm">
                    New Notification
                </a>
            </x-admin-card-tool>
            <div class="card-body ">
                <div class="row">
                    <div class="my-3 col-12" style="background-color: indigo;">
                        <div class="row justify-content-end">
                            <a href="{{route('admin.notifications.create')}}" class="btn btn-success">
                                New Notification
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-6 offset-lg-3 offset-md-2">
                                <h1 class="p-3 bg-gradient-primary">
                                    {{$notice->subject}}
                                </h1>
                                <div class="my-3 html">
                                    {!! $notice->body !!}
                                </div>

                                <div>
                                    <h1 class="my-4 text-center bg-gradient-purple text-uppercase">Replies</h1>
                                        @foreach ($notice->replies as $r)
                                    <div class="pl-3 mb-3 reply">
                                        @php
                                            $usertable  = $r->usertable;
                                            $usermodel ="\App\Models\\$usertable->model";
                                            $user = $usermodel::find($r->sender_id);
                                        @endphp
                                            <div>
                                                <h3>{{$user->name}}</h3>
                                                <small class="text-right d-block">
                                                    {{rtrim($usertable->title, 's')}}
                                                </small>
                                            </div>
                                            <div>
                                                {!! $r->body !!}
                                            </div>
                                            <p class="text-right text-muted">{{$r->created_at}}</p>
                                    </div>
                                        @endforeach
                                </div>

                                <div class="my-5">
                                    <form @submit.prevent="submit($event)"
                                        action="{{route('admin.notifications.reply',['notice'=> $notice->id, 'model'=>$model->id])}}">
                                        <div class="form-group">
                                            <input type="hidden" name="gd" value="">
                                            <label for="body">Reply</label>
                                            <textarea id="body" class="form-control tinymce required" name="body" rows="3"
                                                placeholder="reply"></textarea>
                                        </div>
                                        <div class="my-3 text-right form-group">
                                            <button type="submit" class="btn btn-primary">
                                                Reply
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="/vendor/tinymce/tinymce.min.js"></script>
@endsection
