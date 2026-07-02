
@php
  
    $links = json_decode($menus->menus, true);
    $isShopPage = request()->routeIs([
        'front.catalog', 'front.catalog.view', 'front.product',
        'front.cart', 'front.cart.*', 'cart.*', 'product.*',
        'front.checkout', 'front.checkout.*', 'front.shipping.*', 'front.state.*',
        'fornt.compare.*', 'front.compare.*', 'user.wishlist.*', 'user.order.*',
    ]);
    $useBanglaUi = !$isShopPage;
    $homeMenuText = [
        'Home' => 'হোম',
        'About Us' => 'আমাদের সম্পর্কে',
        'Shop' => 'দোকান',
        'Campaign' => 'প্রচারাভিযান',
        'Activity' => 'কার্যক্রম',
        'News' => 'সংবাদ',
        'Blog' => 'ব্লগ',
        'Pages' => 'পেজ',
        'Contact' => 'যোগাযোগ',
        'Faq' => 'প্রশ্নোত্তর',
        'FAQ' => 'প্রশ্নোত্তর',
        'Brand' => 'ব্র্যান্ড',
        'How It Works' => 'আমরা যেভাবে কাজ করি',
        'Privacy Policy' => 'গোপনীয়তা নীতি',
        'Terms & Service' => 'শর্তাবলি ও সেবা',
        'Return Policy' => 'ফেরত নীতি',
    ];
    $homeMenuLabel = fn ($text) => $useBanglaUi ? ($homeMenuText[$text] ?? $text) : $text;
 
@endphp

<nav class="site-menu">
    <ul>
      
        @foreach ($links as $link)
            @php
             $href = Helper::getHref($link); 
            
            @endphp

            @if (!array_key_exists("children",$link))
                <li class="@if($href == URL::current() ) active  @endif">
                    <a href="{{ $link["href"] == null ? $href : $link["href"] }}" target="{{$link["target"]}}">{{ $homeMenuLabel($link["text"]) }}</a>
                </li>
            @else
                <li class="t-h-dropdown">
                    <a class="main-link" href="{{$href}}" {{$link["target"]}}>{{ $homeMenuLabel($link["text"]) }}<i class="icon-chevron-down"></i></a>

                    <div class="t-h-dropdown-menu">
                        @foreach ($link["children"] as $level2)

                        @php
                            $l2Href = Helper::getHref($level2);
                            
                        @endphp
                        
                        <a class="@if($l2Href == URL::current() ) active  @endif" href="{{$l2Href}}" target="{{$level2["target"]}}">
                            <i class="icon-chevron-right pr-2"></i>
                            {{ $homeMenuLabel($level2["text"]) }}
                        </a>
                        @endforeach
                    </div>

                </li>
            @endif

        @endforeach
    </ul>
</nav>
