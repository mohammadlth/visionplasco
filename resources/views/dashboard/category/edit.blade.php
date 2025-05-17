@extends('layouts.dashboard')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/dashboard/css/persianDatepicker-default.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/plugins/select2/select2.min.css')}}">
@endsection
@section('body')

    <section class="card col-span-2 xl:col-span-1 p-3">
        <p class="text-md text-gray-800 py-3">
            <i class="fa fa-pen"></i>
            <span> ویرایش </span>
            <span> {{$item->title}} </span>
        </p>
        <div class="mt-3">
            <form method="post" action="{{route('categories.update' , $item->id)}}" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <input type="hidden" name="prev_url" value="{{!is_null($prev_url) ? $prev_url :  1}}">
                <div class="grid grid-cols-2 gap-5">
                    <div class="input-group">
                        <label for="title" class="text-sm text-gray-600">عنوان</label>
                        <input type="text" name="title" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('title') ? old('title') : $item->title}}" placeholder="عنوان">
                    </div>
                    <div class="input-group">
                        <label for="slug" class="text-sm text-gray-600">نامک</label>
                        <input type="text" name="slug" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('slug') ? old('slug') : $item->slug}}" placeholder="نامک">
                    </div>

                    <div class="input-group">
                        <label for="parent_id" class="text-sm text-gray-600">دسته بندی شاخه</label>
                        <select name="parent_id" class="border rounded-sm px-2 py-1 bg-gray-100 select2-category">
                            <option {{is_null($item->parent_id) ? ' selected ' : null}} value=""> سر دسته اصلی</option>
                            @foreach($categories as $value)
                                @include('components.dashboard.category.select' , ['item' => $value  ,  'selected' => $item->parent_id])
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="sort" class="text-sm text-gray-600">ترتیب قرار گیری</label>
                        <input type="number" name="sort" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('sort') ? old('sort') : $item->sort}}" placeholder="ترتیب قرار گیری">
                    </div>

                    <div class="input-group">
                        <label for="status" class="text-sm text-gray-600">وضعیت</label>
                        <select name="status" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('status') && old('status') == 0 ? ' selected ' : ($item->status == 0 ? ' selected ' : '')  }}  value="0">
                                غیر فعال
                            </option>
                            <option {{old('status') && old('status') == 1 ? ' selected ' : ($item->status == 1 ? ' selected ' : '')  }}  value="1">
                                فعال
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="placeholder" class="text-sm text-gray-600">مثال نمونه برای راهنمایی کاربر</label>
                        <input type="text" name="placeholder" class="border rounded-sm px-2 py-1 bg-gray-100"
                               value="{{old('placeholder') ? old('placeholder') : $item->placeholder}}"
                               placeholder="مثال نمونه برای راهنمایی کاربر">
                    </div>

                    <div class="input-group">
                        <label for="unit" class="text-sm text-gray-600">واحد اندازه گیری</label>
                        <select name="unit" class="border rounded-sm px-2 py-1 bg-gray-100">
                            <option {{old('unit') && old('unit') == 'کیلوگرم' ? ' selected ' : ($item->unit == 'کیلوگرم' ? ' selected ' : '')  }}  value="کیلوگرم">
                                کیلوگرم
                            </option>
                            <option {{old('unit') && old('unit') == 'گرم' ? ' selected ' : ($item->unit == 'گرم' ? ' selected ' : '')  }}  value="گرم">
                                گرم
                            </option>
                            <option {{old('unit') && old('unit') == 'عدد' ? ' selected ' : ($item->unit == 'عدد' ? ' selected ' : '')  }}  value="عدد">
                                عدد
                            </option>
                            <option {{old('unit') && old('unit') == 'کارتن' ? ' selected ' : ($item->unit == 'کارتن' ? ' selected ' : '')  }}  value="کارتن">
                                کارتن
                            </option>
                            <option {{old('unit') && old('unit') == 'جین' ? ' selected ' : ($item->unit == 'جین' ? ' selected ' : '')  }}  value="جین">
                                جین
                            </option>
                            <option {{old('unit') && old('unit') == 'شاخه' ? ' selected ' : ($item->unit == 'شاخه' ? ' selected ' : '')  }}  value="شاخه">
                                شاخه
                            </option>
                            <option {{old('unit') && old('unit') == 'مثقال' ? ' selected ' : ($item->unit == 'مثقال' ? ' selected ' : '')  }}  value="مثقال">
                                مثقال
                            </option>
                            <option {{old('unit') && old('unit') == 'راس' ? ' selected ' : ($item->unit == 'راس' ? ' selected ' : '')  }}  value="راس">
                                راس
                            </option>
                            <option {{old('unit') && old('unit') == 'نفر' ? ' selected ' : ($item->unit == 'نفر' ? ' selected ' : '')  }}  value="نفر">
                                نفر
                            </option>
                            <option {{old('unit') && old('unit') == 'لیتر' ? ' selected ' : ($item->unit == 'لیتر' ? ' selected ' : '')  }}  value="لیتر">
                                لیتر
                            </option>
                            <option {{old('unit') && old('unit') == 'گالن' ? ' selected ' : ($item->unit == 'گالن' ? ' selected ' : '')  }}  value="گالن">
                                گالن
                            </option>
                            <option {{old('unit') && old('unit') == 'بطری' ? ' selected ' : ($item->unit == 'بطری' ? ' selected ' : '')  }}  value="بطری">
                                بطری
                            </option>
                            <option {{old('unit') && old('unit') == 'شل' ? ' selected ' : ($item->unit == 'شل' ? ' selected ' : '')  }}  value="شل">
                                شل
                            </option>
                            <option {{old('unit') && old('unit') == 'مخزن' ? ' selected ' : ($item->unit == 'مخزن' ? ' selected ' : '')  }}  value="مخزن">
                                مخزن
                            </option>
                            <option {{old('unit') && old('unit') == 'پاکت' ? ' selected ' : ($item->unit == 'پاکت' ? ' selected ' : '')  }}  value="پاکت">
                                پاکت
                            </option>
                            <option {{old('unit') && old('unit') == 'بسته' ? ' selected ' : ($item->unit == 'بسته' ? ' selected ' : '')  }}  value="بسته">
                                بسته
                            </option>
                            <option {{old('unit') && old('unit') == 'متر' ? ' selected ' : ($item->unit == 'متر' ? ' selected ' : '')  }}  value="متر">
                                متر
                            </option>
                            <option {{old('unit') && old('unit') == 'بشکه' ? ' selected ' : ($item->unit == 'بشکه' ? ' selected ' : '')  }}  value="بشکه">
                                بشکه
                            </option>
                            <option {{old('unit') && old('unit') == 'تانکر' ? ' selected ' : ($item->unit == 'تانکر' ? ' selected ' : '')  }}  value="تانکر">
                                تانکر
                            </option>
                            <option {{old('unit') && old('unit') == 'کیسه' ? ' selected ' : ($item->unit == 'کیسه' ? ' selected ' : '')  }}  value="کیسه">
                                کیسه
                            </option>
                            <option {{old('unit') && old('unit') == 'گونی' ? ' selected ' : ($item->unit == 'گونی' ? ' selected ' : '')  }}  value="گونی">
                                گونی
                            </option>

                        </select>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="password" class="text-sm text-gray-600">توضیحات کوتاه</label>
                        <textarea name="short_text" rows="3" class="border rounded-sm px-2 py-1 bg-gray-100"
                                  placeholder="توضیحات کوتاه">{{$item->short_text}}</textarea>
                    </div>

                    <div class="input-group col-span-2" style="position: relative;display: block">
                        <label for="password" class="text-sm text-gray-600">توضیحات</label>
                        <textarea name="text" rows="3" class="border rounded-sm px-2 py-1 bg-gray-100 text" id="text"
                                  placeholder="توضیحات">{!! $item->text !!}</textarea>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="photo" class="text-sm text-gray-600">تصویر</label>
                        <input type="file" name="photo" class="border rounded-sm px-2 py-1 bg-gray-100"
                               placeholder="تصویر">
                        <div class="mt-2">
                            @if(!is_null($item->photo))
                                <img src="{{url($item->photo)}}" style="max-width: 250px" alt="">
                                <a href="{{route('category.pic.remove' , $item->id)}}"><i
                                            class="fa fa-times text-red-500"></i> </a>
                            @endif
                        </div>
                    </div>

                    <div class="input-group col-span-2">
                        <label for="photo" class="text-sm text-gray-600">تصویر ساب</label>
                        <input type="file" name="sub" class="border rounded-sm px-2 py-1 bg-gray-100"
                               placeholder="تصویر ساب">
                        <div class="mt-2">
                            @if(!is_null($item->sub))
                                <img src="{{url($item->sub)}}" style="max-width: 250px" alt="">
                                <a href="{{route('category.pic.remove' , $item->id)}}"><i
                                            class="fa fa-times text-red-500"></i> </a>
                            @endif
                        </div>
                    </div>

                    <div class="btn-form col-span-2">
                        <div class="flex justify-end">
                            <button class="bg-blue-800 px-4 text-sm  py-2 rounded-sm text-white" type="submit">
                                <i class="fa fa-check"></i>
                                ثبت اطلاعات
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection
@section('js')
    <script src="{{asset('assets/dashboard/js/persianDatepicker.js')}}"></script>
    <script src="{{asset('assets/dashboard/plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/ckeditor/js/ckeditor.js')}}"></script>
    <script src="{{asset('assets/ckeditor/js/fa.js')}}"></script>
    <script>
        $(function () {
            $("#date-picker").persianDatepicker({
                formatDate: "YYYY/MM/DD",
                showGregorianDate: !1,
                persianNumbers: !0,
            });
            $('.select2-category').select2();
            CKEDITOR.replace('text');

        });

        function createClickFunction() {
            return CKEDITOR.tools.addFunction( function addClickFn( color, colorName, colorbox ) {
                //editor.focus();
                editor.fire( 'saveSnapshot' );

                if ( color == '?' ) {
                    editor.getColorFromDialog( function( color ) {
                        if ( color ) {
                            setColor( color, colorName, history );
                        }
                    }, null, colorData );
                } else {
                    setColor( color && '#' + color, colorName, history );
                }

                // The colors may be duplicated in both default palette and color history. If user reopens panel
                // after choosing color without changing selection, the box that was clicked last should be selected.
                // If selection changes in the meantime, color box from the default palette has the precedence.
                // See https://github.com/ckeditor/ckeditor4/pull/3784#pullrequestreview-378461341 for details.
                if ( !colorbox ) {
                    return;
                }
                colorbox.setAttribute( 'cke_colorlast', true );
                editor.once( 'selectionChange', function() {
                    colorbox.removeAttribute( 'cke_colorlast' );
                } );
            } );
        }
    </script>
@endsection
