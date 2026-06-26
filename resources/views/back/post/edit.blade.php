@extends('master.back')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h3 class=" mb-0 bc-title"><b>{{ __('Update Blog') }}</b> </h3>
                    <a class="btn btn-primary btn-sm" href="{{ route('back.post.index') }}"><i class="fas fa-chevron-left"></i>
                        {{ __('Back') }}</a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="row">

            <div class="col-xl-12 col-lg-12 col-md-12">

                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body ">
                        <!-- Nested Row within Card Body -->
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <form class="admin-form" action="{{ route('back.post.update', $post->id) }}" method="POST"
                                    enctype="multipart/form-data">

                                    @csrf

                                    @method('PUT')

                                    @include('alerts.alerts')

                                    @php
                                        $blogPhotos = json_decode($post->photo, true) ?: [];
                                        $mainBlogPhoto = $blogPhotos[array_key_first($blogPhotos)] ?? null;
                                    @endphp

                                    @include('back.post.partials.image-upload', [
                                        'inputId' => 'blog-photo-edit',
                                        'currentPhoto' => $mainBlogPhoto,
                                    ])
                                    <div class="form-group">
                                        <label for="title">{{ __('Title') }} *</label>
                                        <input type="text" name="title" class="form-control" id="title"
                                            placeholder="{{ __('Enter Title') }}" value="{{ $post->title }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="category_id">{{ __('Select Category') }} *</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="" selected disabled>{{ __('Select Category') }}</option>
                                            @foreach (DB::table('bcategories')->whereStatus(1)->get() as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="details">{{ __('Details') }} *</label>
                                        <textarea name="details" id="details" class="form-control text-editor" rows="5"
                                            placeholder="{{ __('Enter Details') }}">{{ $post->details }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="tags">{{ __('Tags') }}
                                        </label>
                                        <input type="text" name="tags" class="tags" id="tags"
                                            placeholder="{{ __('Tags') }}" value="{{ $post->tags }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_keywords">{{ __('Meta Keywords') }}
                                        </label>
                                        <input type="text" name="meta_keywords" class="tags" id="meta_keywords"
                                            placeholder="{{ __('Enter Meta Keywords') }}"
                                            value="{{ $post->meta_keywords }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_description">{{ __('Meta Description') }}
                                        </label>
                                        <textarea name="meta_descriptions" id="meta_descriptions" class="form-control" rows="5"
                                            placeholder="{{ __('Enter Meta Description') }}">{{ $post->meta_descriptions }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-secondary ">{{ __('Submit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    {{-- DELETE MODAL --}}

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirm-deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Confirm Delete?') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    {{ __('You are going to delete this image from gallery.') }} {{ __('Do you want to delete it?') }}
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="" class="d-inline btn-ok" method="POST">

                        @csrf

                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>

                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- DELETE MODAL ENDS --}}
@endsection

@section('scripts')
    @include('back.post.partials.image-upload-scripts')
@endsection
