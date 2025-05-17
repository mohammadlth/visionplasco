<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\CheckDomains\DomainsExist;

class DomainController extends Controller
{
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'domain' => ['required', 'min:4', 'max:20'],
            'suffix' => ['required', 'numeric', 'exists:domain_suffixes,id'],
            'website_id' => ['required', 'numeric', 'exists:websites,id'],
        ])->validate();

        $suffix = DB::table('domain_suffixes')->where('id', $request->suffix)->first();

        if (is_null($suffix)) {
            return redirect()->back()->with('error_message', 'پسوند دامنه یافت نشد');
        }

        $domain_name = $request->domain . '.' . $suffix->title;


        /** check website exist and for user */
        $website = Website::where('user_id', Auth::id())->where('id', $request->website_id)->first();


        if (is_null($website)) {
            return redirect()->back()->with('error_message', 'وب سایت یافت نشد');
        }

        /** check not trial */
        if ($website->trial == 1) {
            return redirect()->back()->with('error_message', 'کاربر گرامی امکان ثبت دامنه بر روی نسخه آزمایشی وجود ندارد - لطفا ابتدا یکی از پلن های موجود را انتخاب کنید');
        }


        /** check exist in domain */
        $domain = Domain::where('address', $domain_name)->first();

        if (!is_null($domain)) {
            return redirect()->back()->with('error_message', 'این دامنه قبلا در سیستم ثبت شده است');
        }

        /** check domain set for website */

        $domain_set = Domain::where('website_id', $website->id)->first();

        if (!is_null($domain_set)) {
            return redirect()->back()->with('error_message', 'برای این وب سایت قبلا دامنه ای ثبت شده است لطفا برای تغییر دامنه با پشتیبانی در ارتباط باشید');
        }


        /** check domain available */

        $whois = new DomainsExist();
        $allow = $whois->check($domain_name);

        if (!$allow['success']) {
            return redirect()->back()->with('error_message', $allow['message']);
        }


        if ($allow['available'] == 0) {
            return redirect()->back()->with('error_message', 'کاربر گرامی این دامنه قبلا توسط شما یا شخص دیگری خریداری شده است  - اگر دامنه متعلق به شما میباشد با پشتیبانی در ارتباط باشید');
        }
        $user = Auth::user();

        /** check balance */
        if ($user->balance->balance < $suffix->price) {
            return redirect()->back()->with('error_message', 'کاربر گرامی موجودی کیف پول شما کافی نیست . لطفا ابتدا اقدام به شارژ کیف پول خود کنید');
        }

        /** balance down */

        try {

            $user->balance->balance = $user->balance->balance - $suffix->price;
            $user->balance->save();

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error_message', 'خطا در پردازش با پشتیبانی تماس حاصل فرمایید');
        }


        try {
            $item = new Domain();
            $item->address = $domain_name;
            $item->suffix_id = $suffix->id;
            $item->status = 0;
            $item->website_id = $website->id;
            $item->user_id = Auth::id();
            $item->save();

            return redirect()->back()->with('success_message', 'درخواست شما با موفقیت ثبت شد و در بخش تیکت میتوانید اقدام به پیگیری درخواست خود کنید');

        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'خطای سیستمی با پشتیبانی در ارتباط باشید');

        }


    }

}
