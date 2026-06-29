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

        $featuredPost = $recentPosts->first();
        $sidePosts = $recentPosts->skip(1)->take(4);

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
                <div class="recent-blog-heading">
                    <div>
                        <span class="recent-blog-eyebrow">{{ $recentSection['label'] ?? 'ব্লগ থেকে' }}</span>
                        <h1>{{ $recentSection['heading'] ?? 'সাম্প্রতিক ব্লগ পোস্ট' }}</h1>
                    </div>

                    @if ($recentPosts->isNotEmpty())
                        <a class="recent-blog-view-all" href="{{ $recentSection['view_all_url'] ?? route('front.blog') }}">
                            {{ $recentSection['view_all_text'] ?? 'সব পোস্ট দেখুন' }} <span aria-hidden="true">&rarr;</span>
                        </a>
                    @endif
                </div>

                @if ($featuredPost)
                    <div class="recent-blog-layout {{ $sidePosts->isEmpty() ? 'recent-blog-layout--featured-only' : '' }}">
                        @php
                            $featuredPhotos = json_decode($featuredPost->photo, true);
                            $featuredImage = is_array($featuredPhotos) && !empty($featuredPhotos)
                                ? $imageName(reset($featuredPhotos))
                                : 'placeholder.png';
                        @endphp

                        <a class="recent-blog-card recent-blog-card--featured"
                            href="{{ route('front.blog.details', $featuredPost->slug) }}">
                            <img src="{{ url('storage/images/' . $featuredImage) }}"
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
                                            ? $imageName(reset($postPhotos))
                                            : 'placeholder.png';
                                    @endphp

                                    <a class="recent-blog-card recent-blog-card--small"
                                        href="{{ route('front.blog.details', $post->slug) }}">
                                        <img src="{{ url('storage/images/' . $postImage) }}"
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

    @if (!empty($carouselSection['enabled']) && $carouselPosts->isNotEmpty())
        @include('front.includes.home-blog-carousel', [
            'posts' => $carouselPosts,
            'carouselSection' => $carouselSection,
        ])
    @endif

    @if (!empty($faqSection['enabled']))
        @include('front.includes.home-faq', ['faqSection' => $faqSection])
    @endif

    @if (!empty($latestSection['enabled']))
        @include('front.includes.home-latest-blog', [
            'latestBlogs' => $latestBlogs,
            'latestSection' => $latestSection,
        ])
    @endif
@endsection

@section('script')
    <script src="{{ url('js/homepage-about.js') }}"></script>
    <script src="{{ url('js/homepage-heritage.js') }}?v={{ filemtime(public_path('js/homepage-heritage.js')) }}"></script>
    <script src="{{ url('js/homepage-faq.js') }}?v={{ filemtime(public_path('js/homepage-faq.js')) }}"></script>
    <script src="{{ url('js/homepage-latest-blog.js') }}?v={{ filemtime(public_path('js/homepage-latest-blog.js')) }}"></script>
    @if (!empty($carouselSection['enabled']) && $carouselPosts->isNotEmpty())
        <script src="{{ url('js/homepage-blog-carousel.js') }}?v={{ filemtime(public_path('js/homepage-blog-carousel.js')) }}"></script>
    @endif
@endsection
