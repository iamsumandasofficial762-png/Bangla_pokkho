<section class="heritage-community-section" aria-labelledby="heritage-community-title">
    @php
        $heritageCards = [
            [
                'title' => 'দুর্গাপূজা সহায়তা',
                'description' => 'যে ঐতিহ্য বাংলাকে একসূত্রে বাঁধে, সেই দুর্গাপূজা উদযাপনে আমরা সমাজের পাশে থাকি।',
                'image' => $heritageImages['main'] ?? 'placeholder.png',
                'icon' => 'fas fa-hands-helping',
                'badge' => 'দুর্গাপূজা সহায়তা',
                'heading' => 'ঐতিহ্যের পাশে। সমাজকে আরও শক্তিশালী করি।',
                'detail' => 'বাংলাজুড়ে দুর্গাপূজার প্রাণশক্তি ধরে রাখতে আমরা পূজা কমিটি ও সমাজের পাশে থাকি।',
                'points' => [
                    ['আর্থিক সহায়তা', 'fas fa-coins'],
                    ['লজিস্টিক ও সম্পদ', 'fas fa-truck-loading'],
                    ['সাংস্কৃতিক প্রচার', 'fas fa-bullhorn'],
                    ['নিরাপত্তা ও সুরক্ষা', 'fas fa-shield-alt'],
                ],
            ],
            [
                'title' => 'সাংস্কৃতিক অনুষ্ঠান',
                'description' => 'বাংলা শিল্প, সংগীত, নৃত্য, সাহিত্য এবং জীবন্ত সাংস্কৃতিক ঐতিহ্যকে এগিয়ে নেওয়া।',
                'image' => $heritageImages['movement'] ?? 'placeholder.png',
                'icon' => 'fas fa-music',
                'badge' => 'সাংস্কৃতিক অনুষ্ঠান',
                'heading' => 'বাংলা শিল্প, সংগীত ও পরিবেশনার উদযাপন।',
                'detail' => 'প্রজন্মকে যুক্ত করে এমন বাংলা গান, নাচ, নাটক, সাহিত্য ও সাংস্কৃতিক অনুষ্ঠানকে আমরা এগিয়ে নিই।',
                'points' => [
                    ['লোক ও শাস্ত্রীয় পরিবেশনা', 'fas fa-music'],
                    ['সমাজভিত্তিক অনুষ্ঠান', 'fas fa-calendar-alt'],
                    ['শিল্পী সহায়তা', 'fas fa-palette'],
                    ['তরুণদের অংশগ্রহণ', 'fas fa-child'],
                ],
            ],
            [
                'title' => 'শিক্ষা ও সচেতনতা',
                'description' => 'বাংলার ইতিহাস, ভাষা, সাহিত্য এবং মহৎ ব্যক্তিত্ব সম্পর্কে জ্ঞান ছড়িয়ে দেওয়া।',
                'image' => $heritageImages['mission'] ?? 'placeholder.png',
                'icon' => 'fas fa-book-open',
                'badge' => 'শিক্ষা ও সচেতনতা',
                'heading' => 'বাংলা সম্পর্কে জ্ঞান ছড়িয়ে দেওয়া।',
                'detail' => 'বাংলার ইতিহাস, সাহিত্য, ভাষা, পথিকৃৎ ও সামাজিক অবদান নিয়ে আমরা সচেতনতা তৈরি করি।',
                'points' => [
                    ['ইতিহাস ও সাহিত্য', 'fas fa-book-open'],
                    ['ভাষা সচেতনতা', 'fas fa-language'],
                    ['জনপ্রচার', 'fas fa-bullhorn'],
                    ['শিক্ষার্থী সম্পৃক্ততা', 'fas fa-user-graduate'],
                ],
            ],
            [
                'title' => 'সমাজ উদ্যোগ',
                'description' => 'সামাজিক কল্যাণ, শক্তিশালী সমাজ এবং অর্থবহ উন্নয়নের জন্য একসঙ্গে কাজ করা।',
                'image' => $heritageImages['community'] ?? 'placeholder.png',
                'icon' => 'fas fa-users',
                'badge' => 'সমাজ উদ্যোগ',
                'heading' => 'আরও শক্তিশালী বাঙালি সমাজ গড়ে তোলা।',
                'detail' => 'সামাজিক কল্যাণ, ঐক্য ও সমাজ উন্নয়নের জন্য আমরা মানুষ ও স্থানীয় দলের সঙ্গে কাজ করি।',
                'points' => [
                    ['সামাজিক কল্যাণ', 'fas fa-hands-helping'],
                    ['স্থানীয় সহায়তা', 'fas fa-map-marker-alt'],
                    ['সমাজের সংযোগ', 'fas fa-project-diagram'],
                    ['উন্নত আগামী', 'fas fa-seedling'],
                ],
            ],
        ];

        $heritageValues = [
            [
                'title' => 'মূল্যবোধে দৃঢ়',
                'description' => 'সততা, নিষ্ঠা ও সম্মান আমাদের প্রতিটি কাজে পথ দেখায়।',
                'icon' => 'fas fa-shield-alt',
            ],
            [
                'title' => 'একসঙ্গে এগিয়ে চলা',
                'description' => 'বাঙালি গর্বে ঐক্যবদ্ধ হয়ে আমরা আরও শক্তিশালী সমাজ গড়ি।',
                'icon' => 'fas fa-users',
            ],
            [
                'title' => 'ঐতিহ্যে গর্বিত',
                'description' => 'বাংলার সমৃদ্ধ উত্তরাধিকার আমরা উদযাপন ও সংরক্ষণ করি।',
                'icon' => 'fas fa-landmark',
            ],
            [
                'title' => 'উন্নত আগামীর জন্য',
                'description' => 'সবার জন্য উজ্জ্বল ও অন্তর্ভুক্তিমূলক ভবিষ্যতের অঙ্গীকার।',
                'icon' => 'fas fa-heart',
            ],
        ];
    @endphp

    <div class="container">
        <div class="heritage-community-main">
            <div class="heritage-community-intro">
                <span class="heritage-community-label">
                    <i class="fas fa-seedling" aria-hidden="true"></i>
                    বাংলা পক্ষ
                </span>
                <h2 id="heritage-community-title">বাঙালি ঐতিহ্য রক্ষা, প্রজন্মকে অনুপ্রাণিত করা</h2>
                <span class="heritage-community-flourish" aria-hidden="true"></span>
                <p>বাংলা পক্ষ বাঙালি সংস্কৃতি, ঐতিহ্য ও মূল্যবোধকে উদযাপন করতে নিবেদিত। আসুন, একসঙ্গে আরও শক্তিশালী ও গর্বিত বাঙালি সমাজ গড়ে তুলি।</p>

            </div>

            <div class="heritage-community-cards">
                @foreach ($heritageCards as $cardIndex => $card)
                    @php
                        $cardImage = $card['image'];
                        if (!$cardImage || !file_exists(public_path('storage/images/' . $cardImage))) {
                            $cardImage = 'placeholder.png';
                        }
                    @endphp
                    <article class="heritage-feature-card" role="button" tabindex="0"
                        data-heritage-card="{{ $cardIndex }}" aria-expanded="false"
                        aria-controls="heritage-detail-{{ $cardIndex }}">
                        <div class="heritage-feature-image">
                            <img src="{{ url('/core/public/storage/images/' . $cardImage) }}"
                                alt="{{ $card['title'] }}" loading="lazy">
                        </div>
                        <div class="heritage-feature-icon" aria-hidden="true">
                            <i class="{{ $card['icon'] }}"></i>
                        </div>
                        <div class="heritage-feature-content">
                            <h3>{{ $card['title'] }}</h3>
                            <p>{{ $card['description'] }}</p>
                            <span class="heritage-feature-link">
                                আরও জানুন <i class="fas fa-arrow-right" aria-hidden="true"></i>
                            </span>
                        </div>
                    </article>

                    <div class="heritage-detail-panel" id="heritage-detail-{{ $cardIndex }}"
                        data-heritage-panel="{{ $cardIndex }}" role="region"
                        aria-labelledby="heritage-detail-title-{{ $cardIndex }}" hidden>
                        <button class="heritage-detail-close" type="button"
                            aria-label="বিস্তারিত বন্ধ করুন">
                            <i class="fas fa-times" aria-hidden="true"></i>
                        </button>

                        <span class="heritage-detail-badge">{{ $card['badge'] }}</span>
                        <h3 id="heritage-detail-title-{{ $cardIndex }}">{{ $card['heading'] }}</h3>
                        <p class="heritage-detail-intro">{{ $card['detail'] }}</p>

                        <div class="heritage-detail-layout">
                            <ul class="heritage-detail-points">
                                @foreach ($card['points'] as $point)
                                    <li>
                                        <span aria-hidden="true"><i class="{{ $point[1] }}"></i></span>
                                        <strong>{{ $point[0] }}</strong>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="heritage-detail-image">
                                <img src="{{ url('/core/public/storage/images/' . $cardImage) }}"
                                    alt="{{ $card['heading'] }}" loading="lazy">
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
                        <i class="{{ $value['icon'] }}"></i>
                    </div>
                    <div>
                        <h3>{{ $value['title'] }}</h3>
                        <p>{{ $value['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
