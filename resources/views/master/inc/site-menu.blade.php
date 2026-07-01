
@php
  
    $links = json_decode($menus->menus, true);
    $isHomePage = request()->routeIs('front.index');
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
    ];
    $homeMenuLabel = fn ($text) => $isHomePage ? ($homeMenuText[$text] ?? $text) : $text;
 
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
