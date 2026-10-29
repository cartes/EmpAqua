@php $meta = $user->userMeta; @endphp

<div id="profile-view">
    <div class="profile-hero mb-4">
        <div class="avatar">
            @if ($user->path)
                <img src="{{ $user->profileAttachment() }}" alt="Foto de perfil">
            @else
                {{ mb_strtoupper(mb_substr($user->name, 0, 1) . mb_substr($user->surname, 0, 1)) }}
            @endif
        </div>
        <div>
            <h1>{{ $user->name }} {{ $user->surname }}</h1>
            <div class="meta">
                <i class="far fa-envelope mr-1"></i>{{ $user->email }}
                @if($meta?->phone)
                    <span class="mx-2">·</span><i class="fas fa-phone mr-1"></i>{{ $meta->phone }}
                @endif
            </div>
            @if($meta?->pretentions)
                <div class="meta mt-1"><i class="fas fa-dollar-sign mr-1"></i>Pretensión salarial: {{ $meta->pretentions }}</div>
            @endif
        </div>
        <div class="btn-cv no-print">
            <button type="button" class="btn btn-outline-light mr-1" onclick="window.print()">
                <i class="fas fa-print mr-1"></i> Imprimir
            </button>
            <a href="{{ route('profile') }}" class="btn btn-light"><i class="fas fa-pen mr-1"></i> Modificar mi CV</a>
        </div>
    </div>

    <section class="card p-card">
        <div class="card-header"><h2><i class="fas fa-user"></i>Datos personales</h2></div>
        <div class="card-body">
            <dl class="cv-facts">
                <div><dt>RUT</dt><dd>{{ $user->rut_user ?: '—' }}</dd></div>
                <div><dt>Fecha de nacimiento</dt><dd>{{ $user->birthday ?: '—' }}@if($user->birthday) <span class="text-muted">({{ $user->age }})</span>@endif</dd></div>
                <div><dt>Nacionalidad</dt><dd>{{ $user->nacionality ?: '—' }}</dd></div>
                <div><dt>Género</dt><dd>{{ $user->gender ?: '—' }}</dd></div>
                <div><dt>Estado civil</dt><dd>{{ $user->marital_status ?: '—' }}</dd></div>
                <div>
                    <dt>Dirección</dt>
                    <dd>{{ collect([$meta?->address, $meta?->comune, $meta?->city])->filter()->unique()->implode(', ') ?: '—' }}</dd>
                </div>
            </dl>
        </div>
    </section>

    @if($meta?->objectives)
        <section class="card p-card">
            <div class="card-header"><h2><i class="fas fa-bullseye"></i>Objetivo laboral</h2></div>
            <div class="card-body">
                {!! \App\Helpers\Helper::cleanHtml($meta->objectives) !!}
            </div>
        </section>
    @endif

    <section class="card p-card">
        <div class="card-header">
            <h2><i class="fas fa-briefcase"></i>Experiencia laboral</h2>
            <span class="badge badge-light">{{ $user->experience ?? 0 }} años en total</span>
        </div>
        <div class="card-body">
            @forelse($experiences as $exp)
                <div class="p-item">
                    <div class="icon"><i class="fas fa-building"></i></div>
                    <div class="body">
                        <h3>{{ $exp->business_position }}</h3>
                        <div class="sub">
                            {{ $exp->business_name }}
                            @if($exp->business_activity)<span class="mx-1">·</span>{{ $exp->business_activity }}@endif
                            @if($exp->area)<span class="mx-1">·</span>{{ $exp->area }}@endif
                        </div>
                        <div class="sub">
                            <i class="far fa-calendar-alt mr-1"></i>{{ $exp->year_from }} – {{ $exp->year_to }}
                            <span class="mx-1">·</span>{{ $exp->level_experience ?? 'Sin nivel de experiencia' }}
                        </div>
                        @if($exp->description)
                            <p class="desc">{{ $exp->description }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-empty">Sin experiencia laboral registrada.</div>
            @endforelse
        </div>
    </section>

    @if ($user->userEducation->count() > 0)
        <section class="card p-card">
            <div class="card-header"><h2><i class="fas fa-graduation-cap"></i>Antecedentes académicos</h2></div>
            <div class="card-body">
                @foreach($user->userEducation as $educ)
                    <div class="p-item">
                        <div class="icon"><i class="fas fa-university"></i></div>
                        <div class="body">
                            <div class="sub text-uppercase small">{{ $educ->studies_level }}</div>
                            <h3>{{ $educ->title }}</h3>
                            <div class="sub">
                                {{ $educ->institution }}
                                <span class="mx-1">·</span>{{ $educ->condition }}
                                @if($educ->year_from || $educ->year_to)
                                    <span class="mx-1">·</span>{{ $educ->year_from }}{{ $educ->year_to ? ($educ->year_from ? ' – ' : '') . $educ->year_to : '' }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if ($user->userSkills->count() > 0)
        <section class="card p-card">
            <div class="card-header"><h2><i class="fas fa-star"></i>Habilidades</h2></div>
            <div class="card-body">
                @foreach ($user->userSkills as $skill)
                    <span class="skill-pill" style="cursor: default;">{{ $skill->skill }}</span>
                @endforeach
            </div>
        </section>
    @endif

    @if ($user->userReferences->count() > 0)
        <section class="card p-card">
            <div class="card-header"><h2><i class="fas fa-user-friends"></i>Referencias</h2></div>
            <div class="card-body">
                @foreach($user->userReferences as $ref)
                    <div class="p-item">
                        <div class="icon"><i class="fas fa-user-tie"></i></div>
                        <div class="body">
                            <h3>{{ $ref->referencer_firstname }} {{ $ref->referencer_surname }}</h3>
                            <div class="sub">
                                {{ $ref->referencer_business }}
                                @if($ref->referencer_relation)<span class="mx-1">·</span>{{ $ref->referencer_relation }}@endif
                                @if($ref->referencer_type)<span class="mx-1">·</span>{{ $ref->referencer_type }}@endif
                            </div>
                            <div class="sub">
                                <i class="far fa-envelope mr-1"></i>{{ $ref->referencer_email }}
                                <span class="mx-2"></span>
                                <i class="fas fa-phone mr-1"></i>{{ $ref->referencer_phone }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
