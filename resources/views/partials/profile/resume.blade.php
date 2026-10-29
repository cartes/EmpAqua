<section id="documentos" class="card p-card">
    <div class="card-header">
        <h2><i class="fas fa-file-alt"></i>Documentos</h2>
    </div>
    <div class="card-body">
        <form class="form" method="post" enctype="multipart/form-data" action="{{ route('profile.resume') }}">
            @csrf
            @method('PUT')
            <label class="small font-weight-bold text-muted" for="resume">Subir tu CV</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="resume" id="resume"
                           class="custom-file-input{{ $errors->has('file') ? ' is-invalid' : '' }}"
                           onchange="this.nextElementSibling.textContent = this.files[0]?.name || 'Seleccionar archivo'"/>
                    <label class="custom-file-label" for="resume">Seleccionar archivo</label>
                </div>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload mr-1"></i> Subir</button>
                </div>
            </div>
            @if($errors->has('file'))
                <div class="text-danger small mt-1">{{ $errors->first('file') }}</div>
            @endif
            <small class="text-muted">Formatos válidos: PDF o Word</small>
        </form>

        @if($user->userMeta?->path)
            <div class="p-item mt-3">
                <div class="icon"><i class="fas fa-paperclip"></i></div>
                <div class="body">
                    <h3>Currículum actual</h3>
                    <div class="sub">
                        <a href="{{ asset('storage/resume/' . $user->userMeta->path) }}" target="_blank">{{ $user->userMeta->filename }}</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
