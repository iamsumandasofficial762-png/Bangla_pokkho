<section class="home-latest-blog-section" aria-labelledby="home-latest-blog-title"
    data-blog-search-url="{{ route('front.home.blog.search') }}">
    @php
        $blogAuthor = $setting->title ?: 'বাংলা পক্ষ';
        $blogAvatar = $setting->favicon ?: 'placeholder.png';

        if (!file_exists(public_path('storage/images/' . $blogAvatar))) {
            $blogAvatar = 'placeholder.png';
        }
    @endphp

    <div class="container">
        <header class="home-latest-blog-heading">
            <span>{{ $latestSection['label'] ?? 'ব্লগ' }}</span>
            <h2 id="home-latest-blog-title">{{ $latestSection['heading'] ?? 'আমাদের ব্লগের সর্বশেষ পোস্ট' }}</h2>
            <p>{{ $latestSection['description'] ?? '' }}</p>
        </header>

        @if ($latestBlogs->isNotEmpty())
            <div class="home-latest-blog-filters" role="search">
                <label class="home-latest-blog-search">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <span class="sr-only">শিরোনাম দিয়ে ব্লগ খুঁজুন</span>
                    <input type="search" placeholder="{{ $latestSection['search_placeholder'] ?? 'ব্লগ খুঁজুন' }}" data-home-blog-search>
                    <button class="home-latest-blog-clear" type="button" data-home-blog-clear
                        aria-label="ব্লগ খোঁজা মুছুন" hidden>
                        <i class="fas fa-times" aria-hidden="true"></i>
                    </button>
                </label>

                <label class="home-latest-blog-category">
                    <span class="sr-only">ক্যাটাগরি দিয়ে ফিল্টার করুন</span>
                    <select data-home-blog-category>
                        <option value="">{{ $latestSection['category_placeholder'] ?? 'সব ক্যাটাগরি' }}</option>
                        @foreach ($blogCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down" aria-hidden="true"></i>
                </label>

                <div class="home-blog-search-results" data-home-blog-results hidden aria-live="polite">
                    <div class="home-blog-search-status" data-home-blog-status></div>
                    <div class="home-blog-search-list" data-home-blog-result-list></div>
                </div>
            </div>

            <div class="home-latest-blog-grid" data-home-blog-grid>
                @foreach ($latestBlogs as $blogIndex => $post)
                    @php
                        $photos = json_decode($post->photo, true);
                        $blogImage = is_array($photos) && !empty($photos) ? reset($photos) : 'placeholder.png';
                        if (!$blogImage || !file_exists(public_path('storage/images/' . $blogImage))) {
                            $blogImage = 'placeholder.png';
                        }

                        $blogExcerptSource = $post->meta_descriptions ?: $post->details;
                        $blogExcerpt = trim(preg_replace('/\s+/', ' ', strip_tags((string) $blogExcerptSource)));
                        $blogCategory = optional($post->category)->name ?: 'ব্লগ';
                        $blogCategoryId = optional($post->category)->id ?: '';
                    @endphp

                    <article class="home-latest-blog-card {{ $blogIndex === 0 ? 'home-latest-blog-card--featured' : 'home-latest-blog-card--small' }}"
                        data-home-blog-card data-title="{{ Str::lower($post->title) }}"
                        data-category="{{ $blogCategoryId }}">
                        <a class="home-latest-blog-image" href="{{ route('front.blog.details', $post->slug) }}"
                            aria-label="{{ $post->title }}">
                            <img src="{{ url('storage/images/' . $blogImage) }}"
                                alt="{{ $post->title }}" loading="lazy">
                        </a>

                        <div class="home-latest-blog-body">
                            <span class="home-latest-blog-badge">{{ $blogCategory }}</span>
                            <h3>
                                <a href="{{ route('front.blog.details', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p>{{ $blogExcerpt ?: 'সম্পূর্ণ লেখা পড়ুন এবং বাংলা পক্ষ সম্পর্কে আরও জানুন।' }}</p>

                            <div class="home-latest-blog-meta">
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
            <div class="home-latest-blog-empty">
                <i class="far fa-newspaper" aria-hidden="true"></i>
                <p>এখনও কোনো ব্লগ পোস্ট নেই।</p>
            </div>
        @endif
    </div>
</section>
