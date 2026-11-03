@php
    $toastMessage = session('message');
    $toastType = 'info';
    $toastText = '';

    if ($toastMessage) {
        if (is_array($toastMessage)) {
            $toastType = $toastMessage[0] ?? 'info';
            $toastText = $toastMessage[1] ?? '';
        } elseif (is_string($toastMessage)) {
            $toastText = $toastMessage;
        }
    } elseif (session()->has('status')) {
        $toastText = session('status');
    } elseif (session()->has('success')) {
        $toastType = 'success';
        $toastText = session('success');
    } elseif (session()->has('error')) {
        $toastType = 'danger';
        $toastText = session('error');
    }

    if ($toastType === 'error') {
        $toastType = 'danger';
    }

    $toastIcon = match ($toastType) {
        'success' => 'fas fa-check-circle',
        'warning' => 'fas fa-exclamation-triangle',
        'danger' => 'fas fa-times-circle',
        default => 'fas fa-info-circle',
    };

    $toastTitle = match ($toastType) {
        'success' => 'Éxito',
        'warning' => 'Atención',
        'danger' => 'Error',
        default => 'Notificación',
    };

    $headerBg = match ($toastType) {
        'success' => 'bg-success text-white',
        'warning' => 'bg-warning text-dark',
        'danger' => 'bg-danger text-white',
        'secondary' => 'bg-secondary text-white',
        default => 'bg-primary text-white',
    };

    $closeBtnColor = ($toastType === 'warning') ? '#212529' : '#ffffff';
@endphp

@if (!empty($toastText))
    <div aria-live="polite" aria-atomic="true" class="global-toast-wrapper"
        style="position: fixed; top: 20px; right: 20px; z-index: 10050; max-width: 380px; width: calc(100vw - 40px); pointer-events: none;">
        <div id="globalAppToast" class="toast shadow-lg" role="alert" aria-live="assertive" aria-atomic="true"
            data-delay="5000" data-autohide="true"
            style="pointer-events: auto; border: 0; border-radius: 8px; overflow: hidden; background-color: #ffffff;">
            <div class="toast-header {{ $headerBg }} py-2 px-3 border-0 d-flex align-items-center">
                <i class="{{ $toastIcon }} mr-2"></i>
                <strong class="mr-auto font-weight-bold" style="font-size: 0.95rem;">{{ $toastTitle }}</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Cerrar"
                    style="outline: none; color: {{ $closeBtnColor }}; opacity: 0.85; text-shadow: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body py-3 px-3 text-dark font-weight-normal"
                style="font-size: 0.95rem; line-height: 1.45; background-color: #ffffff;">
                {{ $toastText }}
            </div>
        </div>
    </div>

    <script type="text/javascript">
        (function() {
            function showGlobalToast() {
                if (window.jQuery && jQuery.fn && jQuery.fn.toast) {
                    var $toast = jQuery('#globalAppToast');
                    $toast.toast({ delay: 5000, autohide: true }).toast('show');
                    setTimeout(function() {
                        $toast.fadeOut(400);
                    }, 5500);
                }
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', showGlobalToast);
            } else {
                showGlobalToast();
            }
        })();
    </script>
@endif

