<?php

namespace App\Support;

use App\Models\HomePageSection;
use App\Models\Post;
use Illuminate\Support\Arr;

class HomePageContent
{
    public static function keys()
    {
        return [
            'recent_blog',
            'about_section',
            'heritage_cards',
            'blog_carousel',
            'faq_section',
            'all_blog_section',
        ];
    }

    public static function all()
    {
        $stored = HomePageSection::whereIn('section_key', self::keys())
            ->get()
            ->keyBy('section_key');

        return collect(self::defaults())->mapWithKeys(function ($default, $key) use ($stored) {
            $section = $stored->get($key);
            $data = $section ? array_replace_recursive($default, $section->data ?: []) : $default;
            $data['enabled'] = $section ? (bool) $section->is_enabled : (bool) ($default['enabled'] ?? true);

            return [$key => $data];
        })->all();
    }

    public static function section($key)
    {
        $sections = self::all();

        return $sections[$key] ?? (self::defaults()[$key] ?? []);
    }

    public static function imageUrl($fileName, $fallback = null)
    {
        $fileName = $fileName ?: $fallback;

        if (!$fileName || !file_exists(public_path('storage/images/' . $fileName))) {
            return null;
        }

        return url('storage/images/' . $fileName);
    }

    public static function postsFor(array $config, $count = 5, $skipIds = [])
    {
        $mode = $config['post_mode'] ?? 'latest';
        $ids = collect($config['post_ids'] ?? [])
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        if (($mode === 'manual' || $ids->isNotEmpty()) && $ids->isNotEmpty()) {
            $posts = Post::with('category')->whereIn('id', $ids)->get()->keyBy('id');

            return $ids->map(fn ($id) => $posts->get($id))->filter()->take($count)->values();
        }

        return Post::with('category')
            ->when(!empty($skipIds), fn ($query) => $query->whereNotIn('id', $skipIds))
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->take($count)
            ->get();
    }

