<section id="habilidades" class="card p-card">
    <div class="card-header">
        <h2><i class="fas fa-star"></i>Habilidades</h2>
    </div>
    <div class="card-body">
        <form class="form" method="post" action="{{ route('profile.skills') }}">
            @csrf
            @method('PUT')
            <label class="small font-weight-bold text-muted" for="skill">Agrega un conocimiento o habilidad</label>
            <div class="input-group mb-3">
                <input id="skill" class="form-control{{ $errors->has('skill') ? ' is-invalid' : '' }}" name="skill"
                       value="{{ old('skill') }}" placeholder="Ej: Excel avanzado, Manejo de grúa horquilla"/>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> Agregar</button>
                </div>
                @if($errors->has('skill'))
                    <span class="invalid-feedback">{{ $errors->first('skill') }}</span>
                @endif
            </div>
        </form>

        @forelse($user->userSkills as $skill)
            <span class="skill-pill badge-skills" data-id="{{ $skill->id_skills }}" title="Clic para eliminar">
                {{ $skill->skill }} <i class="fas fa-times"></i>
            </span>
        @empty
            <div class="p-empty">Aún no has agregado habilidades.</div>
        @endforelse
    </div>
</section>
