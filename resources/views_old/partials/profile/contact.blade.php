        <form class="form" action="{{route('profile.contact')}}" method="post">
            <h3 class="text-center">Datos de Contacto</h3>
            @method('PUT')
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Teléfono celular</label>
                    <input class="form-control {{$errors->has('phone') ? 'is-invalid' : ''}}"
                           name="phone" value="{{old('phone') ?:$user->userMeta->phone ?? ''}}">
                    @if($errors->has('phone'))
                        <span class="invalid-feedback">{{$errors->first('phone')}}</span>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}"
                           name="email" value="{{old('email') ?:$user->email ?? ''}}">
                    @if($errors->has('email'))
                        <span class="invalid-feedback">{{$errors->first('email')}}</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>País</label>
                    <input class="form-control {{$errors->has('country') ? 'is-invalid' : ''}}"
                           name="country" value="{{old('country') ?:$user->userMeta->country ?? ''}}">
                    @if($errors->has('country'))
                        <span class="invalid-feedback">{{$errors->first('country')}}</span>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label>Provincia</label>
                    <input class="form-control {{$errors->has('state') ? 'is-invalid' : ''}}"
                           name="state" value="{{old('state') ?:$user->userMeta->state ?? ''}}">
                    @if($errors->has('state'))
                        <span class="invalid-feedback">{{$errors->first('state')}}</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Comuna</label>
                    <input class="form-control {{$errors->has('comune') ? 'is-invalid' : ''}}"
                           name="comune" value="{{old('comune') ?:$user->userMeta->comune ?? ''}}">
                    @if($errors->has('comune'))
                        <span class="invalid-feedback">{{$errors->first('comune')}}</span>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label>Ciudad</label>
                    <input class="form-control {{$errors->has('city') ? 'is-invalid' : ''}}"
                           name="city" value="{{old('city') ?:$user->userMeta->city ?? ''}}">
                    @if($errors->has('city'))
                        <span class="invalid-feedback">{{$errors->first('city')}}</span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label>Dirección</label>
                    <input class="form-control {{$errors->has('address') ? 'is-invalid' : ''}}"
                           name="address" value="{{old('address') ?:$user->userMeta->address ?? ''}}">
                    @if($errors->has('address'))
                        <span class="invalid-feedback">{{$errors->first('address')}}</span>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar los Datos</button>
        </form>

    {{--@if($user->UserMeta && $user->email)--}}
        {{--<div class="file col-md-8 my-2">--}}
            {{--<h3 class="text-center">Datos de Contacto</h3>--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}
                    {{--<p>Teléfono celular: {{$user->UserMeta->phone}}</p>--}}
                    {{--<p>Email: {{$user->email}}</p>--}}
                    {{--<p>Dirección: {{$user->UserMeta->address}}, {{$user->UserMeta->comune}}, {{$user->UserMeta->city}}--}}
                        {{--, {{$user->UserMeta->state}}</p>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--@endif--}}
