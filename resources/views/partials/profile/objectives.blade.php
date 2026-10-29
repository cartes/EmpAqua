<form class="form" method="post" action="{{ route('profile.objectives') }}">
    @csrf
    @method("PUT")
    <div class="row">
        <div class="form-group col-md-12">
            <label>Objetivos laborales</label>
            <textarea name="objectives" class="form-control {{$errors->has('objectives')}}">{{$user->UserMeta->objectives ?? ''}}</textarea>
            @if($errors->has('objectives'))
                <span class="invalid-feedback">{{$errors->first('objectives')}}</span>
            @endif
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Guardar los Datos</button>
</form>
