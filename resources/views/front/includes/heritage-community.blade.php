<section class="heritage-community-section" aria-labelledby="heritage-community-title">
    @php
        $heritageCards = $heritageSection['cards'] ?? [];
        $heritageValues = $heritageSection['features'] ?? [];
        $imageName = function ($name) {
            if (!$name || !file_exists(public_path('storage/images/' . $name))) {
                return 'placeholder.png';
            }
            return $name;
        };
    @endphp

    <div class="container">
        <div class="heritage-community-main">
            <div class="heritage-community-intro">
                <span class="heritage-community-label">
                    <i class="fas fa-seedling" aria-hidden="true"></i>
                    {{ $heritageSection['label'] ?? 'বাংলা পক্ষ' }}
                </span>
                <h2 id="heritage-community-title">{{ $heritageSection['heading'] ?? '' }}</h2>
                <span class="heritage-community-flourish" aria-hidden="true"></span>
                <p>{{ $heritageSection['description'] ?? '' }}</p>
            </div>

            <div class="heritage-community-cards">
                @foreach ($heritageCards as $cardIndex => $card)
                    @php $cardImage = $imageName($card['image'] ?? null); @endphp
                    <article class="heritage-feature-card" role="button" tabindex="0"
                        data-heritage-card="{{ $cardIndex }}" aria-expanded="false"
                        aria-controls="heritage-detail-{{ $cardIndex }}">
                        <div class="heritage-feature-image">
                            <img src="{{ url('storage/images/' . $cardImage) }}"
                                alt="{{ $card['title'] ?? '' }}" loading="lazy">
                        </div>
                        <div class="heritage-feature-icon" aria-hidden="true">
                            <i class="{{ $card['icon'] ?? 'fas fa-seedling' }}"></i>
                        </div>
                        <div class="heritage-feature-content">
                            <h3>{{ $card['title'] ?? '' }}</h3>
                            <p>{{ $card['description'] ?? '' }}</p>
                            <a class="heritage-feature-link" href="{{ $card['button_url'] ?? '#' }}">
                                {{ $card['button_text'] ?? 'আরও জানুন' }} <i class="fas fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>

                    <div class="heritage-detail-panel" id="heritage-detail-{{ $cardIndex }}"
                        data-heritage-panel="{{ $cardIndex }}" role="region"
                        aria-labelledby="heritage-detail-title-{{ $cardIndex }}" hidden>
                        <button class="heritage-detail-close" type="button"
                            aria-label="বিস্তারিত বন্ধ করুন">
                            <i class="fas fa-times" aria-hidden="true"></i>
                        </button>

                        <span class="heritage-detail-badge">{{ $card['title'] ?? '' }}</span>
                        <h3 id="heritage-detail-title-{{ $cardIndex }}">{{ $card['title'] ?? '' }}</h3>
                        <p class="heritage-detail-intro">{{ $card['description'] ?? '' }}</p>

                        <div class="heritage-detail-layout">
                            <ul class="heritage-detail-points">
                                <li>
                                    <span aria-hidden="true"><i class="{{ $card['icon'] ?? 'fas fa-seedling' }}"></i></span>
                                    <strong>{{ $card['button_text'] ?? 'আরও জানুন' }}</strong>
                                </li>
                            </ul>

                            <div class="heritage-detail-image">
                                <img src="{{ url('storage/images/' . $cardImage) }}"
                                    alt="{{ $card['title'] ?? '' }}" loading="lazy">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="heritage-values" aria-label="আমাদের মূল্যবোধ">
            @foreach ($heritageValues as $value)
                <div class="heritage-value-item">
                    <div class="heritage-value-icon" aria-hidden="true">
                        <i class="{{ $value['icon'] ?? 'fas fa-seedling' }}"></i>
                    </div>
                    <div>
                        <h3>{{ $value['title'] ?? '' }}</h3>
                        <p>{{ $value['description'] ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
