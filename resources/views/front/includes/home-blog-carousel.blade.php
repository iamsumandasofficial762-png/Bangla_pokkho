@php
    $fallbackAuthorName = $setting->title ?: 'বাংলা পক্ষ';
    $fallbackAvatar = $setting->favicon ?: 'placeholder.png';

    if (!file_exists(public_path('storage/images/' . $fallbackAvatar))) {
        $fallbackAvatar = 'placeholder.png';
    }
@endphp

<section class="more-posts-section" aria-labelledby="more-posts-title">
    <div class="container">
        <div class="more-posts-panel">
            <div class="more-posts-heading">
                <div>
                    <span class="more-posts-eyebrow">{{ $carouselSection['label'] ?? 'ব্লগ থেকে' }}</span>
                    <h2 id="more-posts-title">{{ $carouselSection['heading'] ?? 'আরও ব্লগ পোস্ট' }}</h2>
                    <p class="more-posts-subtitle">{{ $carouselSection['description'] ?? '' }}</p>
                </div>
                <a class="more-posts-view-all" href="{{ $carouselSection['view_all_url'] ?? route('front.blog') }}">
                    {{ $carouselSection['view_all_text'] ?? 'সব পোস্ট দেখুন' }} <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            <div class="more-posts-carousel owl-carousel" aria-label="{{ $carouselSection['heading'] ?? 'আরও ব্লগ পোস্ট' }}">
                @foreach ($posts as $post)
                    @php
                        $photos = json_decode($post->photo, true);
                        $postImage = is_array($photos) && !empty($photos) ? reset($photos) : 'placeholder.png';

                        if (!$postImage || !file_exists(public_path('storage/images/' . $postImage))) {
                            $postImage = 'placeholder.png';
                        }

                        $categoryName = optional($post->category)->name ?: 'ব্লগ';
                        $excerptSource = $post->meta_descriptions ?: $post->details;
                        $excerpt = trim(preg_replace('/\s+/', ' ', strip_tags((string) $excerptSource)));
                        $publishedAt = $post->created_at;
                    @endphp

                    <article class="more-post-card">
                        <a class="more-post-image" href="{{ route('front.blog.details', $post->slug) }}"
                            aria-label="{{ $post->title }}">
                            <img src="{{ url('storage/images/' . $postImage) }}"
                                alt="{{ $post->title }}" loading="lazy">
                        </a>

                        <div class="more-post-body">
                            <span class="more-post-category">{{ $categoryName }}</span>
                            <h3>
                                <a href="{{ route('front.blog.details', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p>{{ $excerpt ?: 'আরও জানতে পুরো লেখাটি পড়ুন।' }}</p>

                            <div class="more-post-author">
                                <img src="{{ url('storage/images/' . $fallbackAvatar) }}"
                                    alt="{{ $fallbackAuthorName }}">
                                <div>
                                    <span>{{ $fallbackAuthorName }}</span>
                                    @if ($publishedAt)
                                        <time datetime="{{ $publishedAt->toDateString() }}"
                                            title="{{ $publishedAt->format('d/m/Y') }}">
                                            {{ $publishedAt->format('d/m/Y') }}
                                        </time>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="more-posts-controls" aria-label="ব্লগ ক্যারোসেল নিয়ন্ত্রণ">
                <button class="more-posts-prev" type="button" aria-label="আগের পোস্ট">
                    <span aria-hidden="true">&larr;</span>
                </button>
                <div class="more-posts-dots" aria-label="ব্লগ ক্যারোসেল পৃষ্ঠা"></div>
                <button class="more-posts-next" type="button" aria-label="পরের পোস্ট">
                    <span aria-hidden="true">&rarr;</span>
                </button>
            </div>
        </div>
    </div>
</section>
