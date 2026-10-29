<form class="form" action="{{route('profile.experience')}}" method="post">
    <h4 class="text-left">Experiencia Laboral</h4>
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-6">
            <label>Nombre de la empresa</label>
            <input class="form-control {{$errors->has('business_name') ? 'is-invalid' : ''}}"
                   name="business_name" value="{{old('business_name')}}"/>
            @if($errors->has('business_name'))
                <span class="invalid-feedback">{{$errors->first('business_name')}}</span>
            @endif
        </div>
        <div class="form-group col-md-6">
            <label>Puesto</label>
            <input class="form-control {{$errors->has('business_position') ? 'is-invalid' : ''}}"
                   name="business_position" value="{{old('business_position')}}"/>
            @if($errors->has('business_position'))
                <span class="invalid-feedback">{{$errors->first('business_position')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Desde</label>
            <div class="row">
                <div class="col-6">
                    <select class="form-control{{ $errors->has('month_from') ? ' is-invalid' : '' }}"
                            name="month_from">
                        <option value="">-- Mes --</option>
                        <option value="01" {{old('experience_level') == '01' ? 'selected' : ''}}>Enero</option>
                        <option value="02" {{old('experience_level') == '02' ? 'selected' : ''}}>Febrero</option>
                        <option value="03" {{old('experience_level') == '03' ? 'selected' : ''}}>Marzo</option>
                        <option value="04" {{old('experience_level') == '04' ? 'selected' : ''}}>Abril</option>
                        <option value="05" {{old('experience_level') == '05' ? 'selected' : ''}}>Mayo</option>
                        <option value="06" {{old('experience_level') == '06' ? 'selected' : ''}}>Junio</option>
                        <option value="07" {{old('experience_level') == '07' ? 'selected' : ''}}>Julio</option>
                        <option value="08" {{old('experience_level') == '08' ? 'selected' : ''}}>Agosto</option>
                        <option value="09" {{old('experience_level') == '09' ? 'selected' : ''}}>Septiembre</option>
                        <option value="10" {{old('experience_level') == '10' ? 'selected' : ''}}>Octubre</option>
                        <option value="11" {{old('experience_level') == '11' ? 'selected' : ''}}>Noviembre</option>
                        <option value="12" {{old('experience_level') == '12' ? 'selected' : ''}}>Diciembre</option>
                    </select>
                </div>
                <div class="col-6">
                    <input class="form-control {{$errors->has('year_from') ? 'is-invalid' : ''}}"
                           name="year_from" value="{{old('year_from')}}" placeholder="Año"/>
                    @if($errors->has('year_from'))
                        <span class="invalid-feedback">{{$errors->first('year_from')}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label>Hasta</label>
            <div class="row">
                <div class="col-6">
                    <select class="form-control{{ $errors->has('month_to') ? ' is-invalid' : '' }}"
                            name="month_to">
                        <option value="">-- Mes --</option>
                        <option value="01" {{old('experience_level') == '01' ? 'selected' : ''}}>Enero</option>
                        <option value="02" {{old('experience_level') == '02' ? 'selected' : ''}}>Febrero</option>
                        <option value="03" {{old('experience_level') == '03' ? 'selected' : ''}}>Marzo</option>
                        <option value="04" {{old('experience_level') == '04' ? 'selected' : ''}}>Abril</option>
                        <option value="05" {{old('experience_level') == '05' ? 'selected' : ''}}>Mayo</option>
                        <option value="06" {{old('experience_level') == '06' ? 'selected' : ''}}>Junio</option>
                        <option value="07" {{old('experience_level') == '07' ? 'selected' : ''}}>Julio</option>
                        <option value="08" {{old('experience_level') == '08' ? 'selected' : ''}}>Agosto</option>
                        <option value="09" {{old('experience_level') == '09' ? 'selected' : ''}}>Septiembre</option>
                        <option value="10" {{old('experience_level') == '10' ? 'selected' : ''}}>Octubre</option>
                        <option value="11" {{old('experience_level') == '11' ? 'selected' : ''}}>Noviembre</option>
                        <option value="12" {{old('experience_level') == '12' ? 'selected' : ''}}>Diciembre</option>
                    </select>
                </div>
                <div class="col-6">
                    <input class="form-control {{$errors->has('year_to') ? 'is-invalid' : ''}}"
                           name="year_to" value="{{old('year_to')}}" placeholder="Año"/>
                    @if($errors->has('year_to'))
                        <span class="invalid-feedback">{{$errors->first('year_to')}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label>Nivel de experiencia</label>
            <select class="form-control {{$errors->has('experience_level') ? 'is-invalid' : ''}}"
                    name="experience_level">
                <option value="" {{old('experience_level') == '' ? 'selected' : ''}}>Seleccionar</option>
                <option value="01" {{old('experience_level') == '01' ? 'selected' : ''}}>Training</option>
                <option value="02" {{old('experience_level') == '02' ? 'selected' : ''}}>Junior</option>
                <option value="03" {{old('experience_level') == '03' ? 'selected' : ''}}>Semisenior</option>
                <option value="04" {{old('experience_level') == '04' ? 'selected' : ''}}>Senior</option>
            </select>
            @if($errors->has('experience_level'))
                <span class="invalid-feedback">{{$errors->first('experience_level')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-8">
            <label>Descripción</label>
            <textarea name="description"
                      class="form-control {{$errors->has('description') ? 'is-invalid' : ''}}">{{old('description')}}</textarea>
            @if($errors->has('description'))
                <span class="invalid-feedback">{{$errors->first('description')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-end mt-3">
            <button type="submit" class="btn btn-primary">Guardar los Datos</button>
        </div>
    </div>

</form>
<table class="table table-striped table-hover">
    @if($experiences)
        @foreach($experiences as $experience)
            <tr>
                <td class='align-middle'>
                    <a href="#" class="erase-experience" data-id="{{$experience->id_experience}}">
                        <i class="fa-2xl text-danger fa-solid fa-circle-minus"></i>
                    </a>
                </td>
                <td>
                    <div class="row">
                        <div class="col-md-12 my-1">
                                <div class="my-0">
                                    <div class="header">
                                        <h4>{{$experience->business_position}} - {{$experience->business_name}}</h4>
                                        <p>
                                            {{$experience->month_from}} {{$experience->year_from}} -
                                            {{$experience->month_to}}&nbsp;{{$experience->year_to}}
                                        </p>
                                        <p>
                                            Nivel de experiencia: {{ $experience->level_experience }}
                                        </p>
                                    </div>
                                    <div class="body">
                                        Descripción: {{$experience->description}}
                                    </div>
                                </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    @endif
</table>

