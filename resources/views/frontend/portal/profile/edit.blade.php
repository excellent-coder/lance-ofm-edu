@extends('layouts.portal')

@section('content')
<div class="container w-full">
    <div class="px-2 w-full flex justify-center">
        <div class="w-full lg:w-3/4">
            <h1 class="mt-2 mb-4 text-2xl font-black">
                Update your profile details below
            </h1>
            <div class=" flex flex-wrap w-full mb-11">
                @if ($profile)
                    <u-button title="edit" class="sticky top-0 left-full z-10"
                    id="toggle-edit" @click.prevent="editPage(true)">
                       <i class="fas fa-edit"></i>
                    </u-button>
                @endif
                <form
                action="{{route('portal.profile.update')}}"
                class=" w-full" method="POST" autocomplete="off"
                @submit.prevent="submit($event)">
                    <u-input placeholder="first name" name="first_name"
                    with-icon label="First Name" model-value="{{$profile?$profile->first_name:''}}">
                        <template #icon>
                            <i class="fas fa-home"></i>
                        </template>
                    </u-input>
                    <u-input placeholder="middle name" name="middle_name"  model-value="{{$profile?$profile->middle_name:''}}"
                     with-icon label="Middle Name">
                        <template #icon>
                            <i class="fas fa-home"></i>
                        </template>
                    </u-input>

                    <u-input placeholder="Last name" name="last_name"
                    with-icon model-value="{{$profile?$profile->last_name:''}}"
                    label="Last Name">
                        <template #icon>
                            <i class="fas fa-home"></i>
                        </template>
                    </u-input>

                    <div class="block relative mb-7">
                        <input
                            type="hidden"
                            name="country_id"
                            :value="form.country_id"
                            autocomplete="off"
                        />
                        <label>Your Country</label>
                        <multi-select
                            v-model="country"
                            :options="countries"
                            :show-labels="false"
                            :custom-label="countryLabel"
                            label="name"
                            track-by="id"
                            autocomplete="off"
                            :clear-on-select="false"
                            placeholder="Choose Country"
                            :close-on-select="true"
                            :disabled="!isEditing"
                            @select="selected($event, 'country')"
                            @remove="removed('country')"
                        />
                    </div>
                    <div class="block relative mb-7">
                        <input
                            type="hidden"
                            name="state_id"
                            :value="form.state_id"
                            autocomplete="off"
                        />
                        <label>Your State</label>
                        <multi-select
                            v-model="state"
                            :options="states"
                            :disabled="!country || !countries.length || !isEditing"
                            :show-labels="false"
                            :custom-label="stateLabel"
                             autocomplete="off"
                            label="name"
                            track-by="id"
                            :clear-on-select="false"
                            placeholder="Choose Statey"
                            :close-on-select="true"
                            class="input-element"
                            @select="selected($event, 'state')"
                            @remove="removed('state')"
                        />
                    </div>

                     <u-input placeholder="city" name="city" model-value="{{$profile?$profile->city:''}}"
                     with-icon label="city">
                        <template #icon>
                            <i class="fas fa-address-book"></i>
                        </template>
                    </u-input>

                     <u-input placeholder="street address" name="street" model-value="{{$profile?$profile->street:''}}"
                      with-icon label="street">
                        <template #icon>
                            <i class="fas fa-address-book"></i>
                        </template>
                    </u-input>

                     <u-input placeholder="phone" name="phone" model-value="{{$profile?$profile->phone:''}}"
                      with-icon label="Phone" max-length="20">
                        <template #icon>
                            <i class="fas fa-phone-volume"></i>
                        </template>
                    </u-input>

                     <u-input placeholder="profile picture" id="image" name="photo" with-icon label="{{$profile?'Change Photo':'Profile Photo'}}"
                     type="file" accept="image/*">
                        <template #icon>
                            <i class="fas fa-paperclip"></i>
                        </template>
                    </u-input>

                    <div class=" block text-center">
                    <u-button type="submit" class="input-element">
                        update
                    </u-button>
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>
@endsection
@section('js')
    <script>
        function toggleDisabled(eleClass){
            console.log('i have started');
          var input=  document.querySelectorAll(eleClass);
          if(input[0].hasAttribute('disabled')){
              console.log('removing disabled');
              input.forEach(el=>{
                  el.removeAttribute('disabled');
              })
          }else{
              console.log('adding disbaled')
              input.forEach(el=>{
                    el.setAttribute('disabled', true);
              })

          }
        }

        document.getElementById('toggle-edit')
        .addEventListener('click', (e)=>{
            toggleDisabled('.input-element');
            }
        );

        @if ($profile)
        console.log('what is happening');
            toggleDisabled('.input-element');
        @endif
    </script>
@endsection
