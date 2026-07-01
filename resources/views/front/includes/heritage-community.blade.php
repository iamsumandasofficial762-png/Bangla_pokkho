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
        $detailProfiles = [
            'puja' => [
                'about' => [
                    'দুর্গাপূজা বাঙালির ধর্মীয় উৎসবের পাশাপাশি মিলন, শিল্প ও সামাজিক সম্প্রীতির এক গুরুত্বপূর্ণ ঐতিহ্য। এই উদ্যোগের মাধ্যমে স্থানীয় পূজা কমিটি ও সমাজের প্রয়োজনভিত্তিক কাজে পাশে থাকা হয়।',
                    'আমরা স্বেচ্ছাসেবক সমন্বয়, সাংস্কৃতিক আয়োজন, সচেতনতা এবং প্রয়োজনীয় সহায়তার মাধ্যমে উৎসবকে আরও অন্তর্ভুক্তিমূলক ও সুশৃঙ্খল করতে কাজ করি।',
                    'ভবিষ্যতে আরও বেশি স্থানীয় কমিটিকে যুক্ত করে নতুন প্রজন্মের অংশগ্রহণ বাড়ানো এবং বাংলার উৎসব-ঐতিহ্যকে দায়িত্বশীলভাবে এগিয়ে নেওয়াই আমাদের পরিকল্পনা।',
                ],
                'why' => [
                    ['icon' => 'fas fa-landmark', 'title' => 'ঐতিহ্য সংরক্ষণ', 'description' => 'দুর্গাপূজার শিল্প, আচার ও সামাজিক ইতিহাসকে পরবর্তী প্রজন্মের কাছে পৌঁছে দেয়।'],
                    ['icon' => 'fas fa-users', 'title' => 'সামাজিক ঐক্য', 'description' => 'পাড়া, পরিবার ও বিভিন্ন প্রজন্মকে একটি অভিন্ন উৎসবে যুক্ত করে।'],
                    ['icon' => 'fas fa-hands-helping', 'title' => 'স্থানীয় সহায়তা', 'description' => 'পূজা কমিটি ও স্বেচ্ছাসেবকদের বাস্তব প্রয়োজন পূরণে সহযোগিতা করে।'],
                    ['icon' => 'fas fa-seedling', 'title' => 'তরুণ অংশগ্রহণ', 'description' => 'তরুণদের সংস্কৃতি, সেবা ও নেতৃত্বের কাজে সক্রিয় করে।'],
                ],
                'goals' => ['স্থানীয় পূজা কমিটিকে সহায়তা করা', 'বাংলার উৎসব ও লোকঐতিহ্য সংরক্ষণ', 'নিরাপদ ও অন্তর্ভুক্তিমূলক আয়োজন গড়া', 'সাংস্কৃতিক অনুষ্ঠানকে উৎসাহ দেওয়া', 'তরুণ স্বেচ্ছাসেবক তৈরি করা', 'সম্প্রীতি ও সামাজিক দায়িত্ব বাড়ানো'],
                'cta' => 'একসঙ্গে আমরা দুর্গাপূজার ঐতিহ্য, সামাজিক সম্প্রীতি ও বাঙালির সাংস্কৃতিক পরিচয় ভবিষ্যৎ প্রজন্মের জন্য রক্ষা করতে পারি।',
            ],
            'language' => [
                'about' => [
                    'বাংলা ভাষা আমাদের পরিচয়, জ্ঞানচর্চা ও সাংস্কৃতিক আত্মমর্যাদার প্রধান ভিত্তি। এই উদ্যোগ ভাষার অধিকার, বাংলা শিক্ষা এবং দৈনন্দিন জীবনে বাংলার মর্যাদাপূর্ণ ব্যবহারকে শক্তিশালী করে।',
                    'আমরা শিক্ষামূলক আলোচনা, জনসচেতনতা, পাঠাভ্যাস এবং বাংলা ব্যবহারের পক্ষে প্রচারের মাধ্যমে শিশু, তরুণ ও সাধারণ মানুষের সঙ্গে কাজ করি।',
                    'আগামী দিনে আরও শিক্ষা প্রতিষ্ঠান, পরিবার ও স্থানীয় সংগঠনকে যুক্ত করে বাংলা শেখা ও ব্যবহারের সুযোগ প্রসারিত করার পরিকল্পনা রয়েছে।',
                ],
                'why' => [
                    ['icon' => 'fas fa-language', 'title' => 'ভাষার অধিকার', 'description' => 'শিক্ষা, পরিষেবা ও জনজীবনে বাংলার ন্যায্য ব্যবহার নিশ্চিত করতে সহায়তা করে।'],
                    ['icon' => 'fas fa-book-open', 'title' => 'বাংলা শিক্ষা', 'description' => 'নতুন প্রজন্মের পড়া, লেখা ও ভাষাবোধকে আরও সমৃদ্ধ করে।'],
                    ['icon' => 'fas fa-bullhorn', 'title' => 'জনসচেতনতা', 'description' => 'ভাষার গুরুত্ব ও দায়িত্ব সম্পর্কে সমাজে ইতিবাচক বার্তা পৌঁছে দেয়।'],
                    ['icon' => 'fas fa-feather-alt', 'title' => 'সাহিত্য ও সৃজন', 'description' => 'বাংলা সাহিত্য, প্রকাশনা ও সৃজনশীল চর্চাকে উৎসাহ দেয়।'],
                ],
                'goals' => ['বাংলা ভাষার মর্যাদা ও অধিকার রক্ষা', 'বাংলা শিক্ষার সুযোগ বৃদ্ধি', 'পাঠাভ্যাস ও সাহিত্যচর্চা উৎসাহিত করা', 'ভাষা সচেতনতা অভিযান পরিচালনা', 'তরুণদের বাংলা সৃজনে যুক্ত করা', 'ডিজিটাল মাধ্যমে বাংলার ব্যবহার বাড়ানো'],
                'cta' => 'একসঙ্গে আমরা বাংলা ভাষাকে শিক্ষা, কর্মক্ষেত্র ও জনজীবনে আরও শক্তিশালী করে ভবিষ্যৎ প্রজন্মের কাছে পৌঁছে দিতে পারি।',
            ],
            'youth' => [
                'about' => [
                    'তরুণদের শক্তি, সৃজনশীলতা ও নেতৃত্ব সমাজের ইতিবাচক পরিবর্তনের প্রধান চালিকা শক্তি। এই উদ্যোগ তাদের দক্ষতা ও সামাজিক দায়িত্ব বিকাশের বাস্তব সুযোগ তৈরি করে।',
                    'প্রশিক্ষণ, স্বেচ্ছাসেবা, সাংস্কৃতিক কর্মসূচি এবং সচেতনতামূলক কার্যক্রমের মাধ্যমে তরুণদের স্থানীয় সমস্যার সমাধানে যুক্ত করা হয়।',
                    'ভবিষ্যতে আরও নেতৃত্ব কর্মশালা, মেন্টরশিপ ও সমাজভিত্তিক প্রকল্প চালু করে একটি আত্মবিশ্বাসী ও দায়িত্বশীল প্রজন্ম গড়ে তোলাই লক্ষ্য।',
                ],
                'why' => [
                    ['icon' => 'fas fa-user-friends', 'title' => 'নেতৃত্ব বিকাশ', 'description' => 'তরুণদের পরিকল্পনা, সিদ্ধান্ত ও দল পরিচালনার অভিজ্ঞতা দেয়।'],
                    ['icon' => 'fas fa-lightbulb', 'title' => 'নতুন চিন্তা', 'description' => 'সমাজের চ্যালেঞ্জে সৃজনশীল ও বাস্তবসম্মত সমাধান উৎসাহিত করে।'],
                    ['icon' => 'fas fa-hands-helping', 'title' => 'স্বেচ্ছাসেবা', 'description' => 'মানুষের পাশে দাঁড়ানো ও সামাজিক দায়িত্বের অভ্যাস গড়ে তোলে।'],
                    ['icon' => 'fas fa-chart-line', 'title' => 'দক্ষতা বৃদ্ধি', 'description' => 'যোগাযোগ, সংগঠন ও প্রকল্প পরিচালনার দক্ষতা উন্নত করে।'],
                ],
                'goals' => ['তরুণ নেতৃত্ব তৈরি করা', 'স্বেচ্ছাসেবার সুযোগ বৃদ্ধি', 'সাংস্কৃতিক পরিচয়ের সঙ্গে সংযোগ গড়া', 'দক্ষতা উন্নয়ন কর্মশালা আয়োজন', 'সমাজভিত্তিক প্রকল্পে অংশগ্রহণ বাড়ানো', 'তরুণদের নতুন উদ্যোগে সহায়তা করা'],
                'cta' => 'তরুণদের ভাবনা ও উদ্যোগকে শক্তি দিলে আমরা আরও সচেতন, দক্ষ ও মানবিক আগামী নির্মাণ করতে পারি।',
            ],
            'culture' => [
                'about' => [
                    'বাংলার সংগীত, নৃত্য, নাটক, সাহিত্য ও লোকশিল্প আমাদের বহুমাত্রিক সাংস্কৃতিক পরিচয়ের জীবন্ত প্রকাশ। এই উদ্যোগ শিল্পী, দর্শক ও নতুন প্রজন্মের মধ্যে সেই উত্তরাধিকারের সেতু গড়ে তোলে।',
                    'নিয়মিত সাংস্কৃতিক অনুষ্ঠান, আলোচনা, প্রদর্শনী এবং স্থানীয় শিল্পীদের অংশগ্রহণের মাধ্যমে বাংলার সৃজনশীল ঐতিহ্যকে মানুষের কাছে পৌঁছে দেওয়া হয়।',
                    'ভবিষ্যতে নতুন শিল্পীদের জন্য আরও মঞ্চ, প্রশিক্ষণ ও আঞ্চলিক সাংস্কৃতিক বিনিময়ের সুযোগ তৈরির পরিকল্পনা রয়েছে।',
                ],
                'why' => [
                    ['icon' => 'fas fa-music', 'title' => 'জীবন্ত সংস্কৃতি', 'description' => 'সংগীত, নৃত্য ও নাটকের ধারাকে নিয়মিত চর্চার মধ্যে রাখে।'],
                    ['icon' => 'fas fa-palette', 'title' => 'শিল্পীর বিকাশ', 'description' => 'স্থানীয় ও নবীন শিল্পীদের কাজ তুলে ধরার সুযোগ সৃষ্টি করে।'],
                    ['icon' => 'fas fa-users', 'title' => 'সম্প্রদায়ের বন্ধন', 'description' => 'সাংস্কৃতিক অভিজ্ঞতার মাধ্যমে মানুষকে কাছাকাছি নিয়ে আসে।'],
                    ['icon' => 'fas fa-history', 'title' => 'ঐতিহ্যের ধারাবাহিকতা', 'description' => 'পুরোনো শিল্পরীতি ও গল্পকে নতুন প্রজন্মের সঙ্গে যুক্ত করে।'],
                ],
                'goals' => ['বাংলার শিল্প ও সংস্কৃতি উদযাপন', 'স্থানীয় শিল্পীদের মঞ্চ তৈরি', 'লোকঐতিহ্য নথিবদ্ধ ও সংরক্ষণ', 'তরুণ প্রতিভাকে উৎসাহ প্রদান', 'নিয়মিত সাংস্কৃতিক অনুষ্ঠান আয়োজন', 'সবার জন্য সংস্কৃতির সুযোগ বৃদ্ধি'],
                'cta' => 'একসঙ্গে আমরা বাংলার শিল্প, সাহিত্য ও জীবন্ত সংস্কৃতিকে আরও সমৃদ্ধ করে আগামী প্রজন্মের কাছে পৌঁছে দিতে পারি।',
            ],
            'community' => [
                'about' => [
                    'শক্তিশালী সমাজ গড়ে ওঠে পারস্পরিক সহযোগিতা, দায়িত্ব ও মানুষের সক্রিয় অংশগ্রহণের মাধ্যমে। এই উদ্যোগ স্থানীয় প্রয়োজনকে সামনে রেখে মানুষ ও সংগঠনকে একসঙ্গে কাজ করার সুযোগ দেয়।',
                    'সচেতনতা, সহায়তা, স্বেচ্ছাসেবা এবং সমাজকল্যাণমূলক কর্মসূচির মাধ্যমে বাস্তব সমস্যা চিহ্নিত করে সম্মিলিত সমাধান গড়ে তোলা হয়।',
                    'ভবিষ্যতে আরও এলাকায় অংশীদারিত্ব, স্বেচ্ছাসেবক দল এবং দীর্ঘমেয়াদি সমাজ উন্নয়ন প্রকল্প সম্প্রসারণের পরিকল্পনা রয়েছে।',
                ],
                'why' => [
                    ['icon' => 'fas fa-people-carry', 'title' => 'পারস্পরিক সহায়তা', 'description' => 'প্রয়োজনের সময় মানুষকে দ্রুত ও সংগঠিতভাবে পাশে পেতে সাহায্য করে।'],
                    ['icon' => 'fas fa-users', 'title' => 'সামাজিক সংযোগ', 'description' => 'স্থানীয় মানুষ, সংগঠন ও স্বেচ্ছাসেবকদের মধ্যে সহযোগিতা বাড়ায়।'],
                    ['icon' => 'fas fa-bullhorn', 'title' => 'সচেতন সমাজ', 'description' => 'অধিকার, স্বাস্থ্য ও সামাজিক দায়িত্ব সম্পর্কে তথ্য পৌঁছে দেয়।'],
                    ['icon' => 'fas fa-seedling', 'title' => 'টেকসই উন্নয়ন', 'description' => 'স্থানীয় সক্ষমতা বাড়িয়ে দীর্ঘমেয়াদি ইতিবাচক পরিবর্তন গড়ে তোলে।'],
                ],
                'goals' => ['স্থানীয় সমস্যায় সম্মিলিত উদ্যোগ নেওয়া', 'স্বেচ্ছাসেবক নেটওয়ার্ক গড়ে তোলা', 'সমাজকল্যাণ কর্মসূচি পরিচালনা', 'সচেতনতা ও তথ্যের সুযোগ বৃদ্ধি', 'তরুণ ও নারীর অংশগ্রহণ উৎসাহিত করা', 'দীর্ঘমেয়াদি সামাজিক উন্নয়ন নিশ্চিত করা'],
                'cta' => 'একসঙ্গে কাজ করলে আমরা আরও সহমর্মী, সংগঠিত ও শক্তিশালী সমাজ গড়ে তুলতে পারি।',
            ],
        ];
        $detailProfiles['general'] = $detailProfiles['community'];
        $detailFor = function ($card) use ($detailProfiles) {
            $identity = mb_strtolower(trim(($card['slug'] ?? '') . ' ' . ($card['title'] ?? '')), 'UTF-8');
            $matches = function ($terms) use ($identity) {
                foreach ($terms as $term) {
                    if (mb_stripos($identity, $term, 0, 'UTF-8') !== false) {
                        return true;
                    }
                }
                return false;
            };

            if ($matches(['দুর্গ', 'পূজা', 'puja', 'durga'])) {
                $profile = $detailProfiles['puja'];
            } elseif ($matches(['ভাষা', 'বাংলা শিক্ষা', 'language', 'education', 'শিক্ষা'])) {
                $profile = $detailProfiles['language'];
            } elseif ($matches(['যুব', 'তরুণ', 'youth'])) {
                $profile = $detailProfiles['youth'];
            } elseif ($matches(['সংস্কৃতি', 'সাংস্কৃতিক', 'অনুষ্ঠান', 'culture', 'music'])) {
                $profile = $detailProfiles['culture'];
            } else {
                $profile = $detailProfiles['community'];
            }

            $customAbout = $card['detailed_description'] ?? $card['objectives'] ?? [];
            $customAbout = is_array($customAbout) ? $customAbout : [$customAbout];
            $profile['about'] = array_slice(array_values(array_filter(array_merge($customAbout, $profile['about']))), 0, 3);

            if (!empty($card['why_it_matters']) && is_array($card['why_it_matters'])) {
                $profile['why'] = array_slice(array_merge($card['why_it_matters'], $profile['why']), 0, 4);
            }
            if (!empty($card['goals']) && is_array($card['goals'])) {
                $profile['goals'] = $card['goals'];
            }
            if (!empty($card['call_to_action'])) {
                $profile['cta'] = $card['call_to_action'];
            }

            $defaultHelp = [
                ['icon' => 'fas fa-hands-helping', 'title' => 'স্বেচ্ছাসেবক হোন', 'description' => $card['volunteer_info'] ?? 'সময় ও দক্ষতা দিয়ে কর্মসূচির বাস্তব কাজে অংশ নিন।'],
                ['icon' => 'fas fa-user-plus', 'title' => 'সদস্য হোন', 'description' => 'দীর্ঘমেয়াদি উদ্যোগ ও পরিকল্পনার সঙ্গে নিয়মিতভাবে যুক্ত থাকুন।'],
                ['icon' => 'fas fa-hand-holding-heart', 'title' => 'সহায়তা করুন', 'description' => 'সামর্থ্য অনুযায়ী প্রয়োজনীয় উপকরণ বা আর্থিক সহায়তা দিন।'],
                ['icon' => 'fas fa-bullhorn', 'title' => 'সচেতনতা ছড়ান', 'description' => 'পরিবার, বন্ধু ও সামাজিক পরিসরে উদ্যোগটির বার্তা পৌঁছে দিন।'],
            ];
            $customHelp = !empty($card['ways_to_help']) && is_array($card['ways_to_help'])
                ? $card['ways_to_help']
                : [];
            $profile['help'] = array_slice(array_merge($customHelp, $defaultHelp), 0, 4);

            return $profile;
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
                    @php
                        $cardImage = $imageName($card['image'] ?? null);
                        $cardDetail = $detailFor($card);
                    @endphp
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

                        <header class="heritage-detail-header">
                            <span class="heritage-detail-badge">{{ $card['category'] ?? $card['title'] ?? '' }}</span>
                            <h3 id="heritage-detail-title-{{ $cardIndex }}">{{ $card['title'] ?? '' }}</h3>
                            <p class="heritage-detail-intro">{{ $card['description'] ?? '' }}</p>
                        </header>

                        <div class="heritage-detail-body" tabindex="0">
                            <section class="heritage-detail-section heritage-detail-about">
                                <h4>এই উদ্যোগ সম্পর্কে</h4>
                                <div class="heritage-detail-copy">
                                    @foreach ($cardDetail['about'] as $paragraph)
                                        <p>{{ $paragraph }}</p>
                                    @endforeach
                                </div>
                            </section>
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
