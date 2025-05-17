<form class="mt-3" method="post" action="{{route('comment.store')}}">
    <p class="text-center text-gray-500"> به کاربر چه امتیازی میدهید </p>
    <div class="rate flex gap-1 items-center justify-center">
        <i data-value="1"
           class="val-1 fa text-lg fa-star text-gray-300 start-set cursor-pointer"></i>
        <i data-value="2"
           class="val-2 fa text-lg fa-star text-gray-300 start-set cursor-pointer"></i>
        <i data-value="3"
           class="val-3 fa text-lg fa-star text-gray-300 start-set cursor-pointer"></i>
        <i data-value="4"
           class="val-4 fa text-lg fa-star text-gray-300 start-set cursor-pointer"></i>
        <i data-value="5"
           class="val-5 fa text-lg fa-star text-gray-300 start-set cursor-pointer"></i>
    </div>
    <input type="hidden" name="rate" value="">
    <div class="dropdown-store-comment hidden">
        @if(Auth::check())
            @csrf
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <div class="form-control mt-3">
                                            <textarea name="text"
                                                      class="border border-1 border-gray-300 rounded-md w-full p-3 text-sm leading-8"
                                                      rows="3" placeholder="نظر خود را بنویسید (اختیاری)"></textarea>
            </div>

            <div class="mt-2">
                <button type="submit"
                        class="bg-blue-500 px-2 py-2 text-center text-white w-full text-sm rounded-md">
                    ثبت نظر
                </button>
            </div>
        @else
            <div class="mt-2">
                <a href="{{route('login')}}" type="submit"
                   class="bg-blue-500 px-2 py-2 text-center text-white w-full text-sm rounded-md">
                    برای ثبت نظر وارد شوید یا ثبت نام کنید
                </a>
            </div>
        @endif
    </div>
</form>
