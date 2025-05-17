<div class="comment bg-gray-100  rounded-md  border-gray-200 p-3">
    <div class="pb-1 flex justify-between items-center">
        <p>
            <i class="fa fa-user text-gray-500 ml-1 text-xs"></i>
            <span class="text-xs"> {{$comment->user ? $comment->user->name : 'نامعلوم' }} </span>
        </p>
        <p class="text-[11px] text-gray-400">
            {{verta($comment->created_at)->formatDifference()}}
        </p>
    </div>
    <div class="mt-1 detail">
        @for($i = 0;$i < $comment->rate;$i++)
            <i class="fa fa-star text-yellow-500 text-sm"></i>
        @endfor
        @for($i = 0;$i < 5 - $comment->rate;$i++)
            <i class="fal fa-star text-yellow-500 text-sm"></i>
        @endfor
        <p class="mt-2 text-gray-800 text-sm">{{$comment->text}}</p>
    </div>
</div>
