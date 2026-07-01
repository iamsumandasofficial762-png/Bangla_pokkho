@php
    $blogAuthor = $setting->title ?: 'বাংলা পক্ষ';
    $blogAvatar = $setting->favicon ?: 'placeholder.png';

    if (!file_exists(public_path('storage/images/' . $blogAvatar))) {
        $blogAvatar = 'placeholder.png';
    }

    $cardTypes = [
        'home-blog-card-large',
        'home-blog-card-medium',
        'home-blog-card-medium',
        'home-blog-card-medium',
        'home-blog-card-medium',
        'home-blog-card-wide',
        'home-blog-card-small',
        'home-blog-card-small',
    ];
@endphp

<section class="home-latest-blog-section" aria-labelledby="home-latest-blog-title">
    <div class="container">
        <h2 class="sr-only" id="home-latest-blog-title">
            {{ $latestSection['heading'] ?? 'আমাদের ব্লগের সর্বশেষ পোস্ট' }}
        </h2>

        @if ($latestBlogs->isNotEmpty())
            <div class="home-blog-masonry">
                @foreach ($latestBlogs->take(8) as $blogIndex => $post)
                    @php
                        $photos = json_decode($post->photo, true);
                        $blogImage = is_array($photos) && !empty($photos) ? reset($photos) : 'placeholder.png';

                        if (!$blogImage || !file_exists(public_path('storage/images/' . $blogImage))) {
                            $blogImage = 'placeholder.png';
                        }

                        $blogExcerptSource = $post->meta_descriptions ?: $post->details;
                        $blogExcerpt = trim(preg_replace('/\s+/', ' ', strip_tags((string) $blogExcerptSource)));
                        $blogCategory = optional($post->category)->name ?: 'ব্লগ';
                        $cardType = $cardTypes[$blogIndex] ?? 'home-blog-card-small';
                        $postUrl = route('front.blog.details', $post->slug);
                    @endphp

                    <article class="home-blog-card {{ $cardType }}">
                        <a class="home-blog-card-image" href="{{ $postUrl }}" aria-label="{{ $post->title }}">
                            <img src="{{ url('storage/images/' . $blogImage) }}"
                                alt="{{ $post->title }}" loading="lazy">
                        </a>

                        <div class="home-blog-card-content">
                            <span class="home-blog-card-category">{{ $blogCategory }}</span>
                            <h3>
                                <a href="{{ $postUrl }}">{{ $post->title }}</a>
                            </h3>
                            <p>{{ $blogExcerpt ?: 'সম্পূর্ণ লেখাটি পড়ুন এবং বাংলা পক্ষ সম্পর্কে আরও জানুন।' }}</p>

                            <div class="home-blog-card-meta">
                                <img src="{{ url('storage/images/' . $blogAvatar) }}" alt="{{ $blogAuthor }}">
                                <div>
                                    <strong>{{ $blogAuthor }}</strong>
                                    @if ($post->created_at)
                                        <time datetime="{{ $post->created_at->toDateString() }}">
                                            {{ $post->created_at->format('d/m/Y') }}
                                        </time>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="home-blog-masonry-empty">
                <i class="far fa-newspaper" aria-hidden="true"></i>
                <p>এখনও কোনো ব্লগ পোস্ট নেই।</p>
            </div>
        @endif
    </div>
</section>
