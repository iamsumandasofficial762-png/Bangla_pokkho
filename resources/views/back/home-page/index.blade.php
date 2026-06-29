@extends('master.back')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/back/css/select2.css') }}">
    <style>
        .home-editor-nav .nav-link { border: 1px solid #e5e7eb; border-radius: 0; color: #343a40; margin-bottom: 0; padding: 14px 18px; text-align: center; }
        .home-editor-nav .nav-link + .nav-link { border-top: 0; }
        .home-editor-nav .nav-link.active { background: #377dff; border-color: #377dff; color: #fff; }
        .home-editor-card { border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 18px; padding: 18px; }
        .home-editor-card h5 { font-weight: 700; margin-bottom: 16px; }
        .home-editor-grid { display: grid; gap: 0; grid-template-columns: 1fr; }
        .home-editor-panel { margin: 0 auto; max-width: 730px; }
        .home-editor-panel .form-group { margin-bottom: 20px; }
        .home-image-preview { background: #f8f9fa; border: 1px solid #e5e7eb; border-radius: 8px; display: inline-flex; min-height: 92px; min-width: 150px; overflow: hidden; }
        .home-image-preview:empty { display: none; }
        .home-image-preview img { display: block; height: 92px; object-fit: cover; width: 150px; }
        .home-upload { border: 1px dashed rgba(219, 0, 0, .45); border-radius: 8px; padding: 12px; }
        .home-upload-box { align-items: center; background: #fff; border: 1px dashed rgba(219, 0, 0, .45); border-radius: 8px; cursor: pointer; display: flex; gap: 14px; margin-top: 12px; min-height: 86px; padding: 16px; transition: border-color .2s ease, box-shadow .2s ease, background .2s ease; }
        .home-upload-box:hover, .home-upload-box:focus-within, .home-upload-box.is-dragover { background: rgba(219, 0, 0, .035); border-color: #db0000; box-shadow: 0 0 0 4px rgba(219, 0, 0, .08); }
        .home-upload-icon { align-items: center; background: rgba(219, 0, 0, .1); border-radius: 50%; color: #db0000; display: inline-flex; flex: 0 0 44px; height: 44px; justify-content: center; width: 44px; }
        .home-upload-title { color: #1f2937; display: block; font-weight: 700; }
        .home-upload-help, .home-upload-file { color: #6b7280; display: block; font-size: 12px; line-height: 1.5; }
        .home-upload .home-image-input { height: 1px; opacity: 0; overflow: hidden; position: absolute; width: 1px; }
        .home-repeat-item { background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 14px; padding: 14px; }
        .home-repeat-head { align-items: center; display: flex; justify-content: space-between; margin-bottom: 10px; }
        .home-toggle { align-items: center; display: flex; gap: 8px; margin-bottom: 18px; }
        .home-editor-help { color: #6c757d; font-size: 12px; }
        .home-editor-actions { border-top: 1px solid #e5e7eb; margin-top: 26px; padding-top: 24px; text-align: center; }
        .home-editor-panel .select2-container--bootstrap .select2-selection {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            box-shadow: none;
            min-height: 44px;
            padding: 4px 8px;
        }
        .home-editor-panel .select2-container--bootstrap.select2-container--focus .select2-selection,
        .home-editor-panel .select2-container--bootstrap.select2-container--open .select2-selection {
            border-color: #377dff;
            box-shadow: 0 0 0 3px rgba(55, 125, 255, .12);
        }
        .home-editor-panel .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice {
            background: #f8fafc;
            border: 1px solid #dbe3ef;
            border-radius: 999px;
            color: #1f2937;
            font-size: 12px;
            margin: 4px 6px 4px 0;
            padding: 5px 12px 5px 8px;
        }
        .home-editor-panel .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove {
            align-items: center;
            background: #e5e7eb;
            border-radius: 50%;
            color: #374151;
            display: inline-flex;
            font-size: 14px;
            font-weight: 700;
            height: 18px;
            justify-content: center;
            line-height: 1;
            margin-right: 7px;
            opacity: 1;
            text-align: center;
            width: 18px;
        }
        .home-editor-panel .select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove:hover {
            background: #db0000;
            color: #fff;
        }
        .home-editor-panel .select2-container--bootstrap .select2-search--inline .select2-search__field {
            margin-top: 7px;
        }
        @media (max-width: 767px) { .home-editor-nav { margin-bottom: 20px; } }
    </style>
@endsection

@section('content')
@php
    $imageUrl = function ($image) {
        return $image && file_exists(public_path('storage/images/' . $image))
            ? url('storage/images/' . $image)
            : null;
    };
    $selected = fn ($ids, $id) => in_array($id, array_map('intval', (array) $ids)) ? 'selected' : '';
@endphp

<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body">
            <h3 class="mb-0 bc-title"><b>{{ __('Home Page') }}</b></h3>
        </div>
    </div>

    <form class="admin-form" action="{{ route('back.homePage.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('alerts.alerts')

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-4">
                        <div class="nav flex-column nav-pills home-editor-nav" role="tablist">
                            <a class="nav-link active" data-toggle="pill" href="#recent-blog">Recent Blog</a>
                            <a class="nav-link" data-toggle="pill" href="#about-section">About Bangla Pokkho</a>
                            <a class="nav-link" data-toggle="pill" href="#heritage-section">Heritage & Initiatives</a>
                            <a class="nav-link" data-toggle="pill" href="#blog-carousel">Slider blogs</a>
                            <a class="nav-link" data-toggle="pill" href="#faq-section">FAQ</a>
                            <a class="nav-link" data-toggle="pill" href="#all-blog-section">Latest Posts</a>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-8">
                        <div class="tab-content home-editor-panel">
                            <div class="tab-pane fade show active" id="recent-blog">
                                @php $section = $sections['recent_blog']; @endphp
                                <div class="home-toggle">
                                    <input type="checkbox" name="sections[recent_blog][enabled]" value="1" {{ !empty($section['enabled']) ? 'checked' : '' }}>
                                    <strong>Enable Section</strong>
                                </div>
                                <div class="home-editor-grid">
                                    <div class="form-group"><label>Label</label><input class="form-control" name="sections[recent_blog][label]" value="{{ $section['label'] ?? '' }}"></div>
                                    <div class="form-group"><label>Heading</label><input class="form-control" name="sections[recent_blog][heading]" value="{{ $section['heading'] ?? '' }}"></div>
                                    <div class="form-group"><label>View All Text</label><input class="form-control" name="sections[recent_blog][view_all_text]" value="{{ $section['view_all_text'] ?? '' }}"></div>
                                </div>
                                <div class="home-editor-grid">
                                    <div class="form-group">
                                        <label>Post Mode</label>
                                        <select class="form-control" name="sections[recent_blog][post_mode]">
                                            <option value="latest" {{ ($section['post_mode'] ?? '') === 'latest' ? 'selected' : '' }}>Latest automatically</option>
                                            <option value="manual" {{ ($section['post_mode'] ?? '') === 'manual' ? 'selected' : '' }}>Manual selected posts</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Large Featured Post</label>
                                        <select class="form-control select2" name="sections[recent_blog][featured_post_id]">
                                            <option value="">Latest first post</option>
                                            @foreach($posts as $post)
                                                <option value="{{ $post->id }}" {{ (int)($section['featured_post_id'] ?? 0) === $post->id ? 'selected' : '' }}>{{ $post->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Small Post Selection</label>
                                    <select class="form-control select2" name="sections[recent_blog][post_ids][]" multiple>
                                        @foreach($posts as $post)
                                            <option value="{{ $post->id }}" {!! $selected($section['post_ids'] ?? [], $post->id) !!}>{{ $post->title }}</option>
                                        @endforeach
                                    </select>
                                    <span class="home-editor-help">Leave empty to show the latest posts.</span>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="about-section">
                                @php $section = $sections['about_section']; @endphp
                                <div class="home-toggle"><input type="checkbox" name="sections[about_section][enabled]" value="1" {{ !empty($section['enabled']) ? 'checked' : '' }}> <strong>Enable Section</strong></div>
                                <div class="home-editor-grid">
                                    <div class="form-group"><label>Subtitle</label><input class="form-control" name="sections[about_section][subtitle]" value="{{ $section['subtitle'] ?? '' }}"></div>
                                    <div class="form-group"><label>Heading</label><input class="form-control" name="sections[about_section][heading]" value="{{ $section['heading'] ?? '' }}"></div>
                                </div>
                                <div class="form-group"><label>Description</label><textarea class="form-control" rows="4" name="sections[about_section][description]">{{ $section['description'] ?? '' }}</textarea></div>
                                <div class="home-editor-grid">
                                    <div class="form-group home-upload">
                                        <label>Main Image</label><br>
                                        <span class="home-image-preview">@if($imageUrl($section['main_image'] ?? null))<img src="{{ $imageUrl($section['main_image']) }}" data-preview-target="main_image">@endif</span>
                                        <input type="file" class="form-control-file mt-2 home-image-input" name="images[about_section][main_image]" accept="image/jpeg,image/png,image/webp">
                                    </div>
                                </div>
                                <h5>Tabs</h5>
                                @foreach(($section['tabs'] ?? []) as $index => $tab)
                                    <div class="home-repeat-item">
                                        <input type="hidden" name="sections[about_section][tabs][{{ $index }}][key]" value="{{ $tab['key'] ?? 'tab' . $index }}">
                                        <div class="home-editor-grid">
                                            <div class="form-group"><label>Tab Name</label><input class="form-control" name="sections[about_section][tabs][{{ $index }}][name]" value="{{ $tab['name'] ?? '' }}"></div>
                                            <div class="form-group"><label>Title</label><input class="form-control" name="sections[about_section][tabs][{{ $index }}][title]" value="{{ $tab['title'] ?? '' }}"></div>
                                        </div>
                                        <div class="form-group"><label>Description</label><textarea class="form-control" name="sections[about_section][tabs][{{ $index }}][description]">{{ $tab['description'] ?? '' }}</textarea></div>
                                        <div class="form-group"><label>Bullet points, one per line</label><textarea class="form-control" rows="3" name="sections[about_section][tabs][{{ $index }}][bullets]">{{ implode("\n", $tab['bullets'] ?? []) }}</textarea></div>
                                        <div class="form-group home-upload">
                                            <label>Tab Image/Icon</label><br>
                                            <span class="home-image-preview">@if($imageUrl($tab['image'] ?? null))<img src="{{ $imageUrl($tab['image']) }}">@endif</span>
                                            <input type="file" class="form-control-file mt-2 home-image-input" name="images[about_section][tabs][{{ $index }}][image]" accept="image/jpeg,image/png,image/webp">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="tab-pane fade" id="heritage-section">
                                @php $section = $sections['heritage_cards']; @endphp
                                <div class="home-toggle"><input type="checkbox" name="sections[heritage_cards][enabled]" value="1" {{ !empty($section['enabled']) ? 'checked' : '' }}> <strong>Enable Section</strong></div>
                                <div class="home-editor-grid">
                                    <div class="form-group"><label>Label</label><input class="form-control" name="sections[heritage_cards][label]" value="{{ $section['label'] ?? '' }}"></div>
                                    <div class="form-group"><label>Heading</label><input class="form-control" name="sections[heritage_cards][heading]" value="{{ $section['heading'] ?? '' }}"></div>
                                </div>
                                <div class="form-group"><label>Description</label><textarea class="form-control" rows="3" name="sections[heritage_cards][description]">{{ $section['description'] ?? '' }}</textarea></div>
                                <h5>Cards</h5>
                                <div data-repeater="heritage-cards">
                                    <div class="home-repeat-list">
                                @foreach(($section['cards'] ?? []) as $index => $card)
                                    <div class="home-repeat-item">
                                        <div class="home-repeat-head"><strong>Card {{ $index + 1 }}</strong></div>
                                        <div class="home-editor-grid">
                                            <div class="form-group"><label>Title</label><input class="form-control" name="sections[heritage_cards][cards][{{ $index }}][title]" value="{{ $card['title'] ?? '' }}"></div>
                                            <div class="form-group"><label>Icon class</label><input class="form-control" name="sections[heritage_cards][cards][{{ $index }}][icon]" value="{{ $card['icon'] ?? '' }}"></div>
                                            <div class="form-group"><label>Button Text</label><input class="form-control" name="sections[heritage_cards][cards][{{ $index }}][button_text]" value="{{ $card['button_text'] ?? '' }}"></div>
                                        </div>
                                        <div class="form-group"><label>Description</label><textarea class="form-control" name="sections[heritage_cards][cards][{{ $index }}][description]">{{ $card['description'] ?? '' }}</textarea></div>
                                        <div class="form-group home-upload"><label>Image</label><br><span class="home-image-preview">@if($imageUrl($card['image'] ?? null))<img src="{{ $imageUrl($card['image']) }}">@endif</span><input type="file" class="form-control-file mt-2 home-image-input" name="images[heritage_cards][cards][{{ $index }}][image]" accept="image/jpeg,image/png,image/webp"></div>
                                    </div>
                                @endforeach
                                    </div>
                                </div>
                                <h5>Bottom Feature Strip</h5>
                                <div data-repeater="heritage-features">
                                    <div class="home-repeat-list">
                                @foreach(($section['features'] ?? []) as $index => $feature)
                                    <div class="home-repeat-item">
                                        <div class="home-repeat-head"><strong>Feature</strong></div>
                                        <div class="home-editor-grid">
                                            <div class="form-group"><label>Icon class</label><input class="form-control" name="sections[heritage_cards][features][{{ $index }}][icon]" value="{{ $feature['icon'] ?? '' }}"></div>
                                            <div class="form-group"><label>Title</label><input class="form-control" name="sections[heritage_cards][features][{{ $index }}][title]" value="{{ $feature['title'] ?? '' }}"></div>
                                            <div class="form-group"><label>Description</label><input class="form-control" name="sections[heritage_cards][features][{{ $index }}][description]" value="{{ $feature['description'] ?? '' }}"></div>
                                        </div>
                                    </div>
                                @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="blog-carousel">
                                @php $section = $sections['blog_carousel']; @endphp
                                <div class="home-toggle"><input type="checkbox" name="sections[blog_carousel][enabled]" value="1" {{ !empty($section['enabled']) ? 'checked' : '' }}> <strong>Enable Section</strong></div>
                                <div class="home-editor-grid">
                                    <div class="form-group"><label>Label</label><input class="form-control" name="sections[blog_carousel][label]" value="{{ $section['label'] ?? '' }}"></div>
                                    <div class="form-group"><label>Heading</label><input class="form-control" name="sections[blog_carousel][heading]" value="{{ $section['heading'] ?? '' }}"></div>
                                </div>
                                <div class="form-group"><label>Description</label><textarea class="form-control" name="sections[blog_carousel][description]">{{ $section['description'] ?? '' }}</textarea></div>
                                <div class="form-group"><label>View All Text</label><input class="form-control" name="sections[blog_carousel][view_all_text]" value="{{ $section['view_all_text'] ?? '' }}"></div>
                            </div>

                            <div class="tab-pane fade" id="faq-section">
                                @php $section = $sections['faq_section']; @endphp
                                <div class="home-toggle"><input type="checkbox" name="sections[faq_section][enabled]" value="1" {{ !empty($section['enabled']) ? 'checked' : '' }}> <strong>Enable Section</strong></div>
                                <div class="home-editor-grid">
                                    <div class="form-group"><label>Label</label><input class="form-control" name="sections[faq_section][label]" value="{{ $section['label'] ?? '' }}"></div>
                                    <div class="form-group"><label>Heading</label><input class="form-control" name="sections[faq_section][heading]" value="{{ $section['heading'] ?? '' }}"></div>
                                    <div class="form-group"><label>Help Icon</label><input class="form-control" name="sections[faq_section][help_icon]" value="{{ $section['help_icon'] ?? '' }}"></div>
                                </div>
                                <div class="form-group"><label>Description</label><textarea class="form-control" name="sections[faq_section][description]">{{ $section['description'] ?? '' }}</textarea></div>
                                <div class="home-editor-grid">
                                    <div class="form-group"><label>Help Title</label><input class="form-control" name="sections[faq_section][help_title]" value="{{ $section['help_title'] ?? '' }}"></div>
                                    <div class="form-group"><label>Help Subtitle</label><input class="form-control" name="sections[faq_section][help_subtitle]" value="{{ $section['help_subtitle'] ?? '' }}"></div>
                                    <div class="form-group"><label>Button Text</label><input class="form-control" name="sections[faq_section][help_button_text]" value="{{ $section['help_button_text'] ?? '' }}"></div>
                                </div>
                                <div data-repeater="faq">
                                    <div class="home-repeat-list">
                                        @foreach(($section['items'] ?? []) as $index => $item)
                                            <div class="home-repeat-item">
                                                <div class="home-repeat-head"><strong>FAQ</strong><button type="button" class="btn btn-sm btn-danger" data-remove-repeat>Remove</button></div>
                                                <div class="form-group"><label>Question</label><input class="form-control" name="sections[faq_section][items][{{ $index }}][question]" value="{{ $item['question'] ?? '' }}"></div>
                                                <div class="form-group"><label>Answer</label><textarea class="form-control" rows="3" name="sections[faq_section][items][{{ $index }}][answer]">{{ $item['answer'] ?? '' }}</textarea></div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-add-repeat="faq">Add More</button>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="all-blog-section">
                                @php $section = $sections['all_blog_section']; @endphp
                                <div class="home-toggle"><input type="checkbox" name="sections[all_blog_section][enabled]" value="1" {{ !empty($section['enabled']) ? 'checked' : '' }}> <strong>Enable Section</strong></div>
                                <div class="home-editor-grid">
                                    <div class="form-group"><label>Label</label><input class="form-control" name="sections[all_blog_section][label]" value="{{ $section['label'] ?? '' }}"></div>
                                    <div class="form-group"><label>Heading</label><input class="form-control" name="sections[all_blog_section][heading]" value="{{ $section['heading'] ?? '' }}"></div>
                                </div>
                                <div class="form-group"><label>Description</label><textarea class="form-control" name="sections[all_blog_section][description]">{{ $section['description'] ?? '' }}</textarea></div>
                                <div class="home-editor-grid">
                                    <div class="form-group"><label>Search Placeholder</label><input class="form-control" name="sections[all_blog_section][search_placeholder]" value="{{ $section['search_placeholder'] ?? '' }}"></div>
                                    <div class="form-group"><label>Category Placeholder</label><input class="form-control" name="sections[all_blog_section][category_placeholder]" value="{{ $section['category_placeholder'] ?? '' }}"></div>
                                    <div class="form-group"><label>Post Mode</label><select class="form-control" name="sections[all_blog_section][post_mode]"><option value="latest" {{ ($section['post_mode'] ?? '') === 'latest' ? 'selected' : '' }}>Latest</option><option value="manual" {{ ($section['post_mode'] ?? '') === 'manual' ? 'selected' : '' }}>Manual</option></select></div>
                                </div>
                                <div class="form-group"><label>Post Selection</label><select class="form-control select2" name="sections[all_blog_section][post_ids][]" multiple>@foreach($posts as $post)<option value="{{ $post->id }}" {!! $selected($section['post_ids'] ?? [], $post->id) !!}>{{ $post->title }}</option>@endforeach</select></div>
                            </div>
                        </div>

                        <div class="home-editor-actions">
                            <button type="submit" class="btn btn-secondary">Save Home Page</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/back/js/select2.js') }}"></script>
    <script>
        $('.select2').select2({ theme: 'bootstrap', width: '100%' });

        function renderSelectedImage(input) {
            var file = input.files && input.files[0];
            var upload = input.closest('.home-upload');
            var preview = upload ? upload.querySelector('.home-image-preview') : null;
            if (!file || !preview) return;

            var status = upload.querySelector('[data-upload-file]');
            if (status) status.textContent = file.name;

            preview.innerHTML = '';
            var image = document.createElement('img');
            image.src = URL.createObjectURL(file);
            image.onload = function () { URL.revokeObjectURL(image.src); };
            preview.appendChild(image);
        }

        function setDroppedFile(input, file) {
            if (!file || ['image/jpeg', 'image/png', 'image/webp'].indexOf(file.type) === -1) return;
            var transfer = new DataTransfer();
            transfer.items.add(file);
            input.files = transfer.files;
            renderSelectedImage(input);
        }

        document.querySelectorAll('.home-image-input').forEach(function (input, index) {
            if (!input.id) {
                input.id = 'home-image-input-' + index;
            }

            var box = document.createElement('label');
            box.className = 'home-upload-box';
            box.setAttribute('for', input.id);
            box.innerHTML =
                '<span class="home-upload-icon"><i class="fas fa-cloud-upload-alt" aria-hidden="true"></i></span>' +
                '<span>' +
                '<span class="home-upload-title">Click to upload image</span>' +
                '<span class="home-upload-help">Supported formats: JPG, PNG, WEBP</span>' +
                '<span class="home-upload-file" data-upload-file>No file selected</span>' +
                '</span>';

            input.parentNode.insertBefore(box, input);

            ['dragenter', 'dragover'].forEach(function (eventName) {
                box.addEventListener(eventName, function (event) {
                    event.preventDefault();
                    box.classList.add('is-dragover');
                });
            });

            ['dragleave', 'drop'].forEach(function (eventName) {
                box.addEventListener(eventName, function (event) {
                    event.preventDefault();
                    box.classList.remove('is-dragover');
                });
            });

            box.addEventListener('drop', function (event) {
                if (event.dataTransfer && event.dataTransfer.files.length) {
                    setDroppedFile(input, event.dataTransfer.files[0]);
                }
            });
        });

        document.querySelectorAll('.home-image-input').forEach(function (input) {
            input.addEventListener('change', function () {
                renderSelectedImage(input);
            });
        });

        document.addEventListener('change', function (event) {
            if (!event.target.matches('.home-image-input')) return;
            renderSelectedImage(event.target);
        });

        document.addEventListener('click', function (event) {
            if (event.target.matches('[data-remove-repeat]')) {
                event.target.closest('.home-repeat-item').remove();
            }

            if (event.target.matches('[data-add-repeat="faq"]')) {
                var list = document.querySelector('[data-repeater="faq"] .home-repeat-list');
                var index = list.querySelectorAll('.home-repeat-item').length;
                var wrapper = document.createElement('div');
                wrapper.className = 'home-repeat-item';
                wrapper.innerHTML =
                    '<div class="home-repeat-head"><strong>FAQ</strong><button type="button" class="btn btn-sm btn-danger" data-remove-repeat>Remove</button></div>' +
                    '<div class="form-group"><label>Question</label><input class="form-control" name="sections[faq_section][items][' + index + '][question]"></div>' +
                    '<div class="form-group"><label>Answer</label><textarea class="form-control" rows="3" name="sections[faq_section][items][' + index + '][answer]"></textarea></div>';
                list.appendChild(wrapper);
            }

        });
    </script>
@endsection
