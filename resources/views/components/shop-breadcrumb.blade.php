 <div class="w-full bg-gray-300 text-gray-800">
     <ol class="list-inside">
         <li class="inline">Home</li>
         <i class="inline px-2">></i>
         @foreach ($paths as $k=>$v)
         <li class="inline">
             <a href="{{$v}}">{{Str::ucfirst($k)}}</a>
         </li>
            <i class="inline px-2">></i>
         @endforeach
         <li class="inline">{{$pageTitle}}</li>
     </ol>
 </div>
