@php
    $genders = ['1' => 'Masculino', '2' => 'Femenino', '3' => 'Otro'];
    $maritals = ['1' => 'Soltero', '2' => 'Casado', '3' => 'Unión Libre', '4' => 'Divorciado', '5' => 'Pareja de Hecho', '6' => 'Viudo'];
    $currentGender = (string) (old('gender') ?? $user->gender);
    $currentMarital = (string) (old('marital_status') ?? $user->marital_status);
@endphp

<section id="datos-personales" class="card p-card">
    <div class="card-header">
        <h2><i class="fas fa-user"></i>Datos personales</h2>
        <small class="text-muted">(*) obligatorio</small>
    </div>
    <div class="card-body">
        <form class="form" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="photo-upload{{ $user->path ? '' : ' photo-upload--empty' }}">
                <div class="photo-upload__preview" id="photoPreview">
                    @if ($user->path)
                        <img src="{{ $user->profileAttachment() }}" alt="Foto de perfil">
                    @else
                        <i class="fas fa-camera"></i>
                    @endif
                </div>
                <div class="photo-upload__body">
                    <strong>Foto de perfil</strong>
                    <p class="mb-2">
                        <i class="fas fa-lightbulb text-warning mr-1"></i>
                        Un perfil con foto es mejor: las empresas lo ven más cercano y confiable,
                        y tiene más posibilidades de ser considerado.
                    </p>
                    <div class="custom-file photo-upload__input">
                        <input type="file" name="picture" id="picture" accept="image/png,image/jpeg"
                               class="custom-file-input{{ $errors->has('picture') ? ' is-invalid' : '' }}"/>
                        <label class="custom-file-label" for="picture" id="pictureLabel">
                            {{ $user->path ? 'Cambiar imagen' : 'Subir imagen' }}
                        </label>
                        @if ($errors->has('picture'))
                            <span class="invalid-feedback d-block">{{ $errors->first('picture') }}</span>
                        @endif
                    </div>
                    <small class="text-muted d-block mt-1">JPG o PNG, máximo 2 MB. Se guarda al presionar "Guardar datos".</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Nombre (*)</label>
                    <input id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                           name="name" value="{{ old('name') ?? $user->name ?? '' }}" />
                    @if($errors->has('name'))
                        <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="surname">Apellido (*)</label>
                    <input id="surname" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}"
                           name="surname" value="{{ old('surname') ?? $user->surname ?? '' }}" />
                    @if($errors->has('surname'))
                        <span class="invalid-feedback">{{ $errors->first('surname') }}</span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="birthday">Fecha de nacimiento (*)</label>
                    <input id="birthday" class="form-control datepicker{{ $errors->has('birthday') ? ' is-invalid' : '' }}"
                           name="birthday" placeholder="dd-mm-aaaa" autocomplete="off" value="{{ old('birthday') ?? $user->birthday ?? '' }}">
                    @if($errors->has('birthday'))
                        <span class="invalid-feedback">{{ $errors->first('birthday') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label for="gender">Género (*)</label>
                    <select id="gender" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender">
                        <option value="">Seleccionar</option>
                        @foreach($genders as $value => $label)
                            <option value="{{ $value }}" {{ in_array($currentGender, [(string) $value, $label], true) ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('gender'))
                        <span class="invalid-feedback">{{ $errors->first('gender') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label for="marital_status">Estado civil (*)</label>
                    <select id="marital_status" class="form-control{{ $errors->has('marital_status') ? ' is-invalid' : '' }}" name="marital_status">
                        <option value="">Seleccionar</option>
                        @foreach($maritals as $value => $label)
                            <option value="{{ $value }}" {{ in_array($currentMarital, [(string) $value, $label], true) ? 'selected' : '' }}>{{ in_array($label, ['Unión Libre', 'Pareja de Hecho'], true) ? $label : $label . '(a)' }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('marital_status'))
                        <span class="invalid-feedback">{{ $errors->first('marital_status') }}</span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nacionality">Nacionalidad (*)</label>
                    <input id="nacionality" class="form-control{{ $errors->has('nacionality') ? ' is-invalid' : '' }}"
                           name="nacionality" value="{{ old('nacionality') ?? $user->nacionality ?? '' }}">
                    @if($errors->has('nacionality'))
                        <span class="invalid-feedback">{{ $errors->first('nacionality') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label for="phone">Teléfono (*)</label>
                    <input id="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                           name="phone" value="{{ old('phone') ?? $user->userMeta->phone ?? '' }}" />
                    @if($errors->has('phone'))
                        <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label for="pretentions">Pretensión salarial (*)</label>
                    <input id="pretentions" class="form-control{{ $errors->has('pretentions') ? ' is-invalid' : '' }}"
                           name="pretentions" value="{{ old('pretentions') ?? $user->userMeta->pretentions ?? '' }}">
                    @if($errors->has('pretentions'))
                        <span class="invalid-feedback">{{ $errors->first('pretentions') }}</span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="address">Dirección (*)</label>
                    <input id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                           name="address" value="{{ old('address') ?? $user->userMeta->address ?? '' }}" />
                    @if($errors->has('address'))
                        <span class="invalid-feedback">{{ $errors->first('address') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="comune">Comuna (*)</label>
                    <input id="comune" class="form-control{{ $errors->has('comune') ? ' is-invalid' : '' }}"
                           name="comune" value="{{ old('comune') ?? $user->userMeta->comune ?? '' }}" />
                    @if($errors->has('comune'))
                        <span class="invalid-feedback">{{ $errors->first('comune') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="city">Ciudad (*)</label>
                    <input id="city" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                           name="city" value="{{ old('city') ?? $user->userMeta->city ?? '' }}"/>
                    @if($errors->has('city'))
                        <span class="invalid-feedback">{{ $errors->first('city') }}</span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="objectives">Objetivos laborales (*)</label>
                <textarea id="objectives" name="objectives" rows="4"
                          class="form-control{{ $errors->has('objectives') ? ' is-invalid' : '' }}"
                          placeholder="Cuéntale a las empresas qué buscas y qué puedes aportar">{{ old('objectives') ?? $user->userMeta->objectives ?? '' }}</textarea>
                @if($errors->has('objectives'))
                    <span class="invalid-feedback">{{ $errors->first('objectives') }}</span>
                @endif
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save mr-1"></i> Guardar datos</button>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
    $('#picture').on('change', function () {
        const file = this.files[0];
        $('#pictureLabel').text(file ? file.name : 'Subir imagen');
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            alert('La imagen debe pesar menos de 2 MB.');
            this.value = '';
            $('#pictureLabel').text('Subir imagen');
            return;
        }
        const reader = new FileReader();
        reader.onload = e => $('#photoPreview').html($('<img>', { src: e.target.result, alt: 'Vista previa' }));
        reader.readAsDataURL(file);
    });
</script>
@endpush
