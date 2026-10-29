@php
    $refFields = ['referencer_firstname', 'referencer_surname', 'referencer_email', 'referencer_phone', 'referencer_business', 'referencer_relation', 'referencer_type'];
    $refHasErrors = $errors->hasAny($refFields);
    $refInputs = [
        ['referencer_firstname', 'Nombre (*)', 'text', 'col-md-6'],
        ['referencer_surname', 'Apellidos (*)', 'text', 'col-md-6'],
        ['referencer_email', 'Email (*)', 'email', 'col-md-6'],
        ['referencer_phone', 'Teléfono (*)', 'text', 'col-md-6'],
        ['referencer_business', 'Nombre de la empresa (*)', 'text', 'col-md-6'],
        ['referencer_relation', 'Tipo de relación (*)', 'text', 'col-md-3'],
        ['referencer_type', 'Área de trabajo (*)', 'text', 'col-md-3'],
    ];
@endphp

<section id="referencias" class="card p-card">
    <div class="card-header">
        <h2><i class="fas fa-user-friends"></i>Referencias</h2>
        <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="collapse" data-target="#addReference"
                aria-expanded="{{ $refHasErrors ? 'true' : 'false' }}" aria-controls="addReference">
            <i class="fas fa-plus mr-1"></i> Agregar
        </button>
    </div>
    <div class="card-body">
        <div class="collapse{{ $refHasErrors ? ' show' : '' }}" id="addReference">
            <form class="form add-form" method="post" action="{{ route('profile.references') }}">
                @csrf
                <div class="form-row">
                    @foreach($refInputs as [$name, $label, $type, $col])
                        <div class="form-group {{ $col }}">
                            <label>{{ $label }}</label>
                            <input type="{{ $type }}" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}"
                                   name="{{ $name }}" value="{{ old($name) }}">
                            @if($errors->has($name))
                                <span class="invalid-feedback">{{ $errors->first($name) }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-link text-muted" data-toggle="collapse" data-target="#addReference">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar referencia</button>
                </div>
            </form>
        </div>

        @forelse($user->userReferences as $reference)
            <div class="p-item">
                <div class="icon"><i class="fas fa-user-tie"></i></div>
                <div class="body">
                    <h3>{{ $reference->referencer_firstname }} {{ $reference->referencer_surname }}</h3>
                    <div class="sub">
                        {{ $reference->referencer_business }}
                        @if($reference->referencer_relation)<span class="mx-1">·</span>{{ $reference->referencer_relation }}@endif
                        @if($reference->referencer_type)<span class="mx-1">·</span>{{ $reference->referencer_type }}@endif
                    </div>
                    <div class="sub">
                        <i class="far fa-envelope mr-1"></i>{{ $reference->referencer_email }}
                        <span class="mx-2"></span>
                        <i class="fas fa-phone mr-1"></i>{{ $reference->referencer_phone }}
                    </div>
                </div>
                <div class="actions">
                    <a href="#" class="erase-reference" data-id="{{ $reference->id_references }}" title="Eliminar">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="p-empty">Aún no has agregado referencias.</div>
        @endforelse
    </div>
</section>
