<style>
    .form-offer .switch-lg { display: flex; align-items: center; min-height: calc(1.5em + .75rem + 2px); padding-left: 3.75rem; }
    .form-offer .switch-lg .custom-control-label { font-size: 1rem; line-height: 1.5; white-space: nowrap; }
    .form-offer .switch-lg .custom-control-label::before { left: -3.75rem; width: 3rem; height: 1.6rem; border-radius: .8rem; top: 50%; transform: translateY(-50%); }
    .form-offer .switch-lg .custom-control-label::after { left: calc(-3.75rem + 3px); top: 50%; transform: translateY(-50%); width: calc(1.6rem - 6px); height: calc(1.6rem - 6px); border-radius: 50%; }
    .form-offer .switch-lg .custom-control-input:checked ~ .custom-control-label::after { transform: translate(1.4rem, -50%); }
</style>
<form class="form-offer card card-body w-100 mb-4 p-4" method="post" action="{{ route('offer.create') }}">
    @csrf
    <h4 class="text-left mb-4">Completa la información de la oferta que quieres publicar.</h4>
    
    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" name="status" id="status" class="custom-control-input" checked />
            <label class="custom-control-label font-weight-bold" for="status">¿Es una oferta confidencial? (Aparece como "Empresa Prestigiosa")</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Categoría</label>
                <select id="category_id" name="category_id" class="form-control{{$errors->has('category_id') ? ' is-invalid' : ''}}">
                    <option class="text-start" value=''>Seleccione una categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                    @endforeach
                </select>
                @if($errors->has('category_id'))
                    <span class="invalid-feedback">{{$errors->first('category_id')}}</span>
                @endif

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label>Cargo (*)</label>
            <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}" name="title"
                   value="{{old('title')}}"/>
            @if($errors->has('title'))
                <span class="invalid-feedback">{{ $errors->first('title') }}</span>
            @endif

        </div>
        <div class="col-md-6 form-group">
            <label>Jornada (*)</label>
            <select name="position" class="form-control{{$errors->has('position') ? ' is-invalid' : ''}}">
                <option value="">Seleccione un tipo</option>
                <option value="1" {{old('position') == 1 ? 'selected' : ''}}>Full-time</option>
                <option value="2" {{old('position') == 2 ? 'selected' : ''}}>Part-time</option>
                <option value="3" {{old('position') == 3 ? 'selected' : ''}}>Turnos</option>
            </select>
            @if($errors->has('position'))
                <span class="invalid-feedback">{{$errors->first('position')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <label>Area Implementación (*)</label>
            <input type="text" name="area" class="form-control {{$errors->has('area') ? 'is-invalid' : ''}}"
                   value="{{old('area')}}"/>
            @if($errors->has('area'))
                <span class="invalid-feedback">{{$errors->first('area')}}</span>
            @endif
        </div>
        <div class="col-md-6 form-group">
            <label>Comuna de la oferta (*)</label>
            <input type="text" name="comune" class="form-control {{$errors->has('comune') ? 'is-invalid' : ''}}"
                   value="{{old('comune')}}"/>
            @if($errors->has('comune'))
                <span class="invalid-feedback">{{$errors->first('comune')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-3 form-group">
            <label>Tipo de contrato</label>
            <select class="form-control{{$errors->has('experience') ? ' is-invalid' : ''}}" name="experience" id="experience">
                <option value="">Seleccione un tipo de contrato</option>
                <option value="0" {{old('experience') == 1 ? 'selected' : ''}}>Prestación Servicios</option>
                <option value="1" {{old('experience') == 1 ? 'selected' : ''}}>Indefinido</option>
                <option value="2" {{old('experience') == 2 ? 'selected' : ''}}>Plazo Fijo</option>
                <option value="3" {{old('experience') == 3 ? 'selected' : ''}}>Honorarios</option>
            </select>
            @if($errors->has('experience'))
                <span class="invalid-feedback">{{$errors->first('experience')}}</span>
            @endif

        </div>
        <div class="col-md-6 col-xl-5 form-group">
            <label class="d-block">Oferta inclusiva <i class="fas fa-wheelchair"></i></label>
            <input type="hidden" name="handicapped" value="0">
            <div class="custom-control custom-switch switch-lg">
                <input type="checkbox" class="custom-control-input{{$errors->has('handicapped') ? ' is-invalid' : ''}}"
                       id="handicapped" name="handicapped" value="1" {{ old('handicapped') == "1" ? 'checked' : '' }}>
                <label class="custom-control-label" for="handicapped">Sí, es inclusiva</label>
            </div>
            @if($errors->has('handicapped'))
                <span class="invalid-feedback d-block">{{$errors->first('handicapped')}}</span>
            @endif
        </div>
        <div class="col-12 col-xl-4 form-group">
            <label>Renta ofrecida</label>
            <select id="selectSalary" class="form-control{{ $errors->has('salary_opt') ? ' is-invalid' : ''}}" name="salary_opt">
                <option value="">Seleccione una opción de Salario</option>
                <option value="0" {{old('salary_opt') == "0" ? 'selected' : ''}}>A convenir</option>
                <option value="1" {{old('salary_opt') == "1" ? 'selected' : ''}}>Exacto</option>
                <option value="2" {{old('salary_opt') == "2" ? 'selected' : ''}}>Por Rango</option>
            </select>
            <!-- <input class="form-control{{ $errors->has('salary') ? ' is-invalid' : '' }}"
                   type="text" name="salary" value="{{ old('salary') }}"/> -->
            @if($errors->has('salary_opt'))
                <span class="invalid-feedback">{{$errors->first('salary_opt')}}</span>
            @endif

           <div id="salary-0" class="salary-input salary-exacto form-group" style="display: none;">
                <label>A convenir</label>
                <input class="form-control{{ $errors->has('salary') ? ' is-invalid' : '' }}"
                    type="hidden" name="salary" value="0" />

            </div>


            <div id="salary-1" class="salary-input salary-exacto form-group" style="display: none;">
                <label>Escriba la renta exacto ofrecida</label>
                <input class="form-control{{ $errors->has('salary') ? ' is-invalid' : '' }}"
                    type="text" name="salary" value="{{ old('salary') }}" />

            </div>

            <div id="salary-2" class="salary-input row salary-rango form-group" style="display: none;">
                <div class='col-12'>
                <label>Escriba el rango de renta ofrecida</label>
                </div>

                <div class="col-6">
                    <label>Mínimo</label>

                    <input class="form-control{{ $errors->has('salary') ? ' is-invalid' : '' }}"
                        type="text" name="salaryMin" value="{{ old('salary') }}" />
                </div>
                <div class="col-6">
                    <label>Máximo</label>

                    <input class="form-control{{ $errors->has('salary') ? ' is-invalid' : '' }}"
                        type="text" name="salaryMax" value="{{ old('salary') }}" />
                </div>
            </div>

<script>
    jQuery(document).ready(function ($) {
        $('#selectSalary').change(function() {
            let value = $(this).val();
            $('.salary-input').hide();
            $('#salary-' + value).show();
            console.log(value);
        });
    })
</script>

            @if ($errors->has('salary'))
                <span class="invalid-feedback">{{ $errors->first('salary') }}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <label>Descripción (*)</label>
            <textarea id="contents" type="text" class="form-control {{$errors->has('description') ? 'is-invalid' : ''}}"
                      name="description">
                {{ old('description') }}
            </textarea>
            
            @if($errors->has('description'))
                <span class="invalid-feedback">{{$errors->first('description')}}</span>
            @endif

        </div>
    </div>
    <div class="row">
        <div class="col-12 form-group">
            <label>Requisitos *</label>
            <textarea type="text" class="form-control{{ $errors->has('requirements') ? ' is-invalid' : '' }}"
                      name="requirements">{{ old('requirements') }}</textarea>
            @if ($errors->has('requirements'))
                <span class="invalid-feedback">{{ $errors->first('requirements') }}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12 form-group">
            <label>Beneficios</label>
            <div class="row">
                <div class="col-12">
                    @php($i = 0)
                    @if (old('benefits'))
                        @foreach (old('benefits') as $benefit)
                            <div id='div_{{ $i++ }}' class='btn-benefit mr-3 mb-2 btn btn-secondary'>
                                {{ $benefit }}
                                <input name='benefits[]' type='hidden' value='{{ $benefit }}'/>
                            </div>
                        @endforeach
                    @endif
                    <div id="listBenefits" class="col-12">
                        <div class="btn-benefit" id="div_0"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 mb-2">
                    <input class="form-control{{ $errors->has('benefit') ? ' is-invalid' : '' }}" name="benefit"/>
                </div>
                <div class="col-md-5 mb-2">
                    <a id="addBenefit" class="btn btn-outline-primary" href="#">Agregar Beneficio</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 my-0 py-0">
                    <small>Cuando agregue beneficios, los puede borrar si les da click en la etiqueta</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 form-group">
            <label>Vacantes</label>
            <div class="row">
                <div class="col-md-5">
                    <input class="form-control{{ $errors->has('vacancy') ? ' is-invalid' : '' }}" name="vacancy" value="{{ old('vacancy') ?? '' }}"/>
                @if ($errors->has('vacancy'))
                    <span class="invalid-feedback">{{ $errors->first('vacancy') }}</span>
                @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-3">
            <button class="btn btn-primary" type="submit">Publicar Aviso</button>
        </div>
    </div>
</form>