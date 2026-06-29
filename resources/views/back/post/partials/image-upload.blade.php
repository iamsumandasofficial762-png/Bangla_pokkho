@php
    $inputId = $inputId ?? 'blog-photo-input';
    $currentPhoto = $currentPhoto ?? null;
    $currentPhotoUrl = $currentPhoto ? url('storage/images/' . $currentPhoto) : '';
@endphp

@once
    <style>
        .blog-main-upload {
            --blog-upload-color: var(--primary, #db0000);
            margin-bottom: 24px;
        }

        .blog-main-upload__label {
            color: #1f2937;
            display: block;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .blog-main-upload__preview {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, .06);
            display: none;
            margin-bottom: 14px;
            max-width: 360px;
            overflow: hidden;
        }

        .blog-main-upload.has-preview .blog-main-upload__preview {
            display: block;
        }

        .blog-main-upload__image {
            aspect-ratio: 708 / 277;
            background: #f9fafb;
            display: block;
            object-fit: cover;
            width: 100%;
        }

        .blog-main-upload__meta {
            align-items: center;
            display: flex;
            gap: 10px;
            justify-content: space-between;
            padding: 10px 12px;
        }

        .blog-main-upload__name {
            color: #374151;
            font-size: 13px;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .blog-main-upload__remove {
            align-items: center;
            background: #ef4444;
            border: 0;
            border-radius: 999px;
            color: #fff;
            cursor: pointer;
            display: none;
            flex: 0 0 auto;
            font-size: 12px;
            font-weight: 700;
            gap: 6px;
            line-height: 1;
            padding: 8px 11px;
        }

        .blog-main-upload.has-new-file .blog-main-upload__remove {
            display: inline-flex;
        }

        .blog-main-upload__input {
            height: 1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            width: 1px;
        }

        .blog-main-upload__dropzone {
            align-items: center;
            background: #fff;
            border: 2px dashed rgba(219, 0, 0, .3);
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            gap: 16px;
            min-height: 126px;
            padding: 24px;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
            width: 100%;
        }

        .blog-main-upload__dropzone:hover,
        .blog-main-upload__dropzone.is-dragover,
        .blog-main-upload__input:focus + .blog-main-upload__dropzone {
            background: rgba(219, 0, 0, .035);
            border-color: var(--blog-upload-color);
            box-shadow: 0 0 0 4px rgba(219, 0, 0, .08);
        }

        .blog-main-upload__icon {
            align-items: center;
            background: rgba(219, 0, 0, .1);
            border-radius: 50%;
            color: var(--blog-upload-color);
            display: flex;
            flex: 0 0 54px;
            font-size: 24px;
            height: 54px;
            justify-content: center;
            width: 54px;
        }

        .blog-main-upload__copy {
            min-width: 0;
        }

        .blog-main-upload__title {
            color: #1f2937;
            display: block;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .blog-main-upload__help,
        .blog-main-upload__status {
            color: #6b7280;
            display: block;
            font-size: 12px;
            line-height: 1.5;
        }

        @media (max-width: 575px) {
            .blog-main-upload__dropzone {
                align-items: flex-start;
                flex-direction: column;
                padding: 20px;
            }

            .blog-main-upload__preview {
                max-width: 100%;
            }
        }
    </style>
@endonce

<div class="blog-main-upload {{ $currentPhotoUrl ? 'has-preview' : '' }}" data-blog-main-upload
    data-current-url="{{ $currentPhotoUrl }}" data-current-name="{{ $currentPhoto ?: __('Current blog image') }}">
    <label class="blog-main-upload__label" for="{{ $inputId }}">{{ __('Blog Main Image') }} *</label>

    <div class="blog-main-upload__preview" data-blog-main-preview aria-live="polite">
        <img class="blog-main-upload__image" data-blog-main-image src="{{ $currentPhotoUrl }}" alt="{{ __('Blog image') }}">
        <div class="blog-main-upload__meta">
            <span class="blog-main-upload__name" data-blog-main-name>{{ $currentPhoto ?: __('No image selected') }}</span>
            <button type="button" class="blog-main-upload__remove" data-blog-main-remove>
                <i class="fas fa-times" aria-hidden="true"></i>
                {{ __('Remove') }}
            </button>
        </div>
    </div>

    <input type="file" accept="image/jpeg,image/png,image/webp" class="blog-main-upload__input"
        name="photo" id="{{ $inputId }}" data-blog-main-input>

    <label class="blog-main-upload__dropzone" for="{{ $inputId }}" data-blog-main-dropzone>
        <span class="blog-main-upload__icon" aria-hidden="true"><i class="fas fa-cloud-upload-alt"></i></span>
        <span class="blog-main-upload__copy">
            <span class="blog-main-upload__title">{{ __('Click to upload or drag & drop') }}</span>
            <span class="blog-main-upload__help">{{ __('Supported formats: JPG, PNG, WEBP') }}</span>
            <span class="blog-main-upload__status" data-blog-main-status>
                {{ $currentPhoto ? __('Current image selected') : __('No image selected') }}
            </span>
        </span>
    </label>
</div>
