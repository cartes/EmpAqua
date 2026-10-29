<form class="form" action="{{route('profile.education')}}" method="post">
    <h4 class="text-left">Completa tu información Académica.</h4>
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-6">
            <label>Nivel de estudios</label>
            <select class="form-control{{ $errors->has('studies') ? ' is-invalid' : '' }}"
                    name="studies" value="{{ old('studies') }}">
                <option>Seleccionar</option>
                <option value="1"{{old('studies') == '1' ? ' selected' : ''}}>Secundario</option>
                <option value="2"{{old('studies') == '2' ? ' selected' : ''}}>Terciario</option>
                <option value="3"{{old('studies') == '3' ? ' selected' : ''}}>Universitario</option>
                <option value="4"{{old('studies') == '4' ? ' selected' : ''}}>Posgrado</option>
                <option value="4"{{old('studies') == '4' ? ' selected' : ''}}>Master</option>
                <option value="5"{{old('studies') == '5' ? ' selected' : ''}}>Doctorado</option>
                <option value="6"{{old('studies') == '6' ? ' selected' : ''}}>Otro</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Carrera / Título</label>
            <input class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}"
                   name="title" value="{{old('title')}}"/>
            @if($errors->has('title'))
                <span class="invalid-feedback">{{$errors->first('title')}}</span>
            @endif
        </div>
        <div class="form-group col-md-6">
            <label>Institución</label>
            <input class="form-control {{$errors->has('institution') ? 'is-invalid' : ''}}"
                   name="institution" value="{{old('institution')}}"/>
            @if($errors->has('institution'))
                <span class="invalid-feedback">{{$errors->first('institution')}}</span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label>Estado</label>
            <select class="form-control {{$errors->has('condition') ? 'is-invalid' : ''}}"
                    name="condition" value="{{old('condition')}}">
                <option value="" {{old('condition') == '' ? 'selected' : ''}}>Seleccionar</option>
                <option value="1" {{old('condition') == '1' ? 'selected' : ''}}>En Curso</option>
                <option value="2" {{old('condition') == '2' ? 'selected' : ''}}>Graduado</option>
                <option value="3" {{old('condition') == '3' ? 'selected' : ''}}>Abandonado</option>
            </select>
            @if($errors->has('condition'))
                <span class="invalid-feedback">{{$errors->first('condition')}}</span>
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Año de Egreso</label>
            <input class="form-control {{$errors->has('year_to_st') ? 'is-invalid' : ''}}"
                   name="year_to_st" value="{{old('year_to_st')}}" placeholder="Año"/>
            @if($errors->has('year_to_st'))
                <span class="invalid-feedback">{{$errors->first('year_to_st')}}</span>
            @endif
        </div>

    </div>

    <div class="row">
        <div class="col-12 text-end my-3">
            <button type="submit" class="btn btn-primary">Guardar los Datos</button>
        </div>
    </div>

    @if($education)
    <table class="table table-striped table-hover">
            @foreach($education as $ed)
            <tr>
                <td class='align-middle'>
                    <a href="#" class="erase-education" data-id="{{$ed->id_education}}">
                        <i class="fa-2xl text-danger fa-solid fa-circle-minus"></i>
                    </a>
                </td>
                <td>
                    <div class="col-md-12 my-2">
                        <div class="my-3">
                            <div class="header">
                                <h6>{{$ed->studies_level}}</h6>
                                <h4><strong>{{$ed->title}}</strong> en {{$ed->institution}}</h4>
                                <p>
                                <p>{{$ed->condition}} | <strong>{{$ed->year_to}}</strong></p>
                                </p>
                            </div>
        
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
    </table>
    @endif

</form>
