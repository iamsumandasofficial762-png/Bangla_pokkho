@extends('master.front')

@section('hometitle')
    {{ $setting->home_page_title }}
@endsection

@section('pagestyles')
    <link rel="stylesheet"
        href="{{ url('css/homepage-blog.css') }}?v={{ filemtime(public_path('css/homepage-blog.css')) }}">
    <link rel="stylesheet"
        href="{{ url('css/homepage-latest-blog.css') }}?v={{ filemtime(public_path('css/homepage-latest-blog.css')) }}">
@endsection

@section('content')
    @php
        $recentSection = $homeSections['recent_blog'] ?? [];
        $aboutSection = $homeSections['about_section'] ?? [];
        $heritageSection = $homeSections['heritage_cards'] ?? [];
        $carouselSection = $homeSections['blog_carousel'] ?? [];
        $faqSection = $homeSections['faq_section'] ?? [];
        $latestSection = $homeSections['all_blog_section'] ?? [];

        $imageName = function ($name, $fallback = 'placeholder.png') {
            if (!$name || !file_exists(public_path('storage/images/' . $name))) {
                return $fallback;
            }
            return $name;
        };
    @endphp

    @if (!empty($recentSection['enabled']))
        <main class="recent-blog-home">
            <div class="container">
                <section class="home-hero-slider" data-home-hero-slider
                    aria-label="হোম ব্যানার" aria-roledescription="carousel">
                    <div class="home-hero-track">
                        <article class="home-hero-slide is-active" data-home-hero-slide aria-hidden="false">
                            <img src="{{ asset('storage/images/slider-3.png') }}"
                                alt="বাংলা পক্ষ ব্যানার"
                                fetchpriority="high">
                            <span class="home-hero-overlay" aria-hidden="true"></span>
                            <div class="home-hero-content">
                                <h2 class="home-hero-title">বাংলার ভবিষ্যৎ গড়ার পথে</h2>
                                <p class="home-hero-highlight">একসঙ্গে বাংলা, শক্তিশালী বাংলা</p>
                                <p class="home-hero-description">আমরা বিশ্বাস করি, ভাষা আমাদের পরিচয়, সংস্কৃতি আমাদের আত্মা, আর অধিকার আমাদের শক্তি।<br>একসাথে এগিয়ে চলি ন্যায়, মর্যাদা ও সমৃদ্ধির বাংলার জন্য।</p>
                                <a class="home-hero-btn" href="{{ route('front.page', 'about-us') }}">
                                    আমাদের সাথে যুক্ত হন <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </article>
                        <article class="home-hero-slide" data-home-hero-slide aria-hidden="true">
                            <img src="{{ asset('storage/images/slider-1.png') }}"
                                alt="বাংলা পক্ষ ব্যানার"
                                loading="lazy">
                            <span class="home-hero-overlay" aria-hidden="true"></span>
                            <div class="home-hero-content">
                                <h2 class="home-hero-title">বাঙালির ঐক্য ও আত্মপরিচয়</h2>
                                <p class="home-hero-highlight">নিজের ভাষা, নিজের অধিকার</p>
                                <p class="home-hero-description">বাংলা ও বাঙালির স্বার্থ রক্ষায় আমরা সচেতনতা, সংগঠন এবং সামাজিক দায়িত্ব নিয়ে কাজ করি।</p>
                                <a class="home-hero-btn" href="{{ route('front.page', 'about-us') }}">
                                    আরও জানুন <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </article>
                        <article class="home-hero-slide" data-home-hero-slide aria-hidden="true">
                            <img src="{{ asset('storage/images/slider-2.png') }}"
                                alt="বাংলা পক্ষ ব্যানার"
                                loading="lazy">
                            <span class="home-hero-overlay" aria-hidden="true"></span>
                            <div class="home-hero-content">
                                <h2 class="home-hero-title">বাংলার ভবিষ্যৎ গড়ার পথে</h2>
                                <p class="home-hero-highlight">ঐক্যবদ্ধ বাঙালি, শক্তিশালী বাংলা</p>
                                <p class="home-hero-description">নতুন প্রজন্মের কাছে বাংলা ভাষা, সংস্কৃতি ও অধিকারকে আরও দৃঢ়ভাবে পৌঁছে দেওয়াই আমাদের লক্ষ্য।</p>
                                <a class="home-hero-btn" href="{{ route('front.page', 'about-us') }}">
                                    আরও জানুন <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </article>
                    </div>

                    <button class="home-hero-arrow home-hero-arrow--prev" type="button"
                        data-home-hero-prev aria-label="আগের ব্যানার">
                        <i class="fas fa-chevron-left" aria-hidden="true"></i>
                    </button>
                    <button class="home-hero-arrow home-hero-arrow--next" type="button"
                        data-home-hero-next aria-label="পরের ব্যানার">
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    </button>

                    <div class="home-hero-dots" aria-label="ব্যানার নির্বাচন">
                        <button class="is-active" type="button" data-home-hero-dot="0"
                            aria-label="প্রথম ব্যানার" aria-current="true"></button>
                        <button type="button" data-home-hero-dot="1"
                            aria-label="দ্বিতীয় ব্যানার" aria-current="false"></button>
                        <button type="button" data-home-hero-dot="2"
                            aria-label="তৃতীয় ব্যানার" aria-current="false"></button>
                    </div>

                    <div class="home-hero-values" aria-label="বাংলা পক্ষের মূল্যবোধ">
                        <div class="home-hero-value">
                            <span class="home-hero-value-icon"><i class="fas fa-users" aria-hidden="true"></i></span>
                            <div><strong>একতা</strong><small>বাঙালির ঐক্যই আমাদের সবচেয়ে বড় শক্তি</small></div>
                        </div>
                        <div class="home-hero-value">
                            <span class="home-hero-value-icon"><i class="fas fa-book-open" aria-hidden="true"></i></span>
                            <div><strong>ভাষা</strong><small>বাংলা ভাষার সম্মান রক্ষা আমাদের দায়িত্ব</small></div>
                        </div>
                        <div class="home-hero-value">
                            <span class="home-hero-value-icon"><i class="fas fa-fist-raised" aria-hidden="true"></i></span>
                            <div><strong>অধিকার</strong><small>ন্যায্য অধিকার আদায়ে আমরা সোচ্চার ও অটল</small></div>
                        </div>
                        <div class="home-hero-value">
                            <span class="home-hero-value-icon"><i class="fas fa-seedling" aria-hidden="true"></i></span>
                            <div><strong>সংস্কৃতি</strong><small>বাংলার সংস্কৃতি ও ঐতিহ্য আমাদের গর্ব</small></div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    @endif

    @if (!empty($aboutSection['enabled']))
        @php
            $aboutMainImage = $imageName($aboutSection['main_image'] ?? null);
        @endphp

        <section class="about-pokkho-section" aria-labelledby="about-pokkho-title">
            <div class="container">
                <div class="about-pokkho-layout">
                    <div class="about-pokkho-visual">
                        <div class="about-pokkho-image-frame">
                            <img src="{{ url('storage/images/' . $aboutMainImage) }}"
                                alt="{{ $aboutSection['subtitle'] ?? 'বাংলা পক্ষ সম্পর্কে' }}">
                        </div>
                    </div>

                    <div class="about-pokkho-content">
                        <div class="about-pokkho-label text-primary">
                            <span aria-hidden="true"></span>{{ $aboutSection['subtitle'] ?? 'বাংলা পক্ষ সম্পর্কে' }}
                        </div>
                        <h2 id="about-pokkho-title">{{ $aboutSection['heading'] ?? 'বাঙালি পরিচয়, ভাষা ও অধিকারের পক্ষে আমরা' }}</h2>
                        <p class="about-pokkho-intro">{{ $aboutSection['description'] ?? '' }}</p>

                        <div class="about-pokkho-tabs" role="tablist"
                            aria-label="{{ $aboutSection['subtitle'] ?? 'বাংলা পক্ষ সম্পর্কে' }}">
                            @foreach (($aboutSection['tabs'] ?? []) as $tabIndex => $tab)
                                @php $tabKey = $tab['key'] ?? 'tab-' . $tabIndex; @endphp
                                <button class="about-pokkho-tab {{ $tabIndex === 0 ? 'is-active text-primary' : '' }}"
                                    type="button" role="tab" id="about-tab-{{ $tabKey }}"
                                    aria-controls="about-panel-{{ $tabKey }}"
                                    aria-selected="{{ $tabIndex === 0 ? 'true' : 'false' }}"
                                    {{ $tabIndex === 0 ? '' : 'tabindex=-1' }}
                                    data-about-tab="{{ $tabKey }}">{{ $tab['name'] ?? '' }}</button>
                            @endforeach
                        </div>

                        <div class="about-pokkho-panels">
                            @foreach (($aboutSection['tabs'] ?? []) as $tabIndex => $tab)
                                @php
                                    $tabKey = $tab['key'] ?? 'tab-' . $tabIndex;
                                    $tabImage = $imageName($tab['image'] ?? null);
                                @endphp
                                <div class="about-pokkho-panel {{ $tabIndex === 0 ? 'is-active' : '' }}"
                                    id="about-panel-{{ $tabKey }}" role="tabpanel"
                                    aria-labelledby="about-tab-{{ $tabKey }}" data-about-panel="{{ $tabKey }}"
                                    {{ $tabIndex === 0 ? '' : 'hidden' }}>
                                    <img src="{{ url('storage/images/' . $tabImage) }}"
                                        alt="{{ $tab['title'] ?? $tab['name'] ?? '' }}">
                                    <div>
                                        <p>{{ $tab['description'] ?? '' }}</p>
                                        <ul>
                                            @foreach (($tab['bullets'] ?? []) as $bullet)
                                                <li><span class="text-primary" aria-hidden="true">&#10003;</span>{{ $bullet }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (!empty($heritageSection['enabled']))
        @include('front.includes.heritage-community', ['heritageSection' => $heritageSection])
    @endif

    @if (!empty($latestSection['enabled']))
        @include('front.includes.home-latest-blog', [
            'latestBlogs' => $latestBlogs,
            'latestSection' => $latestSection,
        ])
    @endif

    @if (!empty($faqSection['enabled']))
        @include('front.includes.home-faq', ['faqSection' => $faqSection])
    @endif

    @if (!empty($carouselSection['enabled']) && $carouselPosts->isNotEmpty())
        @include('front.includes.home-blog-carousel', [
            'posts' => $carouselPosts,
            'carouselSection' => $carouselSection,
        ])
    @endif
@endsection

@section('script')
    <script src="{{ url('js/homepage-about.js') }}"></script>
    <script src="{{ url('js/homepage-heritage.js') }}?v={{ filemtime(public_path('js/homepage-heritage.js')) }}"></script>
    <script src="{{ url('js/homepage-faq.js') }}?v={{ filemtime(public_path('js/homepage-faq.js')) }}"></script>
    <script src="{{ url('js/homepage-latest-blog.js') }}?v={{ filemtime(public_path('js/homepage-latest-blog.js')) }}"></script>
    @if (
        !empty($recentSection['enabled']) ||
        (!empty($carouselSection['enabled']) && $carouselPosts->isNotEmpty()))
        <script src="{{ url('js/homepage-blog-carousel.js') }}?v={{ filemtime(public_path('js/homepage-blog-carousel.js')) }}"></script>
    @endif
@endsection
