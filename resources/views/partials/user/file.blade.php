<div class="row justify-content-center">
    <div class="col-sm-10">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="mb-0">Perfil de {{ $user->name }} {{ $user->surname }}</h3>
                    </div>
                    <div class="col-md-4 text-md-right mt-2 mt-md-0">
                        @if ($user->userMeta && !is_null($user->userMeta->path))
                            <a href="{{ asset('storage/resume/' . $user->userMeta->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="far fa-file-alt mr-1"></i> Ver / Descargar CV
                            </a>
                        @else
                            <span class="badge badge-secondary p-2">Sin CV adjunto</span>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <p>Email: <strong>{{$user->email}}</strong></p>
                        <p>Teléfono: <strong>{{ $user->userMeta->phone ?? '' }}</strong></p>
                        <p>Nacionalidad: <strong>{{ $user->nacionality }}</strong></p>
                    </div>
                    <div class="col-6">
                        <p>Género: <strong>{{$user->gender}}</strong></p>
                        <p>Edad: <strong>{{ $user->age }}</strong></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <p>Pretensiones de renta: <strong>{{ $user->userMeta->pretentions ?? '' }}</strong></p>
                    </div>
                    <div class="col-6">
                        <p>Objetivos Laborales: </p>
                        {!! \App\Helpers\Helper::cleanHtml($user->userMeta->objectives ?? '') !!}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h4>Educación</h4>
                        @forelse($user->userEducation as $education)
                            <p>
                                Estudió <strong>{{ $education->title }}</strong> en
                                <strong>{{ $education->institution }}</strong> |
                                Status: {{$education->condition}} |
                                Fecha de graduación: {{$education->month_to}} {{$education->year_to}}
                            </p>
                            <hr>
                        @empty
                            <p>
                                <strong>El usuario no ha ingresado información</strong>
                            </p>
                        @endforelse
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h4>Experiencia</h4>
                        @forelse($user->userExperience as $experience)
                            <p><strong>Empresa: {{ $experience->business_name }}</strong> |
                                Cargo: {{ $experience->business_position }} |
                                Tiempo: {{$experience->date_diff}}<br/>
                                <strong>Descripción:</strong> {{ $experience->description }}
                            </p>
                        @empty
                            <p>
                                <strong>El usuario no ha ingresado información</strong>
                            </p>
                        @endforelse
                    </div>
                </div>
                <hr>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h4>Conocimientos</h4>
                        @forelse($user->userSkills as $skill)
                            <h4 class="d-inline-block">
                                <span class="badge badge-pill badge-secondary">{{$skill->skill}}</span>
                            </h4>
                            @empty
                                <p>
                                    <strong>El usuario no ha ingresado información</strong>
                                </p>
                            @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
