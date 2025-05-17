<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Meta;
use App\Models\Page;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {
        Paginator::useTailwind();


        view()->composer('layouts.front', function ($view) use ($request) {

            $categories = Category::where('parent_id', null)->where('status', 1)->orderBy('sort', 'asc')->get();

            $instagram = DB::table('settings')->where('key', 'instagram')->first();
            $whatsapp = DB::table('settings')->where('key', 'whatsapp')->first();
            $telegram = DB::table('settings')->where('key', 'telegram')->first();
            $twitter = DB::table('settings')->where('key', 'twitter')->first();
            $footer_text = DB::table('settings')->where('key', 'footer_text')->first();

            $pages_r = Page::where('for', 1)->where('status', 1)->orderBy('sort')->get();
            $pages_b = Page::where('for', 2)->where('status', 1)->orderBy('sort')->get();



            $meta = Meta::where('path', $request->path())->first();


            $view->with(['meta' => $meta, 'full_url' => url($request->path()), 'page_r' => $pages_r, 'page_b' => $pages_b, 'categories' => $categories, 'instagram' => $instagram, 'whatsapp' => $whatsapp, 'telegram' => $telegram, 'twitter' => $twitter, 'footer_text' => $footer_text]);

        });

        view()->composer('layouts.panel', function ($view) use ($request) {


            $view->with(['full_url' => url($request->path())]);

        });

        view()->composer('layouts.dashboard', function ($view) use ($request) {

            $user = Auth::user();

            if (!is_null($user->admin_permission)) {
                $permission = json_decode($user->admin_permission);
            } else {
                $permission = [];
            }

            $view->with(['full_url' => url($request->path()), 'permission' => $permission]);

        });


    }
}
