<div class="card card-template  rounded-md border-2 border-dashed p-3 border-gray-300">

    <a href="{{route('template.show' , $template->slug)}}">
        @if($template->photo)
            <div class="photo-template">
                <img src="{{url($template->photo)}}"
                     class="max-w-full shadow-md rounded-md"
                     alt="{{$template->title}}"/>
            </div>
        @endif
        <div class="detail mt-3">
            <h5 class="text-md font-semibold text-gray-900">
                {{$template->title}}
            </h5>
            <p class="mt-2 text-gray-500 text-sm leading-8">
                {{mb_strimwidth($template->short_text , 0 , 140, '....')}}
            </p>
        </div>
    </a>
    <div class="card-footer  flex gap-2 mt-5">
        <a target="_blank"
           class="bg-sky-500 text-white  px-3 py-2 text-sm w-full justify-center flex items-center gap-2 rounded-sm"
           href="{{route('template.frame' , $template->slug)}}">
            <i class="fal fa-eye"></i>
            پیش نمایش
        </a>
        <button onclick="openModal({{$template->id}} , '{{$template->title}}')"
                class="bg-indigo-500 text-white px-3 py-2 text-sm w-full justify-center flex items-center gap-2 rounded-sm">
            <i class="fal fa-plus-circle"></i>
            ساخت سایت
        </button>
    </div>
</div>
