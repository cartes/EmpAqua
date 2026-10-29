<div class="row">
    <div class="col-md-10">
        <div class="row my-3">
            <div class="col-12 text-right">
                <a href="{{ route('profile') }}" class="btn btn-secondary">Modificar mi CV</a>
            </div>
        </div>

        <div class="row border-bottom pb-4 mb-4">
            <div class="col-md-3">
                <div class="container-img-profile d-flex">
                    <div class="img-profile d-flex">
                        @if ($user->path)
                            <img class="my-auto w-100 h-auto" src="{{ $user->profileAttachment() }}"/>
                        @else
                            <p class="my-auto text-center w-100 h-auto">No picture</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-dark">{{ $user->name }} {{ $user->surname }}</h3>
                    </div>
                    <div class="col-3">
                        <p>RUT</p>
                    </div>
                    <div class="col-9">
                        {{ $user->rut_user ?? '' }}
                    </div>
                    <div class="col-3">
                        <p>Email</p>
                    </div>
                    <div class="col-9">
                        {{ $user->email ?? '' }}
                    </div>
                    <div class="col-3">
                        <p>Teléfono</p>
                    </div>
                    <div class="col-9">
                        {{ $user->userMeta->phone ?? '' }}
                    </div>
                    <div class="col-3">
                        <p>Estado Civil</p>
                    </div>
                    <div class="col-9">
                        {{ $user->marital_status ?? '' }}
                    </div>
                    <div class="col-3">
                        <p>Dirección</p>
                    </div>
                    <div class="col-9">
                        {{ $user->userMeta->address ?? '' }}{{ isset($user->userMeta->comune) ? ', ' . $user->userMeta->comune : '' }}
                    </div>
                    <div class="col-3">
                        <p>Fecha de Nacimiento</p>
                    </div>
                    <div class="col-9">
                        {{ $user->birthday }} | ({{ $user->age }})
                    </div>
                    <div class="col-3">
                        <p>Nacionalidad</p>
                    </div>
                    <div class="col-9">
                        {{ $user->nacionality ?? '' }}
                    </div>
                    <div class="col-3">
                        <p>Género</p>
                    </div>
                    <div class="col-9">
                        {{ $user->gender ?? '' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row border-bottom pb-4 mb-4">
            <div class="col-12">
                <h4>Objetivo Laboral</h4>
            </div>
            <div class="col-12">
                {!! $user->userMeta->objectives ?? '' !!}
            </div>
        </div>

        <div class="row border-bottom pb-4 mb-4">
            <div class="col-12">
                <h4>Experiencia Laboral</h4>
            </div>
            <div class="col-md-3">
                <strong>Preferencia Salarial</strong>
            </div>
            <div class="col-md-9">
                {{ $user->userMeta->pretentions ?? '' }}
            </div>
            <div class="col-md-3">
                <strong>Nivel de Experiencia</strong>
            </div>
            <div class="col-md-9">
                {{ $user->experience ?? '' }} Años
            </div>
        </div>

        @if ( $experiences->count() > 0 )
            <div class="row border-bottom pb-4 mb-4">
                @foreach($experiences as $exp)
                    <div class="col-12">
                        <div class="row border-bottom pb-4 mb-4">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Puesto</strong>
                                    </div>
                                    <div class="col-md-3">{{ $exp->business_position }}</div>
                                    <div class="col-md-3">
                                        <strong>Empresa</strong>
                                    </div>
                                    <div class="col-md-3">{{ $exp->business_name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Actividad de la empresa</strong>
                                    </div>
                                    <div class="col-md-3">{{ $exp->business_activity }}</div>
                                    <div class="col-md-3">
                                        <strong>Área</strong>
                                    </div>
                                    <div class="col-md-3">{{ $exp->area }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Desde</strong>
                                    </div>
                                    <div class="col-md-3">{{ $exp->year_from }}</div>
                                    <div class="col-md-3">
                                        <strong>Hasta</strong>
                                    </div>
                                    <div class="col-md-3">{{ $exp->year_to }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Nivel de experiencia</strong>
                                    </div>
                                    <div class="col-md-3">{{ $exp->level_experience ?? 'Sin nivel de experiencia' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($user->userEducation->count() > 0)
            <div class="row border-bottom pb-4 mb-4">
                <div class="col-12 mb-3">
                    <h4>Antecedentes Académicos</h4>
                </div>
                @foreach($user->userEducation as $educ)
                    <div class="col-12">
                        <div class="row mb-2 pb-2 border-bottom border-light">
                            <div class="col-md-3">{{ $educ->year_from }}{{ $educ->year_to ? ' - ' . $educ->year_to : '' }}</div>
                            <div class="col-md-3">{{ $educ->studies_level }} - {{ $educ->condition }}</div>
                            <div class="col-md-3">{{ $educ->title }}</div>
                            <div class="col-md-3">{{ $educ->institution }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($user->userSkills->count() > 0)
            <div class="row border-bottom pb-4 mb-4">
                <div class="col-12 mb-3">
                    <h4>Habilidades</h4>
                </div>
                <div class="col-12">
                    <div class="align-content-center">
                        @foreach ($user->userSkills as $skill)
                            <span class="badge-xl fs-4 badge-info badge bg-secondary badge-info p-2 mr-2">
                                <span class="p-3 text-white">{{ $skill->skill }}</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        
        @if ($user->userReferences->count() > 0)
            <div class="row border-bottom pb-4 mb-4">
                <div class="col-12 mb-3">
                    <h4>Referencias</h4>
                </div>
                <div class="col-12">
                    @foreach($user->userReferences as $ref)
                    <div class="row">
                        <div class="col-3">Nombre</div>
                        <div class="col-9">{{ $ref->referencer_firstname }} {{ $ref->referencer_surname }}</div>
                        <div class="col-3">Empresa</div>
                        <div class="col-9">{{ $ref->referencer_business }}</div>
                        <div class="col-3">Email</div>
                        <div class="col-9">{{ $ref->referencer_email }}</div>
                        <div class="col-3">Teléfono</div>
                        <div class="col-9">{{ $ref->referencer_phone }}</div>
                        <div class="col-3">Relación</div>
                        <div class="col-9">{{ $ref->referencer_relation }}</div>
                        <div class="col-3">Tipo de referencia</div>
                        <div class="col-9">{{ $ref->referencer_type }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-12 text-right">
                <a href="{{ route('profile') }}" class="btn btn-secondary">Modificar mi CV</a>
            </div>
        </div>
    </div>
    <div class="col-md-2">

    </div>
</div>