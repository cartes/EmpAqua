<form class="form" action="{{route('profile.salary')}}" method="post">
    <h3 class="text-center">Pretensiones salariales</h3>
    @method('PUT')
    @csrf
    <div class="row">
        <div class="form-group col-md-6">
            <label>Indicar preferencia salarial</label>
            <input class="form-control {{$errors->has('pretentions') ? 'is-invalid' : ''}}"
                   name="pretentions" value="{{$user->userMeta->pretentions ?? ''}}">
            @if($errors->has('pretentions'))
                <span class="invalid-feedback">{{$errors->first('pretentions')}}</span>
            @endif
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Guardar los Datos</button>
</form>
{{--<div class="file col-md-8 my-2">--}}
{{--<h3 class="text-center">Pretensiones salariales</h3>--}}
{{--<h6 class="text-center">Sueldo bruto pretendido: {{$user->userMeta->pretentions ?? ''}}</h6>--}}
{{--</div>--}}

