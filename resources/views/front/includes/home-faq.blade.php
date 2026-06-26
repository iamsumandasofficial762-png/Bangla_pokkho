<section class="home-faq-section" aria-labelledby="home-faq-title">
    @php
        $homeFaqs = [
            [
                'question' => 'বাংলা পক্ষ কী?',
                'answer' => 'বাংলা পক্ষ একটি সামাজিক উদ্যোগ, যা বাঙালি সংস্কৃতি, ঐতিহ্য, ভাষা ও উত্তরাধিকার সংরক্ষণের পাশাপাশি সামাজিক উন্নয়ন ও ঐক্যের জন্য কাজ করে।',
            ],
            [
                'question' => 'বাংলা পক্ষের প্রধান লক্ষ্য কী?',
                'answer' => 'আমাদের প্রধান লক্ষ্য বাঙালি পরিচয় রক্ষা, বাংলা ভাষা ও সংস্কৃতির প্রসার, সমাজ উন্নয়নে সহায়তা এবং বাংলার ঐতিহ্য সম্পর্কে সচেতনতা তৈরি করা।',
            ],
            [
                'question' => 'আমি কীভাবে সদস্য হতে পারি?',
                'answer' => 'ওয়েবসাইটের মাধ্যমে আমাদের দলের সঙ্গে যোগাযোগ করে, সমাজভিত্তিক কর্মসূচিতে যুক্ত হয়ে অথবা বাংলা পক্ষের সদস্যপদ প্রক্রিয়া অনুসরণ করে আপনি সদস্য হতে পারেন।',
            ],
            [
                'question' => 'বাংলা পক্ষ কী ধরনের কর্মসূচি আয়োজন করে?',
                'answer' => 'আমরা সাংস্কৃতিক অনুষ্ঠান, সচেতনতা প্রচার, শিক্ষামূলক উদ্যোগ, সমাজ সহায়তা কর্মসূচি এবং বাঙালি ঐতিহ্য ও সামাজিক কল্যাণভিত্তিক আয়োজন করি।',
            ],
            [
                'question' => 'আমি কীভাবে বাংলা পক্ষকে সহায়তা করতে পারি?',
                'answer' => 'অনুষ্ঠানে যোগ দিয়ে, স্বেচ্ছাসেবক হয়ে, সচেতনতা ছড়িয়ে, সম্পদ দিয়ে সহায়তা করে এবং অন্যদের বাঙালি সংস্কৃতি ও মূল্যবোধ রক্ষায় উৎসাহিত করে আপনি সহায়তা করতে পারেন।',
            ],
            [
                'question' => 'আপডেট ও অনুষ্ঠানের খবর কোথায় পাব?',
                'answer' => 'নিয়মিত আপডেট, অনুষ্ঠান ঘোষণা এবং সমাজের খবরের জন্য আমাদের ওয়েবসাইট ও অফিসিয়াল সোশ্যাল মিডিয়া চ্যানেল অনুসরণ করতে পারেন।',
            ],
        ];
    @endphp

    <div class="container">
        <div class="home-faq-layout">
            <div class="home-faq-intro">
                <span class="home-faq-label">
                    <i class="fas fa-cog" aria-hidden="true"></i>প্রশ্নোত্তর
                </span>
                <h2 id="home-faq-title">সচরাচর জিজ্ঞাসা</h2>
                <span class="home-faq-flourish" aria-hidden="true"></span>
                <p>বাংলা পক্ষ, আমাদের উদ্যোগ এবং বাঙালি ঐতিহ্য সংরক্ষণ ও প্রসারে আপনি কীভাবে যুক্ত হতে পারেন, সে সম্পর্কে সাধারণ প্রশ্নের উত্তর জানুন।</p>

                <div class="home-faq-contact">
                    <span class="home-faq-contact-icon" aria-hidden="true">
                        <i class="fas fa-headset"></i>
                    </span>
                    <div>
                        <strong>আরও প্রশ্ন আছে?</strong>
                        <span>আমরা আপনাকে সাহায্য করতে প্রস্তুত।</span>
                        <a href="{{ route('front.contact') }}">
                            যোগাযোগ করুন <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="home-faq-accordion" data-home-faq-accordion>
                @foreach ($homeFaqs as $faqIndex => $faq)
                    @php $isOpen = $faqIndex === 0; @endphp
                    <div class="home-faq-item {{ $isOpen ? 'is-open' : '' }}">
                        <button class="home-faq-question" type="button"
                            id="home-faq-question-{{ $faqIndex }}"
                            aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                            aria-controls="home-faq-answer-{{ $faqIndex }}">
                            <span class="home-faq-toggle" aria-hidden="true"></span>
                            <span class="home-faq-question-text">{{ $faq['question'] }}</span>
                            <i class="fas fa-chevron-down home-faq-chevron" aria-hidden="true"></i>
                        </button>
                        <div class="home-faq-answer" id="home-faq-answer-{{ $faqIndex }}"
                            role="region" aria-labelledby="home-faq-question-{{ $faqIndex }}"
                            aria-hidden="{{ $isOpen ? 'false' : 'true' }}">
                            <div>
                                <p>{{ $faq['answer'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
