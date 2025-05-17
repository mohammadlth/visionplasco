<div class="info-website text-center mt-3">
    <p class="text-green-500 text-lg font-semibold">🎉 تبریک 🎉 وب سایت شما با موفقیت ایجاد شد </p>
    <div class="mt-5">
        <a rel="nofollow,noindex" target="_blank" class="bg-green-500 rounded-md text-white px-3 py-2 text-sm" href="{{$website->url}}">
            مشاهده وب
            سایت </a>
    </div>
    <div class="mt-5">
        <a rel="nofollow,noindex" class="bg-custom-900 rounded-md text-white px-3 py-2 text-xs"
           href="{{$website->url}}">
            ورود به پیشخوان وب سایت
        </a>
    </div>
    <div class="grid text-md grid-cols-2 bg-gray-200 rounded-full gap-3 w-full mt-5 justify-center">
        <div class="flex justify-center items-center p-3">
            <span class="mx-1"> نام کاربری :  </span>
            <b> {{$website->user_panel}} </b>
        </div>
        <div class="flex justify-center items-center p-3">
            <span class="mx-1"> رمز عبور :  </span>
            <b> {{$website->password_panel}} </b>
        </div>
    </div>
</div>
