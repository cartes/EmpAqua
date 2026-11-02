{{-- Recortador de logo: intercepta el input[name=picture] del formulario, abre un modal con Cropper.js
     y reemplaza el archivo por la imagen recortada (cuadrada) antes de enviar. --}}
@once
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <style>
        .logo-cropper-modal { position: fixed; inset: 0; z-index: 2000; display: none; align-items: center; justify-content: center; background: rgba(0,0,0,.6); padding: 1rem; }
        .logo-cropper-modal.is-open { display: flex; }
        .logo-cropper-box { background: #fff; border-radius: 10px; padding: 1.25rem; width: 100%; max-width: 520px; }
        .logo-cropper-stage { height: 340px; background: #f1f3f9; }
        .logo-cropper-stage img { max-width: 100%; display: block; }
        .logo-cropper-box .cropper-view-box, .logo-cropper-box .cropper-face { border-radius: 50%; }
        .logo-cropper-preview { width: 70px; height: 70px; border-radius: 50%; overflow: hidden; border: 3px solid #323D7E; background: #fff; flex: 0 0 auto; }
    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <script>
        (function () {
            var input = document.querySelector('input[type="file"][name="picture"]');
            if (!input || typeof Cropper === 'undefined') return;

            var modal = document.createElement('div');
            modal.className = 'logo-cropper-modal';
            modal.innerHTML =
                '<div class="logo-cropper-box" role="dialog" aria-modal="true" aria-label="Recortar logo">' +
                '<h5 class="mb-3">Ajusta tu logo</h5>' +
                '<div class="logo-cropper-stage"><img alt=""></div>' +
                '<div class="d-flex align-items-center mt-3">' +
                '<div class="logo-cropper-preview"></div>' +
                '<small class="text-muted ml-3">Mueve y haz zoom. Así se verá en tu perfil.</small>' +
                '<div class="ml-auto text-nowrap">' +
                '<button type="button" class="btn btn-outline-secondary btn-sm mr-2" data-act="cancel">Cancelar</button>' +
                '<button type="button" class="btn btn-primary btn-sm" data-act="ok">Usar logo</button>' +
                '</div></div></div>';
            document.body.appendChild(modal);

            var img = modal.querySelector('img');
            var cropper = null;
            var origName = 'logo.png';

            function close() {
                modal.classList.remove('is-open');
                if (cropper) { cropper.destroy(); cropper = null; }
                if (img.src.indexOf('blob:') === 0) URL.revokeObjectURL(img.src);
                img.removeAttribute('src');
            }

            input.addEventListener('change', function () {
                var file = input.files && input.files[0];
                if (!file) return;
                if (!/^image\/(jpeg|png|webp)$/.test(file.type)) return;
                origName = file.name.replace(/\.[^.]+$/, '') + '.png';
                img.src = URL.createObjectURL(file);
                modal.classList.add('is-open');
                if (cropper) cropper.destroy();
                cropper = new Cropper(img, {
                    aspectRatio: 1, viewMode: 1, dragMode: 'move', autoCropArea: 1,
                    background: false, guides: false, center: false, highlight: false,
                    cropBoxMovable: false, cropBoxResizable: false, toggleDragModeOnDblclick: false,
                    preview: modal.querySelector('.logo-cropper-preview')
                });
            });

            modal.addEventListener('click', function (ev) {
                var act = ev.target.getAttribute('data-act');
                if (act === 'cancel' || ev.target === modal) {
                    input.value = '';
                    close();
                } else if (act === 'ok' && cropper) {
                    cropper.getCroppedCanvas({ width: 512, height: 512, fillColor: '#fff', imageSmoothingQuality: 'high' })
                        .toBlob(function (blob) {
                            var dt = new DataTransfer();
                            dt.items.add(new File([blob], origName, { type: 'image/png' }));
                            input.files = dt.files;
                            close();
                        }, 'image/png');
                }
            });
        })();
    </script>
@endpush
@endonce