    public static function defaults()
    {
        return [
            'recent_blog' => [
                'enabled' => true,
                'label' => 'ব্লগ থেকে',
                'heading' => 'সাম্প্রতিক ব্লগ পোস্ট',
                'view_all_text' => 'সব পোস্ট দেখুন',
                'view_all_url' => route('front.blog'),
                'post_mode' => 'latest',
                'featured_post_id' => null,
                'post_ids' => [],
            ],
            'about_section' => [
                'enabled' => true,
                'subtitle' => 'বাংলা পক্ষ সম্পর্কে',
                'heading' => 'বাঙালি পরিচয়, ভাষা ও অধিকারের পক্ষে আমরা',
                'description' => 'বাংলা পক্ষ বাঙালি ভাষা, সংস্কৃতি, অধিকার ও প্রতিনিধিত্ব রক্ষায় কাজ করে। আমরা সচেতনতা তৈরি করি, প্রচারাভিযান সংগঠিত করি এবং বাংলা ও বাঙালি পরিচয়কে ভালোবাসা মানুষদের যুক্ত করি।',
                'main_image' => '1632349684media_7-768x512.jpg',
                'decorative_image' => 'nouka_w.png',
                'tabs' => [
                    [
                        'key' => 'mission',
                        'name' => 'লক্ষ্য',
                        'title' => 'আমাদের লক্ষ্য',
                        'description' => 'আমরা বাঙালির ভাষার অধিকার, সাংস্কৃতিক সচেতনতা এবং ন্যায্য প্রতিনিধিত্বকে গুরুত্ব দিই।',
                        'bullets' => ['বাংলা ভাষা ও সংস্কৃতির সুরক্ষা', 'জনসচেতনতা গড়ে তোলা', 'বাঙালির অধিকার ও প্রতিনিধিত্বকে সমর্থন'],
                        'image' => '1632349673media_5-768x512.jpg',
                    ],
                    [
                        'key' => 'movement',
                        'name' => 'আন্দোলন',
                        'title' => 'আমাদের আন্দোলন',
                        'description' => 'আমাদের প্রচারাভিযান বাংলার ও বাঙালির গুরুত্বপূর্ণ সামাজিক, সাংস্কৃতিক এবং আঞ্চলিক বিষয়গুলো সামনে আনে।',
                        'bullets' => ['প্রচারাভিযান ও জনসম্পৃক্ত কর্মসূচি আয়োজন', 'তথ্য ও শিক্ষামূলক বিষয় শেয়ার করা', 'মানুষকে অংশগ্রহণে উৎসাহ দেওয়া'],
                        'image' => '1632349704media_21-768x512.jpg',
                    ],
                    [
                        'key' => 'community',
                        'name' => 'সমাজ',
                        'title' => 'আমাদের সমাজ',
                        'description' => 'বাংলার ভবিষ্যতের জন্য ঐক্য ও দায়িত্ব নিয়ে কাজ করতে চান এমন মানুষদের আমরা একত্র করি।',
                        'bullets' => ['সমর্থক ও স্বেচ্ছাসেবকদের যুক্ত করা', 'বাঙালি গর্বকে এগিয়ে নেওয়া', 'সমাজের অংশগ্রহণ শক্তিশালী করা'],
                        'image' => '1632349716media_23-768x512.jpg',
                    ],
                ],
            ],
            'heritage_cards' => [
                'enabled' => true,
                'label' => 'বাংলা পক্ষ',
                'heading' => 'বাঙালি ঐতিহ্য রক্ষা, প্রজন্মকে অনুপ্রাণিত করা',
                'description' => 'বাংলা পক্ষ বাঙালি সংস্কৃতি, ঐতিহ্য ও মূল্যবোধকে উদযাপন করতে নিবেদিত। আসুন, একসঙ্গে আরও শক্তিশালী ও গর্বিত বাঙালি সমাজ গড়ে তুলি।',
                'cards' => [
                    ['title' => 'দুর্গাপূজা সহায়তা', 'description' => 'যে ঐতিহ্য বাংলাকে একসূত্রে বাঁধে, সেই দুর্গাপূজা উদযাপনে আমরা সমাজের পাশে থাকি।', 'image' => '1632349684media_7-768x512.jpg', 'icon' => 'fas fa-hands-helping', 'button_text' => 'আরও জানুন', 'button_url' => '#'],
                    ['title' => 'সাংস্কৃতিক অনুষ্ঠান', 'description' => 'বাংলা শিল্প, সাহিত্য, সংগীত, নৃত্য ও সাংস্কৃতিক ঐতিহ্যের বিকাশ।', 'image' => '1632349704media_21-768x512.jpg', 'icon' => 'fas fa-music', 'button_text' => 'আরও জানুন', 'button_url' => '#'],
                    ['title' => 'শিক্ষা ও সচেতনতা', 'description' => 'বাংলার ইতিহাস, ভাষা, সাহিত্য এবং মহান ব্যক্তিত্ব সম্পর্কে জ্ঞান ছড়িয়ে দেওয়া।', 'image' => '1632349673media_5-768x512.jpg', 'icon' => 'fas fa-book-open', 'button_text' => 'আরও জানুন', 'button_url' => '#'],
                    ['title' => 'সমাজ উদ্যোগ', 'description' => 'সামাজিক কল্যাণ, শক্তিশালী সমাজ এবং অর্থবহ উন্নয়নের জন্য একসঙ্গে কাজ করা।', 'image' => '1632349716media_23-768x512.jpg', 'icon' => 'fas fa-users', 'button_text' => 'আরও জানুন', 'button_url' => '#'],
                ],
                'features' => [
                    ['title' => 'মূল্যবোধে দৃঢ়', 'description' => 'সততা, নিষ্ঠা ও সম্মান আমাদের প্রতিটি কাজে পথ দেখায়।', 'icon' => 'fas fa-shield-alt'],
                    ['title' => 'একসঙ্গে এগিয়ে চলা', 'description' => 'বাঙালি গর্বে ঐক্যবদ্ধ হয়ে আমরা আরও শক্তিশালী সমাজ গড়ি।', 'icon' => 'fas fa-users'],
                    ['title' => 'ঐতিহ্যে গর্বিত', 'description' => 'বাংলার সমৃদ্ধ উত্তরাধিকার আমরা উদযাপন ও সংরক্ষণ করি।', 'icon' => 'fas fa-landmark'],
                    ['title' => 'উন্নত আগামীর জন্য', 'description' => 'সবার জন্য উজ্জ্বল ও অন্তর্ভুক্তিমূলক ভবিষ্যতের অঙ্গীকার।', 'icon' => 'fas fa-heart'],
                ],
            ],
            'blog_carousel' => [
                'enabled' => true,
                'label' => 'ব্লগ থেকে',
                'heading' => 'আরও ব্লগ পোস্ট',
                'description' => 'বাংলা পক্ষের অনুপ্রেরণামূলক গল্প, বাঙালি সংস্কৃতি, ইতিহাস, ঐতিহ্য এবং সমাজের খবর পড়ুন।',
                'view_all_text' => 'সব পোস্ট দেখুন',
                'view_all_url' => route('front.blog'),
                'post_mode' => 'latest',
                'post_ids' => [],
                'post_count' => 3,
            ],
            'faq_section' => [
                'enabled' => true,
                'label' => 'প্রশ্নোত্তর',
                'heading' => 'সচরাচর জিজ্ঞাসা',
                'description' => 'বাংলা পক্ষ, আমাদের উদ্যোগ এবং বাঙালি ঐতিহ্য সংরক্ষণ ও প্রসারে আপনি কীভাবে যুক্ত হতে পারেন, সে সম্পর্কে সাধারণ প্রশ্নের উত্তর জানুন।',
                'help_icon' => 'fas fa-headset',
                'help_title' => 'আরও প্রশ্ন আছে?',
                'help_subtitle' => 'আমরা আপনাকে সাহায্য করতে প্রস্তুত।',
                'help_button_text' => 'যোগাযোগ করুন',
                'help_button_url' => route('front.contact'),
                'items' => [
                    ['question' => 'বাংলা পক্ষ কী?', 'answer' => 'বাংলা পক্ষ একটি সামাজিক উদ্যোগ, যা বাঙালি সংস্কৃতি, ঐতিহ্য, ভাষা ও উত্তরাধিকার সংরক্ষণের পাশাপাশি সামাজিক উন্নয়ন ও ঐক্যের জন্য কাজ করে।'],
                    ['question' => 'বাংলা পক্ষের প্রধান লক্ষ্য কী?', 'answer' => 'আমাদের প্রধান লক্ষ্য বাঙালি পরিচয় রক্ষা, বাংলা ভাষা ও সংস্কৃতির প্রসার, সমাজ উন্নয়নে সহায়তা এবং বাংলার ঐতিহ্য সম্পর্কে সচেতনতা তৈরি করা।'],
                    ['question' => 'আমি কীভাবে সদস্য হতে পারি?', 'answer' => 'ওয়েবসাইটের মাধ্যমে আমাদের দলের সঙ্গে যোগাযোগ করে অথবা সমাজভিত্তিক কর্মসূচিতে যুক্ত হয়ে আপনি সদস্য হতে পারেন।'],
                ],
            ],
            'all_blog_section' => [
                'enabled' => true,
                'label' => 'ব্লগ',
                'heading' => 'আমাদের ব্লগের সর্বশেষ পোস্ট',
                'description' => 'বাঙালি ঐতিহ্য উদযাপন ও সমাজকে শক্তিশালী করার পথে বাংলা পক্ষের গল্প, খবর ও ভাবনা পড়ুন।',
                'search_placeholder' => 'ব্লগ খুঁজুন',
                'category_placeholder' => 'সব ক্যাটাগরি',
                'post_mode' => 'latest',
                'post_ids' => [],
                'post_count' => 3,
            ],
        ];
    }
}
