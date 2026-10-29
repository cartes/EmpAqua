@extends("layout.app")

@section("content")
    <div class="container business-form-page mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <form class="form-business" enctype="multipart/form-data" method="post"
                      action="{{ route('business.update') }}">
                    @csrf
                    @method("PUT")

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="page-title mb-0">{{ $business->business_meta ? 'Editar perfil de empresa' : 'Completa el perfil de tu empresa' }}</h2>
                        <a href="{{ route('business.profile') }}" class="btn btn-link">&larr; Volver al perfil</a>
                    </div>

                    <div class="card form-card mb-4">
                    <div class="card-body">
                    <h3 class="section-title">
                        Administrador
                    </h3>
                    <div class="row">
                        <div class="col-6 form-group">
                            <label>Rut del Administrador</label>
                            <input type="text" class="form-control{{ $errors->has('rut_user') ? ' is-invalid' : '' }}"
                                   name="rut_user" value="{{ old('rut_user') ?? $business->rut_user }}">
                            @if($errors->has('rut_user'))
                                <span class="invalid-feedback">{{$errors->first('rut_business')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 form-group">
                            <label>Nombre del Administrador</label>
                            <input type="text" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                                   name="firstname" value="{{ old('firstname') ?? $business->firstname }}">
                            @if($errors->has('firstname'))
                                <span class="invalid-feedback">{{$errors->first('firstname')}}</span>
                            @endif
                        </div>
                        <div class="col-6 form-group">
                            <label>Apellido del Administrador</label>
                            <input type="text" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}"
                                   name="surname" value="{{ old('surname') ?? $business->surname }}">
                            @if($errors->has('surname'))
                                <span class="invalid-feedback">{{$errors->first('surname')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 form-group">
                            <label>Email del Administrador</label>
                            <input type="email" class="form-control{{ $errors->has('email_user') ? ' is-invalid' : '' }}"
                                   name="email_user" value="{{ old('email_user') ?? $business->email_user }}">
                            @if($errors->has('email_user'))
                                <span class="invalid-feedback">{{$errors->first('email_user')}}</span>
                            @endif
                        </div>
                        <div class="col-6 form-group">
                            <label>Cargo del Administrador</label>
                            <input type="text" class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}"
                                   name="position" value="{{ old('position') ?? $business->position }}">
                            @if($errors->has('position'))
                                <span class="invalid-feedback">{{$errors->first('position')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 form-group">
                            <label>Teléfono del Administrador</label>
                            <input type="text" class="form-control{{ $errors->has('phone_user') ? ' is-invalid' : '' }}"
                                   name="phone_user" value="{{ old('phone_user') ?? $business->phone_user }}">
                            @if($errors->has('phone_user'))
                                <span class="invalid-feedback">{{$errors->first('phone_user')}}</span>
                            @endif
                        </div>
                    </div>
                    </div>
                    </div>

                    <div class="card form-card mb-4">
                    <div class="card-body">
                    <h3 class="section-title">
                        Información de tu empresa
                    </h3>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Rut de la Empresa</label>
                            <input type="text" class="form-control {{$errors->has('rut_business') ? 'is-invalid' : ''}}"
                                   name="rut_business"
                                   value="{{old('rut_business') ?? $business->business_meta->rut_business ?? ''}}"/>
                            @if($errors->has('rut_business'))
                                <span class="invalid-feedback">{{$errors->first('rut_business')}}</span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Razón Social</label>
                            <input type="text"
                                   class="form-control {{$errors->has('business_name') ? 'is-invalid' : ''}}"
                                   name="business_name"
                                   value="{{ old('business_name') ?? $business->business_meta->business_name ?? '' }}"/>
                            @if($errors->has('business_name'))
                                <span class="invalid-feedback">{{$errors->first('business_name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Nombre de Fantasía</label>
                            <input type="text" class="form-control {{$errors->has('fantasy_name') ? 'is-invalid' : ''}}"
                                   name="fantasy_name"
                                   value="{{old('fantasy_name') ?? $business->business_meta->fantasy_name ?? ''}}"/>
                            @if($errors->has('fantasy_name'))
                                <span class="invalid-feedback">{{$errors->first('business_name')}}</span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Giro</label>
                            <input type="text" class="form-control {{$errors->has('activity') ? 'is-invalid' : ''}}"
                                   name="activity"
                                   value="{{old('activity') ?? $business->business_meta->activity ?? ''}}"/>
                            @if($errors->has('activity'))
                                <span class="invalid-feedback">{{$errors->first('activity')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Dirección comercial</label>
                            <input type="text" class="form-control {{$errors->has('address') ? 'is-invalid' : ''}}"
                                   name="address"
                                   value="{{old('address') ?? $business->business_meta->address ?? ''}}"/>
                            @if($errors->has('address'))
                                <span class="invalid-feedback">{{$errors->first('address')}}</span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Comuna</label>
                            <input type="text" class="form-control {{$errors->has('comune') ? 'is-invalid' : ''}}"
                                   name="comune"
                                   value="{{old('comune') ?? $business->business_meta->comune ?? ''}}"/>
                            @if($errors->has('comune'))
                                <span class="invalid-feedback">{{$errors->first('comune')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Ciudad</label>
                            <input type="text" class="form-control {{$errors->has('city') ? 'is-invalid' : ''}}"
                                   name="city"
                                   value="{{old('city') ?? $business->business_meta->city ?? ''}}"/>
                            @if($errors->has('city'))
                                <span class="invalid-feedback">{{$errors->first('city')}}</span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Región</label>
                            <input type="text" class="form-control {{$errors->has('state') ? 'is-invalid' : ''}}"
                                   name="state"
                                   value="{{old('state') ?? $business->business_meta->state ?? ''}}"/>
                            @if($errors->has('state'))
                                <span class="invalid-feedback">{{$errors->first('state')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="text" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}"
                                   name="email"
                                   value="{{old('email') ?? $business->business_meta->email ?? ''}}"/>
                            @if($errors->has('email'))
                                <span class="invalid-feedback">{{$errors->first('email')}}</span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Teléfono</label>
                            <input type="text" class="form-control {{$errors->has('phone') ? 'is-invalid' : ''}}"
                                   name="phone"
                                   value="{{old('phone') ?? $business->business_meta->phone ?? ''}}"/>
                            @if($errors->has('phone'))
                                <span class="invalid-feedback">{{$errors->first('phone')}}</span>
                            @endif
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Cantidad de empleados</label>
                            <input type="text" class="form-control {{$errors->has('employees') ? 'is-invalid' : ''}}"
                                   name="employees"
                                   value="{{old('employees') ?? $business->business_meta->employees ?? ''}}"/>
                            @if($errors->has('employees'))
                                <span class="invalid-feedback">{{$errors->first('employees')}}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Sube el logo de tu empresa</label>
                            <input type="file" name="picture"
                                   class="form-control{{ $errors->has('picture') ? ' is-invalid' : '' }}"/>
                            @if ($errors->has('picture'))
                                <span class="invalid-feedback">{{ $errors->first('picture') }}</span>
                            @endif
                        </div>
                    </div>
                    </div>
                    </div>

                    <div class="form-actions mb-5">
                        <a href="{{ route('business.profile') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar los datos</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .business-form-page .page-title {
            color: #323D7E;
            font-weight: 800;
            font-size: 1.6rem;
        }
        .business-form-page .form-card {
            border: 0;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(50, 61, 126, .12);
        }
        .business-form-page .form-card .card-body { padding: 1.75rem; }
        .business-form-page .section-title {
            color: #323D7E;
            font-weight: 700;
            font-size: 1.15rem;
            padding-bottom: .6rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #f0e3cf;
        }
        .business-form-page .form-group { margin-bottom: 1.15rem; }
        .business-form-page label {
            font-weight: 600;
            font-size: .85rem;
            color: #495057;
            margin-bottom: .35rem;
        }
        .business-form-page .form-control {
            height: calc(1.6em + 1rem);
            border-radius: 6px;
        }
        .business-form-page .form-control:focus {
            border-color: #323D7E;
            box-shadow: 0 0 0 .2rem rgba(50, 61, 126, .15);
        }
        .business-form-page input[type=file].form-control {
            height: auto;
            padding: .45rem .6rem;
        }
        .business-form-page .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: .75rem;
        }
        .business-form-page .btn-primary { min-width: 160px; }
    </style>
@endpush