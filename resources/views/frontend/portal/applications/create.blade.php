@extends('layouts.portal')

@section('content')
<div class="container w-full">
    <div class="px-2 w-full flex justify-center">
        <div class="w-full lg:w-3/4">
            <h1 class="mt-2 mb-4 text-2xl font-black">
                Apply for {{$cat->name}}
            </h1>
            <div class=" flex flex-wrap w-full mb-11">
                <form
                action="{{route('portal.applications.store')}}"
                class=" w-full" method="POST" autocomplete="off"
                @submit.prevent="submit($event)">
                    <u-input placeholder="full name" disabled
                    with-icon label="Full Name" model-value="{{Auth::user()->name}}">
                        <template #icon>
                            <i class="fas fa-user-circle"></i>
                        </template>
                    </u-input>

                    @if($categories->count() ==0)
                    <h1 class=" text-2xl font-semibold mb-2">You are about applying for
                        <span class="text-xl text-blue-700 font-black">
                            {{$cat->name}}
                        </span>
                            </h1>
                    <h2 class=" font-semibold text-xl mb-2">
                        Click the apply below to proceed
                    </h2>
                    <input type="hidden" name="cat_id" value="{{$cat->id}}">
                    @else
                    <div class="block relative mb-7">
                        <h2 class="my-3 font-bold text-xl">
                            Choose below the category you want to apply for
                        </h2>
                        <input
                            type="hidden"
                            name="cat_id"
                            :value="form.cat_id"
                            autocomplete="off"
                        />
                        <label>Category</label>
                        <multi-select
                            v-model="country"
                            :options="{{$categories}}"
                            :show-labels="false"
                            label="name"
                            track-by="id"
                            autocomplete="off"
                            :clear-on-select="false"
                            placeholder="Choose category"
                            :close-on-select="true"
                            @select="($event) => (form.cat_id = $event.id)"
                            @remove="($event) => (form.cat_id = '')"
                        />
                    </div>
                    @endif


                    <div class=" block text-center">
                    <u-button type="submit" class="input-element">
                        Apply
                    </u-button>
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>
@endsection
@section('js')

@endsection
