@extends('master.front')

@section('hometitle')
    {{ $setting->home_page_title }}
@endsection

@section('pagestyles')
    <link rel="stylesheet"
        href="{{ url('/core/public/css/homepage-blog.css') }}?v={{ filemtime(public_path('css/homepage-blog.css')) }}">
    <link rel="stylesheet"
        href="{{ url('/core/public/css/homepage-latest-blog.css') }}?v={{ filemtime(public_path('css/homepage-latest-blog.css')) }}">
@endsection

@section('content')
    @php
        $featuredPost = $recentPosts->first();
        $sidePosts = $recentPosts->skip(1)->take(4);
    @endphp

    <main class="recent-blog-home">
        <div class="container">
            <div class="recent-blog-heading">
                <div>
                    <span class="recent-blog-eyebrow">ব্লগ থেকে</span>
                    <h1>সাম্প্রতিক ব্লগ পোস্ট</h1>
                </div>

                @if ($recentPosts->isNotEmpty())
                    <a class="recent-blog-view-all" href="{{ route('front.blog') }}">
                        সব পোস্ট দেখুন <span aria-hidden="true">&rarr;</span>
                    </a>
                @endif
            </div>

            @if ($featuredPost)
                <div class="recent-blog-layout {{ $sidePosts->isEmpty() ? 'recent-blog-layout--featured-only' : '' }}">
                    @php
                        $featuredPhotos = json_decode($featuredPost->photo, true);
                        $featuredImage = is_array($featuredPhotos) && !empty($featuredPhotos)
                            ? reset($featuredPhotos)
                            : 'placeholder.png';
                    @endphp

                    <a class="recent-blog-card recent-blog-card--featured"
                        href="{{ route('front.blog.details', $featuredPost->slug) }}">
                        <img src="{{ url('/core/public/storage/images/' . $featuredImage) }}"
                            alt="{{ $featuredPost->title }}">
                        <span class="recent-blog-overlay"></span>
                        <span class="recent-blog-content">
                            <span class="recent-blog-category">{{ $featuredPost->category->name ?: 'ব্লগ' }}</span>
                            <span class="recent-blog-title">{{ $featuredPost->title }}</span>
                            <time datetime="{{ $featuredPost->created_at->toDateString() }}">
                                {{ $featuredPost->created_at->format('d/m/Y') }}
                            </time>
                        </span>
                    </a>

                    @if ($sidePosts->isNotEmpty())
                        <div class="recent-blog-side-grid">
                            @foreach ($sidePosts as $post)
                                @php
                                    $postPhotos = json_decode($post->photo, true);
                                    $postImage = is_array($postPhotos) && !empty($postPhotos)
                                        ? reset($postPhotos)
                                        : 'placeholder.png';
                                @endphp

                                <a class="recent-blog-card recent-blog-card--small"
                                    href="{{ route('front.blog.details', $post->slug) }}">
                                    <img src="{{ url('/core/public/storage/images/' . $postImage) }}"
                                        alt="{{ $post->title }}">
                                    <span class="recent-blog-overlay"></span>
                                    <span class="recent-blog-content">
                                        <span class="recent-blog-category">{{ $post->category->name ?: 'ব্লগ' }}</span>
                                        <span class="recent-blog-title">{{ $post->title }}</span>
                                        <time datetime="{{ $post->created_at->toDateString() }}">
                                            {{ $post->created_at->format('d/m/Y') }}
                                        </time>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="recent-blog-empty">
                    <span class="recent-blog-empty-icon" aria-hidden="true">&#128196;</span>
                    <h2>সাম্প্রতিক কোনো পোস্ট নেই।</h2>
                    <p>নতুন লেখা প্রকাশিত হলেই এখানে দেখা যাবে।</p>
                </div>
            @endif
        </div>
    </main>

    @php
        // Replace these filenames with any images from public/storage/images.
        $aboutImages = [
            'main' => '1632349684media_7-768x512.jpg',
            'mission' => '1632349673media_5-768x512.jpg',
            'movement' => '1632349704media_21-768x512.jpg',
            'community' => '1632349716media_23-768x512.jpg',
        ];

        foreach ($aboutImages as $imageKey => $imageName) {
            if (!$imageName || !file_exists(public_path('storage/images/' . $imageName))) {
                $aboutImages[$imageKey] = 'placeholder.png';
            }
        }
    @endphp

    <section class="about-pokkho-section" aria-labelledby="about-pokkho-title">
        <div class="container">
            <div class="about-pokkho-layout">
                <div class="about-pokkho-visual">
                    <div class="about-pokkho-image-frame">
                        <img src="{{ url('/core/public/storage/images/' . $aboutImages['main']) }}"
                            alt="বাংলা পক্ষ সম্পর্কে">
                    </div>
                </div>

                <div class="about-pokkho-content">
                    <div class="about-pokkho-label text-primary">
                        <span aria-hidden="true"></span>বাংলা পক্ষ সম্পর্কে
                    </div>
                    <h2 id="about-pokkho-title">বাঙালি পরিচয়, ভাষা ও অধিকারের পক্ষে আমরা</h2>
                    <p class="about-pokkho-intro">
                        বাংলা পক্ষ বাঙালি ভাষা, সংস্কৃতি, অধিকার ও প্রতিনিধিত্ব রক্ষায় কাজ করে। আমরা সচেতনতা তৈরি করি, প্রচারাভিযান সংগঠিত করি এবং বাংলা ও বাঙালি পরিচয়কে ভালোবাসা মানুষদের যুক্ত করি।
                    </p>

                    <div class="about-pokkho-tabs" role="tablist" aria-label="বাংলা পক্ষ সম্পর্কে">
                        <button class="about-pokkho-tab is-active text-primary" type="button" role="tab"
                            id="about-tab-mission" aria-controls="about-panel-mission" aria-selected="true"
                            data-about-tab="mission">লক্ষ্য</button>
                        <button class="about-pokkho-tab" type="button" role="tab" id="about-tab-movement"
                            aria-controls="about-panel-movement" aria-selected="false" tabindex="-1"
                            data-about-tab="movement">আন্দোলন</button>
                        <button class="about-pokkho-tab" type="button" role="tab" id="about-tab-community"
                            aria-controls="about-panel-community" aria-selected="false" tabindex="-1"
                            data-about-tab="community">সমাজ</button>
                    </div>

                    <div class="about-pokkho-panels">
                        <div class="about-pokkho-panel is-active" id="about-panel-mission" role="tabpanel"
                            aria-labelledby="about-tab-mission" data-about-panel="mission">
                            <img src="{{ url('/core/public/storage/images/' . $aboutImages['mission']) }}"
                                alt="আমাদের লক্ষ্য">
                            <div>
                                <p>আমরা বাঙালির ভাষার অধিকার, সাংস্কৃতিক সচেতনতা এবং ন্যায্য প্রতিনিধিত্বকে গুরুত্ব দিই।</p>
                                <ul>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>বাংলা ভাষা ও সংস্কৃতির সুরক্ষা</li>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>জনসচেতনতা গড়ে তোলা</li>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>বাঙালির অধিকার ও প্রতিনিধিত্বকে সমর্থন</li>
                                </ul>
                            </div>
                        </div>

                        <div class="about-pokkho-panel" id="about-panel-movement" role="tabpanel"
                            aria-labelledby="about-tab-movement" data-about-panel="movement" hidden>
                            <img src="{{ url('/core/public/storage/images/' . $aboutImages['movement']) }}"
                                alt="আমাদের আন্দোলন">
                            <div>
                                <p>আমাদের প্রচারাভিযান বাংলার ও বাঙালির গুরুত্বপূর্ণ সামাজিক, সাংস্কৃতিক এবং আঞ্চলিক বিষয়গুলো সামনে আনে।</p>
                                <ul>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>প্রচারাভিযান ও জনসম্পৃক্ত কর্মসূচি আয়োজন</li>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>তথ্য ও শিক্ষামূলক বিষয় শেয়ার করা</li>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>মানুষকে অংশগ্রহণে উৎসাহ দেওয়া</li>
                                </ul>
                            </div>
                        </div>

                        <div class="about-pokkho-panel" id="about-panel-community" role="tabpanel"
                            aria-labelledby="about-tab-community" data-about-panel="community" hidden>
                            <img src="{{ url('/core/public/storage/images/' . $aboutImages['community']) }}"
                                alt="আমাদের সমাজ">
                            <div>
                                <p>বাংলার ভবিষ্যতের জন্য ঐক্য ও দায়িত্ব নিয়ে কাজ করতে চান এমন মানুষদের আমরা একত্র করি।</p>
                                <ul>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>সমর্থক ও স্বেচ্ছাসেবকদের যুক্ত করা</li>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>বাঙালি গর্বকে এগিয়ে নেওয়া</li>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>সমাজের অংশগ্রহণ শক্তিশালী করা</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{ url('/core/public/storage/images/nouka_w.png') }}" class="about-boat-decoration" alt=""
            aria-hidden="true">
    </section>

    @include('front.includes.heritage-community', ['heritageImages' => $aboutImages])

    @if ($carouselPosts->isNotEmpty())
        @include('front.includes.home-blog-carousel', ['posts' => $carouselPosts])
    @endif

    @include('front.includes.home-faq')

    @include('front.includes.home-latest-blog', ['latestBlogs' => $recentPosts->take(3)])
@endsection

@section('script')
    <script src="{{ url('/core/public/js/homepage-about.js') }}"></script>
    <script src="{{ url('/core/public/js/homepage-heritage.js') }}?v={{ filemtime(public_path('js/homepage-heritage.js')) }}"></script>
    <script src="{{ url('/core/public/js/homepage-faq.js') }}?v={{ filemtime(public_path('js/homepage-faq.js')) }}"></script>
    <script src="{{ url('/core/public/js/homepage-latest-blog.js') }}?v={{ filemtime(public_path('js/homepage-latest-blog.js')) }}"></script>
    @if ($carouselPosts->isNotEmpty())
        <script src="{{ url('/core/public/js/homepage-blog-carousel.js') }}?v={{ filemtime(public_path('js/homepage-blog-carousel.js')) }}"></script>
    @endif
@endsection
