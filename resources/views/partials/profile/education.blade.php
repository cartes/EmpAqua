<form class="form" action="{{ route('profile.education') }}" method="post">
    <h4 class="text-left">Completa tu información Académica.</h4>
    @csrf
    <div class="row">
        <div class="form-group col-md-6">
            <label>Nivel de estudios</label>
            <select class="form-control{{ $errors->has('studies') ? ' is-invalid' : '' }}" name="studies"
                value="{{ old('studies') }}">
                <option>Seleccionar</option>
                <option value="1"{{ old('studies') == '1' ? ' selected' : '' }}>Secundario</option>
                <option value="2"{{ old('studies') == '2' ? ' selected' : '' }}>Terciario</option>
                <option value="3"{{ old('studies') == '3' ? ' selected' : '' }}>Universitario</option>
                <option value="4"{{ old('studies') == '4' ? ' selected' : '' }}>Posgrado</option>
                <option value="4"{{ old('studies') == '4' ? ' selected' : '' }}>Master</option>
                <option value="5"{{ old('studies') == '5' ? ' selected' : '' }}>Doctorado</option>
                <option value="6"{{ old('studies') == '6' ? ' selected' : '' }}>Otro</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Carrera / Título</label>
            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title"
                value="{{ old('title') }}" />
            @if ($errors->has('title'))
                <span class="invalid-feedback">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="form-group col-md-6">
            <label>Institución</label>
            <input class="form-control {{ $errors->has('institution') ? 'is-invalid' : '' }}" name="institution"
                value="{{ old('institution') }}" />
            @if ($errors->has('institution'))
                <span class="invalid-feedback">{{ $errors->first('institution') }}</span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label>Estado</label>
            <select class="form-control {{ $errors->has('condition') ? 'is-invalid' : '' }}" name="condition"
                value="{{ old('condition') }}">
                <option value="" {{ old('condition') == '' ? 'selected' : '' }}>Seleccionar</option>
                <option value="1" {{ old('condition') == '1' ? 'selected' : '' }}>En Curso</option>
                <option value="2" {{ old('condition') == '2' ? 'selected' : '' }}>Graduado</option>
                <option value="3" {{ old('condition') == '3' ? 'selected' : '' }}>Abandonado</option>
            </select>
            @if ($errors->has('condition'))
                <span class="invalid-feedback">{{ $errors->first('condition') }}</span>
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Año de Egreso</label>
            <input class="form-control {{ $errors->has('year_to') ? 'is-invalid' : '' }}" name="year_to_st"
                value="{{ old('year_to') }}" placeholder="Año" />
            @if ($errors->has('year_to'))
                <span class="invalid-feedback">{{ $errors->first('year_to') }}</span>
            @endif
        </div>

    </div>

    <div class="row">
        <div class="col-12 text-end my-3">
            <button type="submit" class="btn btn-primary">Guardar los Datos</button>
        </div>
    </div>

</form>

<!-- Modal -->
<div class="modal fade" id="editEducationModal" tabindex="-1" role="dialog" aria-labelledby="editEducationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEducationModalLabel">Editar Información Académica</h5>
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
                        <label for="year_to">Año de Egreso</label>
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

@if ($education)
    <table class="table bg-white my-1">
        @foreach ($education as $ed)
            <tr>
                <td class='align-middle'>
                    <a href="#" class="erase-education" data-id="{{ $ed->id_education }}">
                        <i class="fas fa-minus-circle fa-lg text-danger"></i>
                    </a>
                    <a href="#" class="edit-education" data-id="{{ $ed->id_education }}">
                        <i class="fas fa-edit fa-lg text-primary"></i>
                    </a>
                </td>
                <td>
                    <div class="col-md-12 my-2">
                        <div class="my-3">
                            <div class="header">
                                <h6>{{ $ed->studies_level }}</h6>
                                <h4><strong>{{ $ed->title }}</strong> en {{ $ed->institution }}</h4>
                                <p>{{ $ed->condition }} | <strong>{{ $ed->year_to }}</strong></p>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
@endif
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
