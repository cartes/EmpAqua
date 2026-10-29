<form class="form" action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
    <h4 class="text-left">Datos Personales</h4>
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-md-3">
            <div class="container-img-profile d-flex">
                <div class="img-profile d-flex">
                    @if ($user->path)
                        <img class="my-auto w-100 h-auto" src="{{ $user->profileAttachment() }}">
                    @else
                        <p class="my-auto text-center w-100 h-auto">No picture</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Nombre (*)</label>
                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                           name="name" value="{{ old('name') ?? $user->name ?? '' }}" />
                    @if($errors->has('name'))
                        <span class="invalid-feedback">{{$errors->first('name')}}</span>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label>Apellido (*)</label>
                    <input class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}"
                           name="surname" value="{{ old('surname') ?? $user->surname ?? '' }}" />
                    @if($errors->has('surname'))
                        <span class="invalid-feedback">{{$errors->first('surname')}}</span>
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Dirección(*)</label>
                    <input class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                           name="address" value="{{ old('address') ?? $user->userMeta->address ?? '' }}" />
                    @if($errors->has('address'))
                        <span class="invalid-feedback">{{$errors->first('address')}}</span>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label>Comuna(*)</label>
                    <input class="form-control{{ $errors->has('comune') ? ' is-invalid' : '' }}"
                           name="comune" value="{{ old('comune') ?? $user->userMeta->comune ?? '' }}" />
                    @if($errors->has('comune'))
                        <span class="invalid-feedback">{{$errors->first('comune')}}</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Ciudad (*)</label>
                    <input class="form-control {{$errors->has('city') ? 'is-invalid' : ''}}"
                           name="city" value="{{old('city') ?? $user->userMeta->city ?? ''}}"/>
                    @if($errors->has('city'))
                        <span class="invalid-feedback">{{$errors->first('city')}}</span>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label>Nacionalidad(*)</label>
                    <input class="form-control {{$errors->has('nacionality') ? 'is-invalid' : ''}}"
                           name="nacionality" value="{{old('nacionality') ?? $user->nacionality ?? ''}}">
                    @if($errors->has('nacionality'))
                        <span class="invalid-feedback">{{$errors->first('nacionality')}}</span>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label>Género (*)</label>

                    <select class="form-control{{$errors->has('gender') ? ' is-invalid' : ''}}" name="gender">
                        <option value="" {{old('gender') == null && $user->gender == null ? "selected" : ""}}>
                            Seleccionar
                        </option>
                        <option value="1" {{old('gender') == "1" || $user->gender == "Masculino" ? 'selected' : ""}}>
                            Masculino
                        </option>
                        <option value="2" {{old('gender') == "2" || $user->gender == "Femenino" ? 'selected' : ""}}>
                            Femenino
                        </option>
                        <option value="3" {{old('gender') == "3" || $user->gender == "Otro" ? 'selected' : ""}}>
                            Otro
                        </option>
                    </select>
                    @if($errors->has('gender'))
                        <span class="invalid-feedback">{{$errors->first('gender')}}</span>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label>Fecha de Nacimiento (*)</label>
                    <input class="form-control datepicker {{$errors->has('birthday') ? 'is-invalid' : ''}}"
                           name="birthday" value="{{old('birthday') ?? $user->birthday ?? ''}}">
                    @if($errors->has('birthday'))
                        <span class="invalid-feedback">{{$errors->first('birthday')}}</span>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label>preferencia salarial (*)</label>
                    <input class="form-control {{$errors->has('pretentions') ? 'is-invalid' : ''}}"
                           name="pretentions" value="{{old('pretentions') ?? $user->userMeta->pretentions ?? ''}}">
                    @if($errors->has('pretentions'))
                        <span class="invalid-feedback">{{$errors->first('pretentions')}}</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Teléfono(*)</label>
                    <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                           name="phone" value="{{ old('phone') ?? $user->userMeta->phone ?? '' }}" />
                    @if($errors->has('phone'))
                        <span class="invalid-feedback">{{$errors->first('phone')}}</span>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label>Estado Civil(*)</label>
                    <select class="form-control{{$errors->has('marital_status') ? ' is-invalid' : ''}}" name="marital_status">
                        <option value="" {{old('marital_status') == null && $user->marital_status == null ? "selected" : ""}}>
                            Seleccionar
                        </option>
                        <option value="1" {{old('marital_status') == "1" || $user->marital_status == "Soltero" ? 'selected' : ""}}>
                            Soltero(a)
                        </option>
                        <option value="2" {{old('marital_status') == "2" || $user->marital_status == "Casado" ? 'selected' : ""}}>
                            Casado(a)
                        </option>
                        <option value="3" {{old('marital_status') == "3" || $user->marital_status == "Unión Libre" ? 'selected' : ""}}>
                            Unión Libre
                        </option>
                        <option value="4" {{old('marital_status') == "4" || $user->marital_status == "Divorciado" ? 'selected' : ""}}>
                            Divorciado(a)
                        </option>
                        <option value="5" {{old('marital_status') == "5" || $user->marital_status == "Pareja de Hecho" ? 'selected' : ""}}>
                            Pareja de Hecho
                        </option>
                        <option value="6" {{old('marital_status') == "6" || $user->marital_status == "Viudo" ? 'selected' : ""}}>
                            Viudo(a)
                        </option>
                    </select>
                    @if($errors->has('gender'))
                        <span class="invalid-feedback">{{$errors->first('marital_status')}}</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label>Objetivos laborales (*)</label>
                    <textarea name="objectives"
                              class="form-control{{$errors->has('objectives') ? " is-invalid" : ""}}">{{old('objectives') ?? $user->UserMeta->objectives ?? ''}}</textarea>
                    @if($errors->has('objectives'))
                        <span class="invalid-feedback">{{$errors->first('objectives')}}</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-7">
                    <label>Sube tu imagen de perfil</label>
                    <input type="file" name="picture"
                           class="form-control{{ $errors->has('picture') ? ' is-invalid' : '' }}"/>
                    @if ($errors->has('picture'))
                        <span class="invalid-feedback">{{ $errors->first('picture') }}</span>
                    @endif
                </div>
            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-12 text-right">
            <button type="submit" class="btn btn-primary">Guardar los Datos</button>
        </div>
    </div>

</form>
