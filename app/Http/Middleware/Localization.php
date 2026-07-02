<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isShopPage = $request->routeIs([
            'front.catalog', 'front.catalog.view', 'front.product',
            'front.cart', 'front.cart.*', 'cart.*', 'product.*',
            'front.checkout', 'front.checkout.*', 'front.shipping.*', 'front.state.*',
            'fornt.compare.*', 'front.compare.*', 'user.wishlist.*', 'user.order.*',
        ]);

        if (!$isShopPage) {
            app('translator')->addLines([
                '*.Home' => 'হোম',
                '*.Blog' => 'ব্লগ',
                '*.Blog Details' => 'ব্লগের বিস্তারিত',
                '*.Admin' => 'প্রশাসক',
                '*.Tags :' => 'ট্যাগ:',
                '*.Share' => 'শেয়ার করুন',
                '*.Search blog' => 'ব্লগ খুঁজুন',
                '*.Blog Categories' => 'ব্লগের বিভাগ',
                '*.Most Recent Added Posts' => 'সাম্প্রতিক পোস্ট',
                '*.Popular Tags' => 'জনপ্রিয় ট্যাগ',
                '*.by' => 'লিখেছেন',
                '*.No Data Found' => 'কোনো তথ্য পাওয়া যায়নি',
                '*.FAQ' => 'প্রশ্নোত্তর',
                '*.Faq' => 'প্রশ্নোত্তর',
                '*.View Details' => 'বিস্তারিত দেখুন',
                '*.Campaign Product' => 'প্রচারাভিযানের পণ্য',
                '*.Campaign Products' => 'প্রচারাভিযানের পণ্যসমূহ',
                '*.out of stock' => 'স্টক শেষ',
                '*.Contact' => 'যোগাযোগ',
                '*.Contact Us' => 'যোগাযোগ করুন',
                '*.Working Days' => 'কর্মদিবস',
                '*.Monday-Friday' => 'সোমবার–শুক্রবার',
                '*.Saturday' => 'শনিবার',
                '*.Store address' => 'ঠিকানা',
                '*.Our address information' => 'আমাদের ঠিকানার তথ্য',
                '*.Tell Us Your Message :' => 'আপনার বার্তা লিখুন:',
                '*.First Name' => 'নামের প্রথম অংশ',
                '*.Last Name' => 'নামের শেষ অংশ',
                '*.E-mail' => 'ই-মেইল',
                '*.Phone' => 'ফোন',
                '*.Message' => 'বার্তা',
                '*.Write your message here...' => 'এখানে আপনার বার্তা লিখুন...',
                '*.Send message' => 'বার্তা পাঠান',
                '*.Track Order' => 'অর্ডার ট্র্যাক করুন',
                '*.Compare' => 'তুলনা',
                '*.Wishlist' => 'পছন্দের তালিকা',
                '*.Currency' => 'মুদ্রা',
                '*.Login' => 'লগইন',
                '*.Logout' => 'লগআউট',
                '*.Dashboard' => 'ড্যাশবোর্ড',
                '*.Page' => 'পৃষ্ঠা',
            ], 'bn');
            App::setLocale('bn');
            return $next($request);
        }

        if(Session::has('language')){
            $language = Language::find(Session::get('language'));
        }else{
            $language = Language::whereType('Website')->where('is_default',1)->first();
        }
        if(!$language){
            $language = Language::whereType('Website')->where('is_default',1)->first();
        }
        App::setlocale($language->name);
        return $next($request);
    }
}
