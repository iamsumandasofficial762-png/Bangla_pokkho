@php
    $fallbackAuthorName = $setting->title ?: __('Editorial Team');
    $fallbackAvatar = $setting->favicon ?: 'placeholder.png';

    if (!file_exists(public_path('storage/images/' . $fallbackAvatar))) {
        $fallbackAvatar = 'placeholder.png';
    }
@endphp

<section class="more-posts-section" aria-labelledby="more-posts-title"
    style="--more-posts-accent: {{ $setting->primary_color ?: '#ff6500' }};">
    <div class="container">
        <div class="more-posts-heading">
            <div>
                <span class="more-posts-eyebrow">{{ __('From the blog') }}</span>
                <h2 id="more-posts-title">{{ __('More Blog Posts') }}</h2>
            </div>
            <a class="more-posts-view-all" href="{{ route('front.blog') }}">
                {{ __('View All Posts') }} <span aria-hidden="true">&rarr;</span>
            </a>
        </div>

        <div class="more-posts-carousel owl-carousel" aria-label="{{ __('More blog posts') }}">
            @foreach ($posts as $post)
                @php
                    $photos = json_decode($post->photo, true);
                    $postImage = is_array($photos) && !empty($photos) ? reset($photos) : 'placeholder.png';

                    if (!$postImage || !file_exists(public_path('storage/images/' . $postImage))) {
                        $postImage = 'placeholder.png';
                    }

                    $categoryName = optional($post->category)->name ?: __('Blog');
                    $excerptSource = $post->meta_descriptions ?: $post->details;
                    $excerpt = trim(preg_replace('/\s+/', ' ', strip_tags((string) $excerptSource)));
                    $publishedAt = $post->created_at;
                @endphp

                <article class="more-post-card">
                    <a class="more-post-image" href="{{ route('front.blog.details', $post->slug) }}"
                        aria-label="{{ $post->title }}">
                        <img src="{{ url('/core/public/storage/images/' . $postImage) }}"
                            alt="{{ $post->title }}" loading="lazy">
                    </a>

                    <div class="more-post-body">
                        <span class="more-post-category">{{ $categoryName }}</span>
                        <h3>
                            <a href="{{ route('front.blog.details', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p>{{ $excerpt ?: __('Read the full story to learn more.') }}</p>

                        <div class="more-post-author">
                            <img src="{{ url('/core/public/storage/images/' . $fallbackAvatar) }}"
                                alt="{{ $fallbackAuthorName }}">
                            <div>
                                <span>{{ $fallbackAuthorName }}</span>
                                @if ($publishedAt)
                                    <time datetime="{{ $publishedAt->toDateString() }}"
                                        title="{{ $publishedAt->format('F j, Y') }}">
                                        {{ $publishedAt->diffForHumans() }}
                                    </time>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="more-posts-controls" aria-label="{{ __('Blog carousel controls') }}">
            <button class="more-posts-prev" type="button" aria-label="{{ __('Previous posts') }}">
                <span aria-hidden="true">&larr;</span>
            </button>
            <div class="more-posts-dots" aria-label="{{ __('Blog carousel pagination') }}"></div>
            <button class="more-posts-next" type="button" aria-label="{{ __('Next posts') }}">
                <span aria-hidden="true">&rarr;</span>
            </button>
        </div>
    </div>
</section>
