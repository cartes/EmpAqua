<form class="form" method="post" enctype="multipart/form-data" action="{{ route("profile.resume") }}">
    @csrf
    @method("PUT")
    <h4 class="text-left">Adjuntar documentos</h4>
    <div class="row">
        <div class="form-group col-md-7">
            <label>Subir tu CV</label>
            <input type="file" name="resume" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" />
            @if( $errors->has('file') )
                <span class="invalid-feedback">{{ $errors->first('file') }}</span>
            @endif
            <small>Formatos válidos PDF o Word</small>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-right">
            <button type="submit" class="btn btn-primary">Subir archivo</button>
        </div>
    </div>

    @isset($user->usermeta)
        <div class="row">
            <div class="col-12">
                <h4>Curriculum</h4>
                <p><a href="{{asset( 'storage/resume/' . $user->userMeta->path )}}"> {{ $user->userMeta->filename }}</a></p>
            </div>
        </div>
    @endisset
</form>