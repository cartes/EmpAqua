<form class="form-business" method="post" action="{{route('post.register')}}">
    <div class="row">
        <div class="col-md-6">
            <h3 class="text-left mb-3">Crea tu cuenta</h3>
        </div>
        <div class="col-md-6">
            <div class="login-container text-right">
                <a href="{{route('business.index')}}" class="btn btn-primary">Ya tengo Cuenta</a>
            </div>
        </div>
    </div>
    @csrf
    @method("PUT")
    <div class="row">
        <div class="col-md-12 form-group">
            <h5><strong>Información del usuario</strong></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <label>Nombre</label>
            <input type="text" class="form-control {{$errors->has('firstname') ? 'is-invalid' : ''}}" name="firstname"
                   value="{{old('firstname')}}"/>
            @if($errors->has('firstname'))
                <span class="invalid-feedback">{{$errors->first('firstname')}}</span>
            @endif
        </div>
        <div class="col-md-6 form-group">
            <label>Apellido</label>
            <input type="text" class="form-control {{$errors->has('surname') ? 'is-invalid' : ''}}" name="surname"
                   value="{{old('surname')}}"/>
            @if($errors->has('surname'))
                <span class="invalid-feedback">{{$errors->first('surname')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <label>Email</label>
            <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" name="email"
                   value="{{old('email')}}"/>
            @if($errors->has('email'))
                <span class="invalid-feedback">{{$errors->first('email')}}</span>
            @endif
        </div>
        <div class="col-md-6 form-group">
            <label>Celular</label>
            <input type="text" class="form-control {{$errors->has('userPhone') ? 'is-invalid' : ''}}" name="userPhone"
                   value="{{old('userPhone')}}"/>
            @if($errors->has('userPhone'))
                <span class="invalid-feedback">{{$errors->first('userPhone')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <label>Rut</label>
            <input type="text" class="form-control {{$errors->has('userRut') ? 'is-invalid' : ''}}" name="userRut"
                   value="{{old('userRut')}}"/>
            @if($errors->has('userRut'))
                <span class="invalid-feedback">{{$errors->first('userRut')}}</span>
            @endif
        </div>
        <div class="col-md-6 form-group">
            <label>Cargo</label>
            <input type="text" class="form-control {{$errors->has('position') ? 'is-invalid' : ''}}" name="position"
                   value="{{old('position')}}"/>
            @if($errors->has('position'))
                <span class="invalid-feedback">{{$errors->first('position')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <label>Contraseña</label>
            <input type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" name="password"
                   value="{{old('password')}}"/>
            @if($errors->has('password'))
                <span class="invalid-feedback">{{$errors->first('password')}}</span>
            @endif
        </div>
        <div class="col-md-6 form-group">
            <label>Verificación de la contraseña</label>
            <input type="password" class="form-control {{$errors->has('password_confirmation') ? 'is-invalid' : ''}}"
                   name="password_confirmation" value="{{old('password_confirmation')}}"/>
            @if($errors->has('password_confirmation'))
                <span class="invalid-feedback">{{$errors->first('password_confirmation')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <h5><strong>Información de la empresa</strong></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <label>Rut Empresa</label>
            <input type="text" class="form-control {{$errors->has('rut') ? 'is-invalid' : ''}}" name="rut"
                   value="{{old('rut')}}"/>
            @if($errors->has('rut'))
                <span class="invalid-feedback">{{$errors->first('rut')}}</span>
            @endif
        </div>
        <div class="col-md-6 form-group">
            <label>Razón Social</label>
            <input type="text" class="form-control {{$errors->has('business_name') ? 'is-invalid' : ''}}"
                   name="business_name"
                   value="{{old('business_name')}}"/>
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
                   value="{{old('fantasy_name')}}"/>
            @if($errors->has('fantasy_name'))
                <span class="invalid-feedback">{{$errors->first('fantasy_name')}}</span>
            @endif
        </div>
        <div class="col-md-6 form-group">
            <label>Teléfono</label>
            <input type="text" class="form-control {{$errors->has('phone') ? 'is-invalid' : ''}}" name="phone"
                   value="{{old('phone')}}"/>
            @if($errors->has('phone'))
                <span class="invalid-feedback">{{$errors->first('phone')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <label>País</label>
            <input type="text" class="form-control {{$errors->has('country') ? 'is-invalid' : ''}}" name="country"
                   value="{{old('country')}}"/>
            @if($errors->has('country'))
                <span class="invalid-feedback">{{$errors->first('country')}}</span>
            @endif
        </div>
        <div class="col-md-6 form-group">
            <label>Provincia</label>
            <input type="text" class="form-control {{$errors->has('state') ? 'is-invalid' : ''}}" name="state"
                   value="{{old('state')}}"/>
            @if($errors->has('state'))
                <span class="invalid-feedback">{{$errors->first('state')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <label>Ciudad</label>
            <input type="text" class="form-control {{$errors->has('city') ? 'is-invalid' : ''}}" name="city"
                   value="{{old('city')}}"/>
            @if($errors->has('city'))
                <span class="invalid-feedback">{{$errors->first('city')}}</span>
            @endif
        </div>
        <div class="col-md-6 form-group">
            <label>Comuna</label>
            <input type="text" class="form-control {{$errors->has('comune') ? 'is-invalid' : ''}}" name="comune"
                   value="{{old('comune')}}"/>
            @if($errors->has('comune'))
                <span class="invalid-feedback">{{$errors->first('comune')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <label>Dirección</label>
            <input type="text" class="form-control {{$errors->has('address') ? 'is-invalid' : ''}}" name="address"
                   value="{{old('address')}}"/>
            @if($errors->has('address'))
                <span class="invalid-feedback">{{$errors->first('address')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <label>Giro</label>
            <input type="text" class="form-control {{$errors->has('activity') ? 'is-invalid' : ''}}" name="activity"
                   value="{{old('activity')}}"/>
            @if($errors->has('activity'))
                <span class="invalid-feedback">{{$errors->first('activity')}}</span>
            @endif
        </div>
        <div class="col-md-6 form-group">
            <label>Rubro</label>
            <input type="text" class="form-control {{$errors->has('entry') ? 'is-invalid' : ''}}" name="entry"
                   value="{{old('entry')}}"/>
            @if($errors->has('entry'))
                <span class="invalid-feedback">{{$errors->first('entry')}}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <label>Cantidad de Empleados</label>
            <input type="text" class="form-control {{$errors->has('employees') ? 'is-invalid' : ''}}" name="employees"
                   value="{{old('employees')}}"/>
            @if($errors->has('employees'))
                <span class="invalid-feedback">{{$errors->first('employees')}}</span>
            @endif
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Guardar Datos</button>
</form>
