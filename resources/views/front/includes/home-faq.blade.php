<section class="home-faq-section" aria-labelledby="home-faq-title">
    @php $homeFaqs = $faqSection['items'] ?? []; @endphp

    <div class="container">
        <div class="home-faq-layout">
            <div class="home-faq-intro">
                <span class="home-faq-label">
                    <i class="fas fa-cog" aria-hidden="true"></i>{{ $faqSection['label'] ?? 'প্রশ্নোত্তর' }}
                </span>
                <h2 id="home-faq-title">{{ $faqSection['heading'] ?? 'সচরাচর জিজ্ঞাসা' }}</h2>
                <span class="home-faq-flourish" aria-hidden="true"></span>
                <p>{{ $faqSection['description'] ?? '' }}</p>

                <div class="home-faq-contact">
                    <span class="home-faq-contact-icon" aria-hidden="true">
                        <i class="{{ $faqSection['help_icon'] ?? 'fas fa-headset' }}"></i>
                    </span>
                    <div>
                        <strong>{{ $faqSection['help_title'] ?? 'আরও প্রশ্ন আছে?' }}</strong>
                        <span>{{ $faqSection['help_subtitle'] ?? '' }}</span>
                        <a href="{{ $faqSection['help_button_url'] ?? route('front.contact') }}">
                            {{ $faqSection['help_button_text'] ?? 'যোগাযোগ করুন' }} <i class="fas fa-arrow-right" aria-hidden="true"></i>
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
                            <span class="home-faq-question-text">{{ $faq['question'] ?? '' }}</span>
                            <i class="fas fa-chevron-down home-faq-chevron" aria-hidden="true"></i>
                        </button>
                        <div class="home-faq-answer" id="home-faq-answer-{{ $faqIndex }}"
                            role="region" aria-labelledby="home-faq-question-{{ $faqIndex }}"
                            aria-hidden="{{ $isOpen ? 'false' : 'true' }}">
                            <div>
                                <p>{{ $faq['answer'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
