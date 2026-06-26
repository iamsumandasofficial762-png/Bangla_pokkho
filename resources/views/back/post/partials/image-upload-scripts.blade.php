<script>
    (function () {
        'use strict';

        function isAllowedImage(file) {
            return ['image/jpeg', 'image/png', 'image/webp'].indexOf(file.type) !== -1;
        }

        document.querySelectorAll('[data-blog-main-upload]').forEach(function (field) {
            var input = field.querySelector('[data-blog-main-input]');
            var dropzone = field.querySelector('[data-blog-main-dropzone]');
            var preview = field.querySelector('[data-blog-main-preview]');
            var image = field.querySelector('[data-blog-main-image]');
            var name = field.querySelector('[data-blog-main-name]');
            var status = field.querySelector('[data-blog-main-status]');
            var remove = field.querySelector('[data-blog-main-remove]');
            var currentUrl = field.getAttribute('data-current-url') || '';
            var currentName = field.getAttribute('data-current-name') || '{{ __('Current blog image') }}';
            var objectUrl = '';

            if (!input || !dropzone || !preview || !image || !name || !status || !remove) return;

            function revokeObjectUrl() {
                if (objectUrl) {
                    URL.revokeObjectURL(objectUrl);
                    objectUrl = '';
                }
            }

            function showPreview(src, fileName, isNewFile) {
                image.src = src;
                image.alt = fileName;
                name.textContent = fileName;
                status.textContent = isNewFile ? fileName : '{{ __('Current image selected') }}';
                field.classList.add('has-preview');
                field.classList.toggle('has-new-file', isNewFile);
            }

            function clearPreview() {
                revokeObjectUrl();
                image.removeAttribute('src');
                name.textContent = '{{ __('No image selected') }}';
                status.textContent = '{{ __('No image selected') }}';
                field.classList.remove('has-preview', 'has-new-file');
            }

            function restoreCurrentImage() {
                input.value = '';
                if (currentUrl) {
                    showPreview(currentUrl, currentName, false);
                } else {
                    clearPreview();
                }
            }

            function setFile(file) {
                if (!file || !isAllowedImage(file)) {
                    input.value = '';
                    restoreCurrentImage();
                    return;
                }

                var newObjectUrl = URL.createObjectURL(file);
                revokeObjectUrl();
                objectUrl = newObjectUrl;
                showPreview(objectUrl, file.name, true);
            }

            input.addEventListener('change', function () {
                setFile(input.files[0]);
            });

            remove.addEventListener('click', restoreCurrentImage);

            ['dragenter', 'dragover'].forEach(function (eventName) {
                dropzone.addEventListener(eventName, function (event) {
                    event.preventDefault();
                    dropzone.classList.add('is-dragover');
                });
            });

            ['dragleave', 'drop'].forEach(function (eventName) {
                dropzone.addEventListener(eventName, function (event) {
                    event.preventDefault();
                    dropzone.classList.remove('is-dragover');
                });
            });

            dropzone.addEventListener('drop', function (event) {
                if (event.dataTransfer && event.dataTransfer.files.length) {
                    var transfer = new DataTransfer();
                    transfer.items.add(event.dataTransfer.files[0]);
                    input.files = transfer.files;
                    setFile(input.files[0]);
                }
            });
        });
    })();
</script>
