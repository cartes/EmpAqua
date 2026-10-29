@php
    $months = ['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
    $expFields = ['business_name', 'business_position', 'month_from', 'year_from', 'month_to', 'year_to', 'experience_level', 'description'];
    $expHasErrors = $errors->hasAny($expFields);
@endphp

<section id="experiencia" class="card p-card">
    <div class="card-header">
        <h2><i class="fas fa-briefcase"></i>Experiencia laboral</h2>
        <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="collapse" data-target="#addExperience"
                aria-expanded="{{ $expHasErrors ? 'true' : 'false' }}" aria-controls="addExperience">
            <i class="fas fa-plus mr-1"></i> Agregar
        </button>
    </div>
    <div class="card-body">
        <div class="collapse{{ $expHasErrors ? ' show' : '' }}" id="addExperience">
            <form class="form add-form" action="{{ route('profile.experience') }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nombre de la empresa</label>
                        <input class="form-control {{ $errors->has('business_name') ? 'is-invalid' : '' }}"
                               name="business_name" value="{{ old('business_name') }}"/>
                        @if($errors->has('business_name'))
                            <span class="invalid-feedback">{{ $errors->first('business_name') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label>Puesto</label>
                        <input class="form-control {{ $errors->has('business_position') ? 'is-invalid' : '' }}"
                               name="business_position" value="{{ old('business_position') }}"/>
                        @if($errors->has('business_position'))
                            <span class="invalid-feedback">{{ $errors->first('business_position') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-row">
                    @foreach(['from' => 'Desde', 'to' => 'Hasta'] as $key => $title)
                        <div class="form-group col-md-6">
                            <label>{{ $title }}</label>
                            <div class="form-row">
                                <div class="col-6">
                                    <select class="form-control{{ $errors->has("month_$key") ? ' is-invalid' : '' }}" name="month_{{ $key }}">
                                        <option value="">Mes</option>
                                        @foreach($months as $value => $name)
                                            <option value="{{ $value }}" {{ old("month_$key") == $value ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <input class="form-control {{ $errors->has("year_$key") ? 'is-invalid' : '' }}"
                                           name="year_{{ $key }}" value="{{ old("year_$key") }}" placeholder="Año"/>
                                    @if($errors->has("year_$key"))
                                        <span class="invalid-feedback">{{ $errors->first("year_$key") }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Nivel de experiencia</label>
                        <select class="form-control {{ $errors->has('experience_level') ? 'is-invalid' : '' }}"
                                name="experience_level">
                            <option value="">Seleccionar</option>
                            @foreach(['01' => 'Training', '02' => 'Junior', '03' => 'Semisenior', '04' => 'Senior'] as $value => $name)
                                <option value="{{ $value }}" {{ old('experience_level') == $value ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('experience_level'))
                            <span class="invalid-feedback">{{ $errors->first('experience_level') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="description" rows="3"
                              class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                    @if($errors->has('description'))
                        <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-link text-muted" data-toggle="collapse" data-target="#addExperience">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar experiencia</button>
                </div>
            </form>
        </div>

        @forelse($experiences ?? [] as $experience)
            <div class="p-item">
                <div class="icon"><i class="fas fa-building"></i></div>
                <div class="body">
                    <h3>{{ $experience->business_position }}</h3>
                    <div class="sub">
                        {{ $experience->business_name }}
                        @if($experience->level_experience)<span class="mx-1">·</span>{{ $experience->level_experience }}@endif
                    </div>
                    <div class="sub">
                        <i class="far fa-calendar-alt mr-1"></i>{{ $experience->month_from }} {{ $experience->year_from }}
                        – {{ $experience->month_to }} {{ $experience->year_to }}
                    </div>
                    @if($experience->description)
                        <p class="desc">{{ $experience->description }}</p>
                    @endif
                </div>
                <div class="actions">
                    <a href="#" class="erase-experience" data-id="{{ $experience->id_experience }}" title="Eliminar">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="p-empty">Aún no has agregado experiencia laboral.</div>
        @endforelse
    </div>
</section>
