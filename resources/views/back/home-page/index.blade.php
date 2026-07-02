@extends('master.back')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/back/css/hero-slider-manager.css') }}?v={{ filemtime(public_path('assets/back/css/hero-slider-manager.css')) }}">
@endsection

@section('content')
    @php
        $editing = $selectedSlider->exists;
        $value = fn (string $field, $default = '') => old($field, $selectedSlider->{$field} ?? $default);
        $enabled = old('enabled', $selectedSlider->status !== 'inactive');
        $overlayEnabled = old('overlay_enabled', $selectedSlider->overlay_enabled ?? true);
        $imageUrl = $editing ? $selectedSlider->background_image_url : '';
        $icons = [
            'bi-people', 'bi-book', 'bi-megaphone', 'bi-tree', 'bi-heart', 'bi-star', 'bi-globe',
            'bi-shield-check', 'bi-lightbulb', 'bi-flag', 'fas fa-users', 'fas fa-book-open',
            'fas fa-fist-raised', 'fas fa-seedling', 'fas fa-heart', 'fas fa-star', 'fas fa-globe',
            'fas fa-shield-alt', 'fas fa-lightbulb', 'fas fa-flag',
        ];
    @endphp

    <div class="container-fluid hero-manager">
        <div class="card mb-4">
            <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                <div>
                    <h3 class="mb-1 bc-title"><b>{{ __('Hero Slider') }}</b></h3>
                    <p class="text-muted mb-0">{{ __('Manage every visible part of the homepage hero slider.') }}</p>
                </div>
                <a class="btn btn-primary mt-2 mt-sm-0" href="{{ route('back.homePage', ['new' => 1]) }}">
                    <i class="fas fa-plus mr-1"></i>{{ __('Create New Slide') }}
                </a>
            </div>
        </div>

        @include('alerts.alerts')

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>{{ __('Please correct the highlighted fields.') }}</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="hero-manager-layout">
            <aside class="card hero-slide-library">
                <div class="card-header">
                    <div>
                        <h5 class="mb-0">{{ __('Slides') }}</h5>
                        <small class="text-muted">{{ __('Drag cards to reorder') }}</small>
                    </div>
                    <span class="badge badge-light">{{ $sliders->count() }}</span>
                </div>
                <div class="card-body p-2">
                    <div class="hero-slide-list" data-slide-list data-sort-url="{{ route('back.hero-sliders.sort') }}">
                        @forelse ($sliders as $slider)
                            <article class="hero-slide-card {{ $editing && $selectedSlider->is($slider) ? 'is-selected' : '' }}"
                                data-slide-id="{{ $slider->id }}">
                                <button type="button" class="hero-drag-handle" data-drag-handle
                                    aria-label="{{ __('Drag to reorder') }}" title="{{ __('Drag to reorder') }}">
                                    <i class="fas fa-grip-vertical"></i>
                                </button>
                                <img src="{{ $slider->background_image_url }}" alt="">
                                <div class="hero-slide-card-body">
                                    <a href="{{ route('back.homePage', ['slide' => $slider->id]) }}"
                                        class="hero-slide-card-title">{{ $slider->title_top }}</a>
                                    <div class="hero-slide-meta">
                                        <span class="badge {{ $slider->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                            {{ ucfirst($slider->status) }}
                                        </span>
                                        <span>#{{ $slider->sort_order }}</span>
                                    </div>
                                    <div class="hero-slide-actions">
                                        <a class="btn btn-xs btn-outline-primary"
                                            href="{{ route('back.homePage', ['slide' => $slider->id]) }}"
                                            title="{{ __('Edit') }}"><i class="fas fa-pen"></i></a>
                                        <button class="btn btn-xs btn-outline-info" type="button"
                                            onclick="document.getElementById('duplicate-slide-{{ $slider->id }}').submit()"
                                            title="{{ __('Duplicate') }}"><i class="far fa-copy"></i></button>
                                        <button class="btn btn-xs btn-outline-danger" type="button"
                                            data-delete-slide="delete-slide-{{ $slider->id }}"
                                            title="{{ __('Delete') }}"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="hero-empty-state">
                                <i class="far fa-images"></i>
                                <p>{{ __('No hero slides yet.') }}</p>
                                <a href="{{ route('back.homePage', ['new' => 1]) }}">{{ __('Create the first slide') }}</a>
                            </div>
                        @endforelse
                    </div>
                    <p class="hero-sort-message mb-0" data-sort-message aria-live="polite"></p>
                </div>
            </aside>

            <section class="card hero-slide-editor">
                <form action="{{ $editing ? route('back.hero-sliders.update', $selectedSlider) : route('back.hero-sliders.store') }}"
                    method="POST" enctype="multipart/form-data" data-hero-form>
                    @csrf
                    @if ($editing)
                        @method('PUT')
                    @endif

                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ $editing ? __('Edit Slide') : __('New Slide') }}</h5>
                            <small class="text-muted">{{ __('Recommended background size: 1920×900') }}</small>
                        </div>
                        <button class="btn btn-primary" type="submit">
                            <i class="far fa-save mr-1"></i>{{ $editing ? __('Save Changes') : __('Create Slide') }}
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="hero-form-section">
                            <div class="hero-section-heading">
                                <span>01</span>
                                <div><h6>{{ __('Live Preview') }}</h6><small>{{ __('Updates instantly as you type') }}</small></div>
                            </div>
                            <div class="hero-live-preview" data-live-preview>
                                <img src="{{ $imageUrl }}" alt="" data-preview-image @if (!$imageUrl) hidden @endif>
                                <div class="hero-preview-placeholder" data-preview-placeholder @if ($imageUrl) hidden @endif>
                                    <i class="far fa-image"></i><span>{{ __('Choose a background image') }}</span>
                                </div>
                                <span class="hero-preview-overlay" data-preview-overlay></span>
                                <div class="hero-preview-content">
                                    <div data-preview-title-top>{{ $value('title_top', __('Small Heading')) }}</div>
                                    <strong data-preview-title>{{ $value('title', __('Main Hero Title')) }}</strong>
                                    <p data-preview-subtitle>{{ $value('subtitle', __('Subtitle / Description')) }}</p>
                                    <span class="hero-preview-button" data-preview-button>{{ $value('button_text', __('Button Text')) }} &rarr;</span>
                                </div>
                                <div class="hero-preview-features">
                                    @for ($index = 1; $index <= 4; $index++)
                                        <div>
                                            <i class="{{ $value("small_feature_icon_{$index}", 'fas fa-star') }}" data-preview-feature-icon="{{ $index }}"></i>
                                            <span><b data-preview-feature-title="{{ $index }}">{{ $value("small_feature_title_{$index}", __('Feature') . ' ' . $index) }}</b>
                                            <small data-preview-feature-description="{{ $index }}">{{ $value("small_feature_description_{$index}") }}</small></span>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <div class="hero-form-section">
                            <div class="hero-section-heading">
                                <span>02</span><div><h6>{{ __('General Settings') }}</h6></div>
                            </div>
                            <div class="hero-field-grid hero-field-grid--3">
                                <label class="hero-switch-field">
                                    <input type="hidden" name="enabled" value="0">
                                    <input type="checkbox" name="enabled" value="1" {{ $enabled ? 'checked' : '' }}>
                                    <span class="hero-switch"></span>
                                    <span><b>{{ __('Enable Slide') }}</b><small data-status-label>{{ $enabled ? __('Active') : __('Inactive') }}</small></span>
                                </label>
                                <div class="form-group">
                                    <label for="slide-status">{{ __('Status') }}</label>
                                    <input id="slide-status" class="form-control" value="{{ $enabled ? __('Active') : __('Inactive') }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="sort-order">{{ __('Sort Order') }}</label>
                                    <input id="sort-order" class="form-control @error('sort_order') is-invalid @enderror"
                                        type="number" min="0" name="sort_order" value="{{ $value('sort_order', 0) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="hero-form-section">
                            <div class="hero-section-heading">
                                <span>03</span><div><h6>{{ __('Text Content') }}</h6></div>
                            </div>
                            <div class="form-group">
                                <label for="title-top">{{ __('Small Heading') }} *</label>
                                <input id="title-top" class="form-control @error('title_top') is-invalid @enderror"
                                    name="title_top" maxlength="150" value="{{ $value('title_top') }}" data-preview-source="title-top" required>
                            </div>
                            <div class="form-group">
                                <label for="hero-title">{{ __('Main Hero Title') }} *</label>
                                <input id="hero-title" class="form-control @error('title') is-invalid @enderror"
                                    name="title" maxlength="200" value="{{ $value('title') }}" data-preview-source="title" required>
                            </div>
                            <div class="form-group">
                                <label for="hero-subtitle">{{ __('Subtitle / Description') }} *</label>
                                <textarea id="hero-subtitle" class="form-control @error('subtitle') is-invalid @enderror"
                                    name="subtitle" maxlength="1000" rows="3" data-preview-source="subtitle" required>{{ $value('subtitle') }}</textarea>
                            </div>
                            <div class="hero-field-grid">
                                <div class="form-group">
                                    <label for="button-text">{{ __('Button Text') }}</label>
                                    <input id="button-text" class="form-control" name="button_text" maxlength="100"
                                        value="{{ $value('button_text') }}" data-preview-source="button">
                                </div>
                                <div class="form-group">
                                    <label for="button-link">{{ __('Button URL') }}</label>
                                    <input id="button-link" class="form-control" name="button_link" maxlength="2048"
                                        value="{{ $value('button_link') }}" placeholder="/about-us or https://…">
                                </div>
                            </div>
                        </div>

                        <div class="hero-form-section">
                            <div class="hero-section-heading">
                                <span>04</span><div><h6>{{ __('Background Image') }}</h6><small>JPG, JPEG, PNG or WebP · {{ __('Maximum 5MB') }}</small></div>
                            </div>
                            <div class="hero-upload-zone @error('background_image') has-error @enderror"
                                data-upload-zone tabindex="0" role="button">
                                <input type="file" name="background_image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                    data-image-input {{ $editing ? '' : 'required' }}>
                                <div class="hero-upload-preview" data-upload-preview @if (!$imageUrl) hidden @endif>
                                    <img src="{{ $imageUrl }}" alt="{{ __('Background preview') }}">
                                </div>
                                <div class="hero-upload-copy">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <b>{{ __('Drag & drop an image here') }}</b>
                                    <span>{{ __('or') }} <u>{{ __('browse files') }}</u></span>
                                    <small data-file-name>{{ $imageUrl ? basename($selectedSlider->background_image) : __('No file selected') }}</small>
                                </div>
                            </div>
                            <div class="hero-upload-actions">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-browse-image>{{ $imageUrl ? __('Replace Image') : __('Browse') }}</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-remove-image @if (!$imageUrl) hidden @endif>{{ __('Remove Image') }}</button>
                            </div>
                        </div>

                        <div class="hero-form-section">
                            <div class="hero-section-heading">
                                <span>05</span><div><h6>{{ __('Overlay') }}</h6></div>
                            </div>
                            <div class="hero-field-grid hero-field-grid--overlay">
                                <label class="hero-switch-field">
                                    <input type="hidden" name="overlay_enabled" value="0">
                                    <input type="checkbox" name="overlay_enabled" value="1" data-overlay-enabled {{ $overlayEnabled ? 'checked' : '' }}>
                                    <span class="hero-switch"></span><span><b>{{ __('Overlay Enable') }}</b></span>
                                </label>
                                <div class="form-group">
                                    <label for="overlay-color">{{ __('Overlay Color') }}</label>
                                    <input id="overlay-color" class="form-control hero-color-input" type="color"
                                        name="overlay_color" value="{{ $value('overlay_color', '#000000') }}" data-overlay-color>
                                </div>
                                <div class="form-group">
                                    <label for="overlay-opacity">{{ __('Overlay Opacity') }}: <b data-opacity-value>{{ $value('overlay_opacity', 20) }}%</b></label>
                                    <input id="overlay-opacity" class="custom-range" type="range" min="0" max="100"
                                        name="overlay_opacity" value="{{ $value('overlay_opacity', 20) }}" data-overlay-opacity>
                                </div>
                            </div>
                        </div>

                        <div class="hero-form-section">
                            <div class="hero-section-heading">
                                <span>06</span><div><h6>{{ __('Bottom Feature Boxes') }}</h6><small>{{ __('Select a Bootstrap Icon or FontAwesome icon') }}</small></div>
                            </div>
                            <div class="hero-feature-editor-grid">
                                @for ($index = 1; $index <= 4; $index++)
                                    <fieldset class="hero-feature-editor">
                                        <legend>{{ __('Feature') }} {{ $index }}</legend>
                                        <div class="form-group">
                                            <label>{{ __('Icon Picker') }}</label>
                                            <div class="hero-icon-control">
                                                <button class="hero-current-icon" type="button" data-icon-toggle="{{ $index }}">
                                                    <i class="{{ $value("small_feature_icon_{$index}", 'fas fa-star') }}"></i>
                                                </button>
                                                <input class="form-control" name="small_feature_icon_{{ $index }}"
                                                    value="{{ $value("small_feature_icon_{$index}", 'fas fa-star') }}"
                                                    maxlength="100" data-icon-input="{{ $index }}" readonly>
                                            </div>
                                            <div class="hero-icon-picker" data-icon-picker="{{ $index }}" hidden>
                                                @foreach ($icons as $icon)
                                                    <button type="button" data-icon-class="{{ $icon }}" title="{{ $icon }}">
                                                        <i class="{{ $icon }}"></i>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Title') }}</label>
                                            <input class="form-control" name="small_feature_title_{{ $index }}" maxlength="100"
                                                value="{{ $value("small_feature_title_{$index}") }}" data-feature-title="{{ $index }}">
                                        </div>
                                        <div class="form-group mb-0">
                                            <label>{{ __('Description') }}</label>
                                            <textarea class="form-control" name="small_feature_description_{{ $index }}" maxlength="300"
                                                rows="2" data-feature-description="{{ $index }}">{{ $value("small_feature_description_{$index}") }}</textarea>
                                        </div>
                                    </fieldset>
                                @endfor
                            </div>
                        </div>

                        <div class="hero-save-bar">
                            <span>{{ __('Changes appear on the homepage after saving.') }}</span>
                            <button class="btn btn-primary" type="submit">
                                <i class="far fa-save mr-1"></i>{{ $editing ? __('Save Changes') : __('Create Slide') }}
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </div>

        @foreach ($sliders as $slider)
            <form id="duplicate-slide-{{ $slider->id }}" action="{{ route('back.hero-sliders.duplicate', $slider) }}" method="POST" hidden>@csrf</form>
            <form id="delete-slide-{{ $slider->id }}" action="{{ route('back.hero-sliders.destroy', $slider) }}" method="POST" hidden>
                @csrf @method('DELETE')
            </form>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        window.heroSliderManager = {
            csrfToken: @json(csrf_token()),
            deleteConfirm: @json(__('Delete this hero slide? This cannot be undone.')),
            sorting: @json(__('Saving order…')),
            sorted: @json(__('Slide order saved.')),
            sortFailed: @json(__('Could not save the slide order.')),
            imageTooLarge: @json(__('The image may not be larger than 5MB.')),
            imageInvalid: @json(__('Use a JPG, JPEG, PNG, or WebP image.')),
            active: @json(__('Active')),
            inactive: @json(__('Inactive'))
        };
    </script>
    <script src="{{ asset('assets/back/js/hero-slider-manager.js') }}?v={{ filemtime(public_path('assets/back/js/hero-slider-manager.js')) }}"></script>
@endsection
