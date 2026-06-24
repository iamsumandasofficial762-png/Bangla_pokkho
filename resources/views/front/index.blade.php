@extends('master.front')

@section('hometitle')
    {{ $setting->home_page_title }}
@endsection

@section('pagestyles')
    <link rel="stylesheet"
        href="{{ url('/core/public/css/homepage-blog.css') }}?v={{ filemtime(public_path('css/homepage-blog.css')) }}">
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
                    <span class="recent-blog-eyebrow">{{ __('From the blog') }}</span>
                    <h1>{{ __('Recent Blog Posts') }}</h1>
                </div>

                @if ($recentPosts->isNotEmpty())
                    <a class="recent-blog-view-all" href="{{ route('front.blog') }}">
                        {{ __('View All Posts') }} <span aria-hidden="true">&rarr;</span>
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
                            <span class="recent-blog-category">{{ $featuredPost->category->name ?: __('Blog') }}</span>
                            <span class="recent-blog-title">{{ $featuredPost->title }}</span>
                            <time datetime="{{ $featuredPost->created_at->toDateString() }}">
                                {{ $featuredPost->created_at->format('F j, Y') }}
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
                                        <span class="recent-blog-category">{{ $post->category->name ?: __('Blog') }}</span>
                                        <span class="recent-blog-title">{{ $post->title }}</span>
                                        <time datetime="{{ $post->created_at->toDateString() }}">
                                            {{ $post->created_at->format('F j, Y') }}
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
                    <h2>{{ __('No recent posts available.') }}</h2>
                    <p>{{ __('New stories will appear here as soon as they are published.') }}</p>
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
                            alt="{{ __('About Bangla Pokkho') }}">
                    </div>
                </div>

                <div class="about-pokkho-content">
                    <div class="about-pokkho-label text-primary">
                        <span aria-hidden="true"></span>{{ __('About Bangla Pokkho') }}
                    </div>
                    <h2 id="about-pokkho-title">{{ __('We Stand For Bengali Identity, Language & Rights') }}</h2>
                    <p class="about-pokkho-intro">
                        {{ __('Bangla Pokkho works to protect Bengali language, culture, rights, and representation. We create awareness, organize campaigns, and connect people who care about Bengal and Bengali identity.') }}
                    </p>

                    <div class="about-pokkho-tabs" role="tablist" aria-label="{{ __('About Bangla Pokkho') }}">
                        <button class="about-pokkho-tab is-active text-primary" type="button" role="tab"
                            id="about-tab-mission" aria-controls="about-panel-mission" aria-selected="true"
                            data-about-tab="mission">{{ __('Mission') }}</button>
                        <button class="about-pokkho-tab" type="button" role="tab" id="about-tab-movement"
                            aria-controls="about-panel-movement" aria-selected="false" tabindex="-1"
                            data-about-tab="movement">{{ __('Movement') }}</button>
                        <button class="about-pokkho-tab" type="button" role="tab" id="about-tab-community"
                            aria-controls="about-panel-community" aria-selected="false" tabindex="-1"
                            data-about-tab="community">{{ __('Community') }}</button>
                    </div>

                    <div class="about-pokkho-panels">
                        <div class="about-pokkho-panel is-active" id="about-panel-mission" role="tabpanel"
                            aria-labelledby="about-tab-mission" data-about-panel="mission">
                            <img src="{{ url('/core/public/storage/images/' . $aboutImages['mission']) }}"
                                alt="{{ __('Our mission') }}">
                            <div>
                                <p>{{ __('We focus on language rights, cultural awareness, and fair representation for Bengali people.') }}</p>
                                <ul>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>{{ __('Protect Bengali language and culture') }}</li>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>{{ __('Build public awareness') }}</li>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>{{ __('Support Bengali rights and representation') }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="about-pokkho-panel" id="about-panel-movement" role="tabpanel"
                            aria-labelledby="about-tab-movement" data-about-panel="movement" hidden>
                            <img src="{{ url('/core/public/storage/images/' . $aboutImages['movement']) }}"
                                alt="{{ __('Our movement') }}">
                            <div>
                                <p>{{ __('Our campaigns highlight important social, cultural, and regional issues affecting Bengal and Bengali people.') }}</p>
                                <ul>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>{{ __('Organize campaigns and public activities') }}</li>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>{{ __('Share updates and educational content') }}</li>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>{{ __('Encourage people to participate') }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="about-pokkho-panel" id="about-panel-community" role="tabpanel"
                            aria-labelledby="about-tab-community" data-about-panel="community" hidden>
                            <img src="{{ url('/core/public/storage/images/' . $aboutImages['community']) }}"
                                alt="{{ __('Our community') }}">
                            <div>
                                <p>{{ __('We bring together people who want to contribute to Bengal’s future with unity and responsibility.') }}</p>
                                <ul>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>{{ __('Connect supporters and volunteers') }}</li>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>{{ __('Promote Bengali pride') }}</li>
                                    <li><span class="text-primary" aria-hidden="true">&#10003;</span>{{ __('Strengthen community participation') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($carouselPosts->isNotEmpty())
        @include('front.includes.home-blog-carousel', ['posts' => $carouselPosts])
    @endif
@endsection

@section('script')
    <script src="{{ url('/core/public/js/homepage-about.js') }}"></script>
    @if ($carouselPosts->isNotEmpty())
        <script src="{{ url('/core/public/js/homepage-blog-carousel.js') }}?v={{ filemtime(public_path('js/homepage-blog-carousel.js')) }}"></script>
    @endif
@endsection
