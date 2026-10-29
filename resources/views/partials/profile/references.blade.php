<form class="form" method="post" action="{{ route("profile.references") }}">
    @csrf
    @method("PUT")
    <h4 class="text-left">Referencias</h4>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Nombre (*)</label>
            <input type="text"
                   class="form-control{{ $errors->has("referencer_firstname") ? ' is-invalid' : ''}}"
                   name="referencer_firstname" value="{{ old("referencer_firstname") }}">
            @if( $errors->has('referencer_firstname') )
                <span class="invalid-feedback">{{$errors->first('referencer_firstname')}}</span>
            @endif
        </div>
        <div class="form-group col-md-6">
            <label>Apellidos (*)</label>
            <input type="text"
                   class="form-control{{ $errors->has("referencer_surname") ? ' is-invalid' : ''}}"
                   name="referencer_surname" value="{{ old("referencer_surname") }}">
            @if( $errors->has('referencer_surname') )
                <span class="invalid-feedback">{{$errors->first('referencer_surname')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Email (*)</label>
            <input type="email"
                   class="form-control{{ $errors->has("referencer_email") ? ' is-invalid' : ''}}"
                   name="referencer_email" value="{{ old("referencer_email") }}">
            @if( $errors->has('referencer_email') )
                <span class="invalid-feedback">{{$errors->first('referencer_email')}}</span>
            @endif
        </div>
        <div class="form-group col-md-6">
            <label>Teléfono (*)</label>
            <input type="text"
                   class="form-control{{ $errors->has("referencer_phone") ? ' is-invalid' : ''}}"
                   name="referencer_phone" value="{{ old("referencer_phone") }}">
            @if( $errors->has('referencer_phone') )
                <span class="invalid-feedback">{{$errors->first('referencer_phone')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Nombre de la empresa (*)</label>
            <input type="text"
                   class="form-control{{ $errors->has("referencer_business") ? ' is-invalid' : ''}}"
                   name="referencer_business" value="{{ old("referencer_business") }}">
            @if( $errors->has('referencer_business') )
                <span class="invalid-feedback">{{$errors->first('referencer_business')}}</span>
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Tipo de relación (*)</label>
            <input type="text"
                   class="form-control{{ $errors->has("referencer_relation") ? ' is-invalid' : ''}}"
                   name="referencer_relation" value="{{ old("referencer_relation") }}">
            @if( $errors->has('referencer_relation') )
                <span class="invalid-feedback">{{$errors->first('referencer_relation')}}</span>
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Área de trabajo (*)</label>
            <input type="text"
                   class="form-control{{ $errors->has("referencer_type") ? ' is-invalid' : ''}}"
                   name="referencer_type" value="{{ old("referencer_type") }}">
            @if( $errors->has('referencer_type') )
                <span class="invalid-feedback">{{$errors->first('referencer_type')}}</span>
            @endif
        </div>
    </div>

    <!-- Submit -->
    <div class="row">
        <div class="col-12 text-end my-3">
            <button type="submit" class="btn btn-primary">Guardar los Datos</button>
        </div>
    </div>

    @if($user->userReferences)
    <table class="table">
        @foreach($user->userReferences as $reference)
        <tr>
            <td class='align-middle'>
                <a href="#" class="erase-reference" data-id="{{$reference->id_references}}">
                    <i class="fas fa-minus-circle fa-lg text-danger"></i>
                </a>
            </td>
            <td>
                <div class="row">
                    <div class="col-md-12 my-2">
                            <div class="row">
                                <div class="col-12">
                                    <h4><strong>{{$reference->referencer_business}}</strong></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    {{ $reference->referencer_firstname }} {{ $reference->referencer_surname }}
                                </div>
                                <div class="col-3">
                                    Correo: {{ $reference->referencer_email }}
                                </div>
                                <div class="col-3">
                                    Teléfono: {{ $reference->referencer_phone }}
                                </div>
                                <div class="col-3">
                                    <p>Area: {{ $reference->referencer_type }}</p>
                                    <p>Relación: {{ $reference->referencer_relation }}</p>
                                </div>
                            </div>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </table>
    @endif

</form>
