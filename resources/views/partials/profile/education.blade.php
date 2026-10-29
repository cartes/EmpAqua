@php
    $eduHasErrors = $errors->hasAny(['studies', 'title', 'institution', 'condition', 'year_to']);
@endphp

<section id="educacion" class="card p-card">
    <div class="card-header">
        <h2><i class="fas fa-graduation-cap"></i>Formación académica</h2>
        <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="collapse" data-target="#addEducation"
                aria-expanded="{{ $eduHasErrors ? 'true' : 'false' }}" aria-controls="addEducation">
            <i class="fas fa-plus mr-1"></i> Agregar
        </button>
    </div>
    <div class="card-body">
        <div class="collapse{{ $eduHasErrors ? ' show' : '' }}" id="addEducation">
            <form class="form add-form" action="{{ route('profile.education') }}" method="post">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nivel de estudios</label>
                        <select class="form-control{{ $errors->has('studies') ? ' is-invalid' : '' }}" name="studies">
                            <option value="">Seleccionar</option>
                            <option value="1"{{ old('studies') == '1' ? ' selected' : '' }}>Secundario</option>
                            <option value="2"{{ old('studies') == '2' ? ' selected' : '' }}>Terciario</option>
                            <option value="3"{{ old('studies') == '3' ? ' selected' : '' }}>Universitario</option>
                            <option value="4"{{ old('studies') == '4' ? ' selected' : '' }}>Posgrado</option>
                            <option value="4"{{ old('studies') == '4' ? ' selected' : '' }}>Master</option>
                            <option value="5"{{ old('studies') == '5' ? ' selected' : '' }}>Doctorado</option>
                            <option value="6"{{ old('studies') == '6' ? ' selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Estado</label>
                        <select class="form-control {{ $errors->has('condition') ? 'is-invalid' : '' }}" name="condition">
                            <option value="" {{ old('condition') == '' ? 'selected' : '' }}>Seleccionar</option>
                            <option value="1" {{ old('condition') == '1' ? 'selected' : '' }}>En Curso</option>
                            <option value="2" {{ old('condition') == '2' ? 'selected' : '' }}>Graduado</option>
                            <option value="3" {{ old('condition') == '3' ? 'selected' : '' }}>Abandonado</option>
                        </select>
                        @if ($errors->has('condition'))
                            <span class="invalid-feedback">{{ $errors->first('condition') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label>Carrera / Título</label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title"
                               value="{{ old('title') }}" />
                        @if ($errors->has('title'))
                            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-5">
                        <label>Institución</label>
                        <input class="form-control {{ $errors->has('institution') ? 'is-invalid' : '' }}" name="institution"
                               value="{{ old('institution') }}" />
                        @if ($errors->has('institution'))
                            <span class="invalid-feedback">{{ $errors->first('institution') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-2">
                        <label>Año de egreso</label>
                        <input class="form-control {{ $errors->has('year_to') ? 'is-invalid' : '' }}" name="year_to_st"
                               value="{{ old('year_to') }}" placeholder="Año" />
                        @if ($errors->has('year_to'))
                            <span class="invalid-feedback">{{ $errors->first('year_to') }}</span>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-link text-muted" data-toggle="collapse" data-target="#addEducation">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar formación</button>
                </div>
            </form>
        </div>

        @forelse($education ?? [] as $ed)
            <div class="p-item">
                <div class="icon"><i class="fas fa-university"></i></div>
                <div class="body">
                    <div class="sub text-uppercase small">{{ $ed->studies_level }}</div>
                    <h3>{{ $ed->title }}</h3>
                    <div class="sub">
                        {{ $ed->institution }}
                        <span class="mx-1">·</span>{{ $ed->condition }}
                        @if($ed->year_to)<span class="mx-1">·</span><strong>{{ $ed->year_to }}</strong>@endif
                    </div>
                </div>
                <div class="actions">
                    <a href="#" class="edit-education" data-id="{{ $ed->id_education }}" title="Editar">
                        <i class="far fa-edit"></i>
                    </a>
                    <a href="#" class="erase-education" data-id="{{ $ed->id_education }}" title="Eliminar">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="p-empty">Aún no has agregado información académica.</div>
        @endforelse
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="editEducationModal" tabindex="-1" role="dialog" aria-labelledby="editEducationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEducationModalLabel">Editar información académica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="educationForm" method="POST" action="{{ route('profile.education.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_education" value="">
                    <div class="form-group">
                        <label for="studies">Nivel de estudios</label>
                        <select class="form-control" name="studies">
                            <option value="">Seleccionar</option>
                            <option value="1">Secundario</option>
                            <option value="2">Terciario</option>
                            <option value="3">Universitario</option>
                            <option value="4">Posgrado</option>
                            <option value="4">Master</option>
                            <option value="5">Doctorado</option>
                            <option value="6">Otro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">Carrera / Título</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="form-group">
                        <label for="institution">Institución</label>
                        <input type="text" class="form-control" name="institution">
                    </div>
                    <div class="form-group">
                        <label for="condition">Estado</label>
                        <select class="form-control" name="condition">
                            <option value="">Seleccionar</option>
                            <option value="1">En Curso</option>
                            <option value="2">Graduado</option>
                            <option value="3">Abandonado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year_to">Año de egreso</label>
                        <input type="text" class="form-control" name="year_to" placeholder="Año">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.edit-education').on('click', function(event) {
            event.preventDefault();

            // Obtener el id_education desde el atributo data-id
            var id = $(this).data('id');

            // Hacer una solicitud AJAX para obtener los datos de la educación
            $.ajax({
                url: '/profile/profile/education/' +
                    id, // Asegúrate de que esta ruta exista en tu Laravel
                type: 'GET',
                success: function(data) {
                    var conditionMap = {
                        'En Curso': '1',
                        'Graduado': '2',
                        'Abandonado': '3'
                    };

                    // Convertir el valor de condition a entero
                    var conditionValue = conditionMap[data.condition];

                    // Cargar los datos en el formulario del modal
                    $('#educationForm input[name="id_education"]').val(data.id_education);
                    $('#educationForm select[name="studies"]').val(data.studies);
                    $('#educationForm input[name="title"]').val(data.title);
                    $('#educationForm input[name="institution"]').val(data.institution);
                    $('#educationForm select[name="condition"]').val(conditionValue);
                    $('#educationForm input[name="year_to"]').val(data.year_to);

                    // Mostrar el modal
                    $('#editEducationModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos:', error);
                    // Manejar el error, quizás mostrar un mensaje al usuario
                }
            });
        });
    });
</script>
