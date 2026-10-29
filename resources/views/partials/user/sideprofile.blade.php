<div id="side_profile" class="col-md-4">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="row">
                        <div class="col-12">
                            <div class="img-profile-container mx-auto mb-4">
                                <img class="img-profile" src="{{  $user->profileAttachment() }}"
                                     alt="{{ $user->picture }}"/>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-uppercase text-center">{{$user->name}}</h4>
                    <a class="btn btn-outline-primary" href="{{ route('profile') }}">Editar
                        perfil</a>
                </div>
            </div>
        </div>
    </div>
</div>
