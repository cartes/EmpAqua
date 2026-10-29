@extends('layout.app')
@section('robots', 'noindex, nofollow')

@section('content')
    <div class="container mt-5">

        @if(session()->has('message'))
            <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 1rem; right: 1rem; z-index: 1050;">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                    <div class="toast-header bg-{{ session('message')[0] }} text-white">
                        <strong class="mr-auto">Notificación</strong>
                        <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        {{ session('message')[1] }}
                    </div>
                </div>
            </div>
        @endif


        <div class="row justify-content-center mb-3">
            <div class="col-sm-8">
                <a href="{{ route('offer.admin') }}">&laquo; Volver al listado</a>
            </div>
        </div>
        <div class="row justify-content-center">

            {{-- Perfil de la empresa --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h4 class="text-uppercase text-center">{{$business->business_meta->business_name}}</h4>
                                <a class="btn btn-outline-primary" href="{{ route('business.profile') }}">Editar perfil</a>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-12">
                                <h5>Información de contacto</h5>
                                <p class="py-0 my-0">Nombre: {{ $business->firstname }} {{ $business->surname }}</p>
                                <p class="py-0 my-0">Email: {{ $business->email_user }}</p>
                                <p class="pt-0 my-0">Teléfono: {{ $business->phone_user }}</p>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Información de contacto empresa</h5>
                                <p class="py-0 my-0">Email: {{ $business->business_meta->email }}</p>
                                <p class="pt-0 my-0">Teléfono: {{ $business->business_meta->phone }}</p>
                                <p class="pt-0 my-0">Teléfono: {{ $business->business_meta->activity }}</p>
                                <p class="pt-0 my-0">Rubro: {{ $business->business_meta->activity }}</p>
                                <p class="pt-0 my-0">Dirección: {{ $business->business_meta->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detalle de la ofeta --}}
            <div class="col-md-8">
                <form method="post" action="{{ route('offer.store', $offer->slug ) }}">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="text-left">Editando oferta Nº{{$offer->id}}</h4>
                            <h4 class="text-left">{{$offer->title}}</h4>
                            <h6>Publicado en: {{$offer->date}}</h6>
                        </div>
                        <div class="col-md-4 d-flex flex-row-reverse align-items-center">
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="btn btn-primary" type="submit">Guardar los datos</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    @csrf
                    <div class="row my-2">
                        <div class="col-md-7 col-7">
                            <div class="form-group">
                                <label class="pe-2">¿Es una oferta confidencial? (Aparece como "Empresa Prestigiosa")</label>
                                <input type="checkbox" name="status" class="form-check-input" {{ $offer->confidential ? 'checked' : ''}} />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label>Categoría</label>
                                <select id="category_id" name="category_id" class="form-control">
                                    <option class="text-start">Seleccione una categoría</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $offer->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Cargo</label>
                            <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}"
                                   name="title" value="{{old('title') ?? $offer->title}}"/>
                            @if($errors->has('title'))
                                <span class="invalid-feedback">{{$errors->first('title')}}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label>Jornada (*)</label>
                            <select class="form-control" name="position">
                                <option value="">Seleccione un tipo de puesto</option>
                                <option value="1"{{ $offer->position == "Full-time" ? ' selected' : '' }}>Full-time</option>
                                <option value="2"{{ $offer->position == "Part-time" ? ' selected' : '' }}>Part-time</option>
                                <option value="3"{{ $offer->position == "Turnos" ? ' selected' : '' }}>Turnos</option>
                            </select>
                            @if($errors->has('position'))
                                <span class="invalid-feedback">{{$errors->first('position')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Area Implementación</label>
                            <input type="text" name="area"
                                   class="form-control {{$errors->has('area') ? 'is-invalid' : ''}}"
                                   value="{{old('area') ?? $offer->area}}"/>
                            @if($errors->has('area'))
                                <span class="invalid-feedback">{{$errors->first('area')}}</span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Comuna</label>
                            <input type="text" name="comune"
                                   class="form-control {{$errors->has('comune') ? 'is-invalid' : ''}}"
                                  value="{{old('comune') ?? $offer->comune}}" />
                            @if($errors->has('comune'))
                                <span class="invalid-feedback">{{$errors->first('comune')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Tipo de contrato</label>
                            <!--
                            {{ $offer->position }}
                            -->
                            <select class="form-control" name="experience">
                                <option value="">Seleccione un tipo de contrato</option>
                                <option value="0"{{ $offer->experience == "Prestación Servicios" ? ' selected' : ''}}>Prestación Servicios</option>
                                <option value="1"{{ $offer->experience == "Indefinido" ? ' selected' : ''}}>Indefinido</option>
                                <option value="2"{{ $offer->experience == "Plazo Fijo" ? ' selected' : ''}}>Plazo Fijo</option>
                                <option value="3"{{ $offer->experience == "Honorarios" ? ' selected' : ''}}>Honorarios</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>La oferta es incluisva <i class="fas fa-wheelchair"></i></label>
                            <select class="form-control" name="handicapped">
                                <option value="">Seleccione</option>
                                <option value="0"{{ $offer->handicapped == 0 ? ' selected' : ''}}>No</option>
                                <option value="1"{{ $offer->handicapped == 1 ? ' selected' : ''}}>Si</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Renta ofrecida</label>
                            <select id="selectSalary" class="form-control{{ $errors->has('salary_opt') ? ' is-invalid' : ''}}" name="salary_opt">
                                <option value="">Seleccione una opción de Salario</option>
                                <option value="0" {{$offer->salary_array == "0" ? 'selected' : ''}}>A convenir</option>
                                <option value="1" {{$offer->salary_array == "1" ? 'selected' : ''}}>Exacto</option>
                                <option value="2" {{$offer->salary_array == "2" ? 'selected' : ''}}>Por Rango</option>
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
                                        $('.salary-input input').prop('disabled', true);  // Deshabilitar todos
                                        $('#salary-' + value + ' input').prop('disabled', false);  // Habilitar solo los visibles
                                    });
                                
                                    // Asegurarse de que los campos correctos estén habilitados al cargar la página
                                    let initialValue = $('#selectSalary').val();
                                    $('.salary-input').hide();
                                    $('#salary-' + initialValue).show();
                                    $('.salary-input input').prop('disabled', true);
                                    $('#salary-' + initialValue + ' input').prop('disabled', false);
                                });
                            </script>
                
                            @if ($errors->has('salary'))
                                <span class="invalid-feedback">{{ $errors->first('salary') }}</span>
                            @endif
                        </div>
<!--                        
                        <div class="col-md-4 form-group">
                            <label>Renta ofrecida</label>
                            <input class="form-control{{ $errors->has('salary') ? ' is-invalid' : '' }}"
                                   type="text" name="salary" value="{{ old('salary') ?? $offer->salary }}"/>

                            @if ($errors->has('salary'))
                                <span class="invalid-feedback">{{ $errors->first('salary') }}</span>
                            @endif
                        </div>
                        
                        -->
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Descripción</label>
                            <textarea id="contents" type="text"
                                      class="form-control {{$errors->has('description') ? 'is-invalid' : ''}}"
                                      name="description">{{old('description') ?: $offer->description}}</textarea>
                            @if($errors->has('description'))
                                <span class="invalid-feedback">{{$errors->first('description')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-group">
                            <label>Requisitos</label>
                            <textarea type="text"
                                      class="form-control{{ $errors->has('requirements') ? ' is-invalid' : '' }}"
                                      name="requirements">{{ old('requirements') ?? $offer->requirements ?? '' }}</textarea>
                            @if ($errors->has('requirements'))
                                <span class="invalid-feedback">{{ $errors->first('requirements') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 form-group">
                            <label>Beneficios</label>
                            <div class="row">
                                <div id="listBenefits" class="col-12">
                                    @php($i=0)
                                    <div class="btn-benefit" id="div_0"></div>

                                    @forelse($benefits as $benefit)
                                        @php($i++)
                                        <div id="div_{{ $i }}" class="btn-benefit mr-3 mb-2 btn btn-secondary ">
                                            {{ $benefit->benefit }}
                                            <input name='benefits[]' type='hidden' value='{{ $benefit->benefit }}'/>
                                        </div>
                                    @empty
                                        <div class="btn-benefit" id="div_0">No hay beneficios</div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-inline col-md-5">
                                    <input class="form-control{{ $errors->has('benefit') ? ' is-invalid' : '' }}"
                                           name="benefit"/>
                                </div>
                                <div class="d-inline col-md-3">
                                    <a id="addBenefit" href="#">Agregar Beneficio</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 my-0 py-0">
                                    <small>Cuando agregue beneficios, los puede borrar si les da click en la etiqueta
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 form-group">
                            <label>Vacantes</label>
                            <div class="row">
                                <div class="d-inline col-md-5">
                                    <input class="form-control{{ $errors->has('vacancy') ? ' is-invalid' : '' }}" value="{{old('vacancy') ?? $offer->vacancy}}" name="vacancy"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Guardar los datos</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.toast').toast('show');
        });
    </script>

    <script>
        jQuery(document).ready(function ($) {
            $(document).ready(function () {
                tinymce.init({
                    selector: '#contents',
                    schema: 'html5',
                    themes: 'modern',
                    language: 'es_ES',
                    menubar: false,
                    plugins: "lists",
                    skin: 'oxide',
                    statusbar: false,
                    toolbar: [
                        'bold italic underline numlist bullist',
                        'code'
                    ],
                });
            });
        });
    </script>
    <script>
        jQuery(document).ready(function ($) {
            $('#addBenefit').click(function (e) {
                e.preventDefault();
                var container = $("input[name='benefit']");
                var benefit = container.val();
                if ($('.btn-benefit').length) {
                    var lastid = $('.btn-benefit:last').attr('id');
                }
                var split_id = lastid.split("_");
                var nextdiv = Number(split_id[1]) + 1;

                if (benefit == '') {
                    container.addClass('is-invalid');
                } else {
                    $("#listBenefits").addClass("my-3").append(
                        "<div id='div_" + nextdiv + "' class='btn-benefit mr-3 mb-2 btn btn-secondary'>" + benefit +
                        "<input name='benefits[]' type='hidden' value='" + benefit + "' />" +
                        "</div>"
                    );
                    container.val('');
                }
            });

            $('#listBenefits').on("click", ".btn-benefit", function (e) {
                var id = $(this).attr('id');
                $("#" + id).remove();
            })
        });

    </script>
@endpush
