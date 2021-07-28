<div class="w-full h-10 bg-pink-700">
      <span class="push lg:hidden cursor-pointer text-gray-800" @click.prevent="toggleNav('portal-sidebar')">
            <i class="fas fa-bars"></i>
            {{-- <i class="fas fa-times "></i> --}}
        </span>
    {{$testing??'big menu'}}
</div>
