@extends('master.front')

@php
    $isAboutPage = request()->routeIs('front.page')
        && mb_strtolower((string) request()->route('slug'), 'UTF-8') === 'about-us';
@endphp

@section('title')
    {{ $page->title }}
@endsection

@if ($isAboutPage)
    @section('pagestyles')
        <style>
            .bangla-about {
                --about-accent: var(--theme-primary, #d51f2b);
                background: #fff;
                padding: clamp(58px, 7vw, 108px) 0;
            }

            .bangla-about__grid {
                align-items: center;
                display: grid;
                gap: clamp(42px, 6vw, 88px);
                grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
            }

            .bangla-about__visual {
                border: 1px solid #e1e1e1;
                box-shadow: 20px 22px 42px rgba(24, 28, 32, .11);
                height: clamp(480px, 43vw, 610px);
                margin: 0 14px 18px 0;
                padding: 13px;
            }

            .bangla-about__visual img {
                display: block;
                height: 100%;
                object-fit: cover;
                width: 100%;
            }

            .bangla-about__eyebrow {
                align-items: center;
                color: #25282c;
                display: flex;
                font-size: 16px;
                font-weight: 700;
                gap: 12px;
                margin: 0 0 18px;
            }

            .bangla-about__eyebrow::before {
                background: var(--about-accent);
                content: "";
                height: 2px;
                width: 34px;
            }

            .bangla-about__heading {
                color: #202328;
                font-size: clamp(36px, 3.3vw, 57px);
                font-weight: 800;
                letter-spacing: normal;
                line-height: 1.2;
                margin: 0 0 22px;
            }

            .bangla-about__intro {
                color: #666e76;
                font-size: 19px;
                line-height: 1.85;
                margin: 0 0 26px;
            }

            .bangla-about__tabs {
                border-bottom: 1px solid #d9dde0;
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                margin-bottom: 28px;
            }

            .bangla-about__tab {
                background: transparent;
                border: 0;
                color: #454a50;
                cursor: pointer;
                font-family: inherit;
                font-size: 20px;
                font-weight: 700;
                padding: 0 4px 15px;
                position: relative;
                text-align: left;
            }

            .bangla-about__tab::after {
                background: var(--about-accent);
                bottom: -1px;
                content: "";
                height: 3px;
                left: 0;
                position: absolute;
                transform: scaleX(0);
                transform-origin: left;
                transition: transform .2s ease;
                width: 100%;
            }

            .bangla-about__tab[aria-selected="true"] {
                color: #171a1e;
            }

            .bangla-about__tab[aria-selected="true"]::after {
                transform: scaleX(1);
            }

            .bangla-about__tab:focus-visible {
                outline: 2px solid var(--about-accent);
                outline-offset: 4px;
            }

            .bangla-about__panel[hidden] {
                display: none;
            }

            .bangla-about__panel-inner {
                align-items: start;
                display: grid;
                gap: 25px;
                grid-template-columns: 210px minmax(0, 1fr);
            }

            .bangla-about__panel-image {
                height: 205px;
                margin: 0;
                overflow: hidden;
            }

            .bangla-about__panel-image img {
                display: block;
                height: 100%;
                object-fit: cover;
                width: 100%;
            }

            .bangla-about__panel-copy p {
                color: #555d64;
                font-size: 17px;
                line-height: 1.72;
                margin: 0 0 15px;
            }

            .bangla-about__checklist {
                list-style: none;
                margin: 0;
                padding: 0;
            }

            .bangla-about__checklist li {
                color: #30353a;
                font-size: 16px;
                font-weight: 600;
                line-height: 1.55;
                margin: 9px 0;
                padding-left: 28px;
                position: relative;
            }

            .bangla-about__checklist li::before {
                color: var(--about-accent);
                content: "✓";
                font-family: Arial, sans-serif;
                font-size: 17px;
                font-weight: 700;
                left: 0;
                position: absolute;
                top: 0;
            }

            @media (max-width: 991px) {
                .bangla-about__grid {
                    grid-template-columns: 1fr;
                }

                .bangla-about__visual {
                    height: min(680px, 90vw);
                    margin-right: 0;
                }
            }

            @media (max-width: 575px) {
                .bangla-about {
                    padding: 42px 0 56px;
                }

                .bangla-about__visual {
                    height: 108vw;
                    max-height: 520px;
                    padding: 8px;
                }

                .bangla-about__heading {
                    font-size: 34px;
                }

                .bangla-about__intro {
                    font-size: 17px;
                    line-height: 1.7;
                }

                .bangla-about__tab {
                    font-size: 17px;
                    text-align: center;
                }

                .bangla-about__panel-inner {
                    grid-template-columns: 1fr;
                }

                .bangla-about__panel-image {
                    height: 230px;
                }
            }
        </style>
    @endsection
@endif

@section('content')
    <!-- Page Title-->
<div class="page-title">
  <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <ul class="breadcrumbs">
                <li><a href="{{route('front.index')}}">হোম</a> </li>
                <li class="separator">&nbsp;</li>
                <li>{{$page->title}}</li>
              </ul>
        </div>
    </div>
  </div>
</div>
<!-- Page Content-->
@if ($isAboutPage)
    <section class="bangla-about" data-bangla-about>
        <div class="container">
            <div class="bangla-about__grid">
                <figure class="bangla-about__visual">
                    <img src="{{ asset('storage/images/DDRmd6072cda-3ee2-4e00-baac-0c4b0ca0370.jpeg') }}"
                        alt="বাংলা ভাষা, সংস্কৃতি ও ঐতিহ্যের চিত্র">
                </figure>

                <div class="bangla-about__content">
                    <p class="bangla-about__eyebrow">বাংলা পক্ষ সম্পর্কে</p>
                    <h1 class="bangla-about__heading">বাঙালি পরিচয়, ভাষা ও অধিকারের পক্ষে আমরা</h1>
                    <p class="bangla-about__intro">বাংলা পক্ষ বাঙালির ভাষা, সংস্কৃতি, অধিকার ও ন্যায্য প্রতিনিধিত্ব রক্ষায় কাজ করে। আমরা সচেতনতা তৈরি করি, প্রচারাভিযান সংগঠিত করি এবং বাংলা ও বাঙালি পরিচয়কে ভালোবাসা মানুষদের একত্র করি।</p>

                    <div class="bangla-about__tabs" role="tablist" aria-label="বাংলা পক্ষের পরিচিতি">
                        <button class="bangla-about__tab" id="about-tab-goal" type="button" role="tab"
                            aria-selected="true" aria-controls="about-panel-goal" data-about-tab="goal">লক্ষ্য</button>
                        <button class="bangla-about__tab" id="about-tab-movement" type="button" role="tab"
                            aria-selected="false" aria-controls="about-panel-movement" tabindex="-1"
                            data-about-tab="movement">আন্দোলন</button>
                        <button class="bangla-about__tab" id="about-tab-community" type="button" role="tab"
                            aria-selected="false" aria-controls="about-panel-community" tabindex="-1"
                            data-about-tab="community">সমাজ</button>
                    </div>

                    @php
                        $aboutTabs = [
                            'goal' => [
                                'text' => 'আমরা বাঙালির ভাষার অধিকার, সাংস্কৃতিক সচেতনতা এবং ন্যায্য প্রতিনিধিত্বকে গুরুত্ব দিই।',
                                'items' => ['বাংলা ভাষা ও সংস্কৃতির সুরক্ষা', 'জনসচেতনতা গড়ে তোলা', 'বাঙালির অধিকার ও প্রতিনিধিত্বের সমর্থন'],
                            ],
                            'movement' => [
                                'text' => 'আমাদের প্রচারাভিযান বাংলার ও বাঙালির গুরুত্বপূর্ণ সামাজিক, সাংস্কৃতিক এবং আঞ্চলিক বিষয়গুলো সামনে আনে।',
                                'items' => ['ভাষা ও অধিকারভিত্তিক প্রচার', 'সাংস্কৃতিক ঐতিহ্য রক্ষা', 'মানুষের অংশগ্রহণ বৃদ্ধি'],
                            ],
                            'community' => [
                                'text' => 'বাংলার ভবিষ্যতের জন্য ঐক্য ও দায়িত্ব নিয়ে কাজ করতে চান এমন মানুষদের আমরা একত্র করি।',
                                'items' => ['সামাজিক সংযোগ তৈরি', 'তরুণ প্রজন্মকে সচেতন করা', 'বাংলার স্বার্থে সম্মিলিত উদ্যোগ'],
                            ],
                        ];
                    @endphp

                    @foreach ($aboutTabs as $tabKey => $tab)
                        <div class="bangla-about__panel" id="about-panel-{{ $tabKey }}" role="tabpanel"
                            aria-labelledby="about-tab-{{ $tabKey }}" data-about-panel="{{ $tabKey }}"
                            @if ($tabKey !== 'goal') hidden @endif>
                            <div class="bangla-about__panel-inner">
                                <figure class="bangla-about__panel-image">
                                    <img src="{{ asset('storage/images/v5CKWhatsAppImage2026-06-29at2.01.59PM.jpeg') }}"
                                        alt="বাঙালির সামাজিক ও সাংস্কৃতিক ঐক্য">
                                </figure>
                                <div class="bangla-about__panel-copy">
                                    <p>{{ $tab['text'] }}</p>
                                    <ul class="bangla-about__checklist">
                                        @foreach ($tab['items'] as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@else
    <div class="">
        <div class="container other-page-data">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-5">
                        <div class="card-body px-3 py-5">
                            <div class="d-page-content">
                                <h4 class="d-block text-center"><b>{{ $page->title }}</b></h4>
                                {!! $page->details !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@if ($isAboutPage)
    @section('script')
        <script>
            (() => {
                const section = document.querySelector('[data-bangla-about]');
                if (!section) return;

                const tabs = [...section.querySelectorAll('[data-about-tab]')];
                const panels = [...section.querySelectorAll('[data-about-panel]')];

                tabs.forEach((tab) => {
                    tab.addEventListener('click', () => {
                        const selected = tab.dataset.aboutTab;

                        tabs.forEach((item) => {
                            const active = item === tab;
                            item.setAttribute('aria-selected', active ? 'true' : 'false');
                            item.tabIndex = active ? 0 : -1;
                        });

                        panels.forEach((panel) => {
                            panel.hidden = panel.dataset.aboutPanel !== selected;
                        });
                    });
                });
            })();
        </script>
    @endsection
@endif
