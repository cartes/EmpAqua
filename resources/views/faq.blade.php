@extends('layout.app')

@section('title', ' | Preguntas frecuentes')
@section('description', 'Preguntas frecuentes sobre postulación y publicación de ofertas en EmpleosAqua.')

@section('content')

    <div class="container">
        @if (null !== session('message'))
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="alert alert-{{session('message')[0]}}" role="alert">
                        {{session('message')[1]}}
                    </div>
                </div>
            </div>
        @endif

        @include('partials.modals.loginHome')
        @include('partials.modals.loginBusiness')
        @include("partials.modals.register")
        @include('partials.modals.registerBusiness')

    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                @php ob_start(); @endphp
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                    ¿Qué es <strong>www.empleosaqua.cl</strong>?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                             data-parent="#accordion">
                            <div class="card-body">
                                El portal EmpleosAqua funciona como un punto de conexión entre las empresas que están
                                necesitando contratar personal y las personas que están buscando ofertas laborales. En
                                esta plataforma, las empresas tienen la posibilidad de publicar las ofertas laborales y
                                los postulantes, tienen la opción de postular a los avisos difundidos. Posteriormente,
                                las empresas pueden contactar a los postulantes y continuar con sus procesos de
                                selección.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo"
                                        aria-expanded="true" aria-controls="collapseTwo">
                                    ¿El portal <strong>www.empleosaqua.cl</strong> participa en el proceso de selección?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseTwo" class="collapse hide" aria-labelledby="headingTwo"
                             data-parent="#accordion">
                            <div class="card-body">
                                No, el rol de www.empleosaqua.cl es servir como una plataforma para la comunicación
                                entre los reclutadores y postulantes. El sitio presenta tableros de gestión, para los
                                captadores del talento humano y para los postulantes, con el fin de que el encuentro sea
                                más rápido y eficiente. Este portal, en ningún caso, formará parte de los proceso de
                                selección de una compañía.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThree"
                                        aria-expanded="true" aria-controls="collapseThree">
                                    ¿Cuánto tarda un aviso en ser publicado?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseThree" class="collapse hide" aria-labelledby="headingThree"
                             data-parent="#accordion">
                            <div class="card-body">
                                Los avisos son publicados de forma inmediata, una vez que han sido creados en el
                                formulario correspondiente por el reclutador.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFour"
                                        aria-expanded="true" aria-controls="collapseFour">
                                    ¿Cuándo recibo la factura por los servicios adquiridos?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseFour" class="collapse hide" aria-labelledby="headingFour"
                             data-parent="#accordion">
                            <div class="card-body">
                                Una vez contratados los servicios y emitir el pago a nuestro favor, la gestión
                                administrativa requiere 48-72 horas para verificarlo, registrar datos en los distintos
                                sistemas y seguidamente, se realiza la debida facturación.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFive">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFive"
                                        aria-expanded="true" aria-controls="collapseFive">
                                    Registro en www.empleosaqua.cl
                                </button>
                            </h5>
                        </div>

                        <div id="collapseFive" class="collapse hide" aria-labelledby="headingFive"
                             data-parent="#accordion">
                            <div class="card-body">
                                Para los usuarios empresa y postulantes, la plataforma presenta la oportunidad de
                                registrarse una sola vez. De esta manera, cuando los usuarios quieran ingresar al sitio,
                                sólo deberán autentificarse con su correo electrónico y password. El sitio, además,
                                presenta la posibilidad de ir modificando los datos de registro.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingSix">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseSix"
                                        aria-expanded="true" aria-controls="collapseSix">
                                    Mi empresa ya se encuentra registrada ¿Cuál es el motivo? </strong>
                                </button>
                            </h5>
                        </div>

                        <div id="collapseSix" class="collapse hide" aria-labelledby="headingSix"
                             data-parent="#accordion">
                            <div class="card-body">
                                Si al momento de registrar tu empresa, te percatas de que ya está registrada, esto
                                significa que alguien lo hizo por ti. Es por ello, que solicitamos nos contactes con el
                                fin de determinar si esto es correcto y presentarte otras alternativas de registro, el
                                correo electrónico contacto es <a href="mailto:contacto@emplesoaqua.cl">empleosaqua@b2bmg.cl</a>.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingSeven">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseSeven"
                                        aria-expanded="true" aria-controls="collapseSeven">
                                    ¿Cuántos tipos de aviso existen?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseSeven" class="collapse hide" aria-labelledby="headingSeven"
                             data-parent="#accordion">
                            <div class="card-body">
                                En www.empleosaqua.cl disponemos de dos tipos de avisos, “Básicos y Destacados”. Para
                                ver la cantidad de avisos disponibles por cada plan a suscribir, por favor hacer click
                                <a href="{{ route('prices') }}">aquí</a>.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingEight">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseEight"
                                        aria-expanded="true" aria-controls="collapseEight">
                                    ¿Cuánto tiempo permanece publicado un aviso en www.empleosaqua.cl?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseEight" class="collapse hide" aria-labelledby="headingEight"
                             data-parent="#accordion">
                            <div class="card-body">
                                La vigencia del aviso corresponde a 1 mes, lo más importante es recibir la mayor
                                cantidad de curriculum por publicación, pudiendo eliminarse antes de ese período, si ya
                                se seleccionó a un candidato para ocupar el cargo.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingNine">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseNine"
                                        aria-expanded="true" aria-controls="collapseNine">
                                    ¿Qué tipo de avisos no están permitidos?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseNine" class="collapse hide" aria-labelledby="headingNine"
                             data-parent="#accordion">
                            <div class="card-body">
                                Publicar avisos en www.empleosaqua.cl es la mejor herramienta existente en la actualidad
                                en la zona sur del país para los sectores productivos y queremos que siga siendo así. Es
                                Por ello, si tu aviso tiene relación con servicios sexuales, promoción de productos o
                                servicios específicos, negocios piramidales o multinivel, entre otros, estos serán
                                eliminados.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTen"
                                        aria-expanded="true" aria-controls="collapseTen">
                                    ¿Puedo editar o eliminar un aviso ya publicado?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseTen" class="collapse hide" aria-labelledby="headingTen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Si, hemos creado un tablero de administración de avisos, donde podrás ver tu
                                publicación, modificarla, guardarla y eliminar la información que estimes conveniente.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingEleven">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseEleven"
                                        aria-expanded="true" aria-controls="collapseEleven">
                                    ¿Cómo puedo crear mi currículum?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseEleven" class="collapse hide" aria-labelledby="headingEleven"
                             data-parent="#accordion">
                            <div class="card-body">
                                Para poder postular a los distintos avisos, tienes que registrarte y cargar tu
                                currículum. Para eso, sigue los pasos en la sección de registro y completa los datos
                                requeridos en cada campo. Entre más completo tengas tu perfil, más información valiosa
                                le entregas a las empresas para que te contacten.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwelve">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwelve"
                                        aria-expanded="true" aria-controls="collapseTwelve">
                                    ¿Qué hago si olvidé mi password?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseTwelve" class="collapse hide" aria-labelledby="headingTwelve"
                             data-parent="#accordion">
                            <div class="card-body">
                                Si al momento de autentificarte en el sitio, has olvidado tu password, haz click en el
                                botón “Olvidaste tu contraseña” y en forma automática, te llegará un e-mail a la
                                dirección que tengas registrada. Sigue las instrucciones para que puedas crear una nueva
                                contraseña.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThirteen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThirteen"
                                        aria-expanded="true" aria-controls="collapseThirteen">
                                    ¿Cómo puedo postular a una oferta laboral?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseThirteen" class="collapse hide" aria-labelledby="headingThirteen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Los avisos se publican en el home del sitio. De igual forma, puedes buscar con las
                                palabras claves en el buscador o simplemente, desplegar todos los avisos. Para postular,
                                lee con detalle la información del cargo y sus requerimientos, si consideras que te
                                ajustas al perfil, haz click en “Postula Acá”. Una vez realizada la postulación, el
                                reclutador recibirá los datos que hayas proporcionado en el formulario de creación de
                                currículum.

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFourteen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFourteen"
                                        aria-expanded="true" aria-controls="collapseFourteen">
                                    ¿Cómo puedo saber en qué estado está mi postulación?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseFourteen" class="collapse hide" aria-labelledby="headingFourteen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Dentro de tu perfil, hemos creado un tablero de administración de postulaciones. En él,
                                podrás ver toda la información referente a tus postulaciones. Por ejemplo, si la empresa
                                vió tu currículum, si tienes agendada una entrevista o si te han enviado un mensaje.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFifteen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFifteen"
                                        aria-expanded="true" aria-controls="collapseFifteen">
                                    ¿Puedo contactar directamente a la empresa?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseFifteen" class="collapse hide" aria-labelledby="headingFifteen"
                             data-parent="#accordion">
                            <div class="card-body">
                                No, las empresas publican sus avisos y son ellas, quienes se van contactar directamente
                                con los postulantes, si consideran que reúnen las especificaciones del cargo vacante.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingSixteen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseSixteen"
                                        aria-expanded="true" aria-controls="collapseSixteen">
                                    ¿De qué manera las empresas me contactarán?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseSixteen" class="collapse hide" aria-labelledby="headingSixteen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Las empresas se contactan directamente con los postulantes a través de los datos de
                                contacto que tú entregas (teléfono o correo electrónico). Así como también, a través del
                                chat interno dispuesto en cada panel de gestión. Es por eso, que es muy importante que
                                registres un e-mail que uses con regularidad y tu teléfono celular.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingSeventeen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseSeventeen"
                                        aria-expanded="true" aria-controls="collapseSeventeen">
                                    ¿Quién puede ver mi currículum?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseSeventeen" class="collapse hide" aria-labelledby="headingSeventeen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Tu información curricular será vista por el reclutador que publicó el aviso al cuál
                                postulaste.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingEighteen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseEighteen"
                                        aria-expanded="true" aria-controls="collapseEighteen">
                                    ¿Por qué las empresas no se contactan conmigo?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseEighteen" class="collapse hide" aria-labelledby="headingEighteen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Puede ser que no hayas ingresado correctamente tus datos de contacto. También, existe la
                                posibilidad que te postulaste al aviso, sin cumplir con el perfil del cargo.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingNineteen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseNineteen"
                                        aria-expanded="true" aria-controls="collapseNineteen">
                                    ¿Cómo puedo actualizar mi currículum?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseNineteen" class="collapse hide" aria-labelledby="headingNineteen"
                             data-parent="#accordion">
                            <div class="card-body">
                                En “Editar Perfil” podrás editar y cambiar todos los datos que ingresaste. Así como
                                también, incorporar más información. Es indispensable que mantengas al día tu
                                currículum, bien sea porque cambiaste de empleo, realizaste algún tipo de capacitación o
                                cambiaste tus datos de contacto. Las actualizaciones que hagas en tu perfil quedarán
                                registradas de forma automática y estarán disponibles para ser vistas por las empresas
                                desde el momento de la actualización, incluso para las empresas cuyo aviso ya has
                                postulado con anterioridad.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwenty">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwenty"
                                        aria-expanded="true" aria-controls="collapseTwenty">
                                    ¿Cómo puedo cargar mi currículum en formato Word y PDF?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseTwenty" class="collapse hide" aria-labelledby="headingTwenty"
                             data-parent="#accordion">
                            <div class="card-body">
                                Los campos que llenas al momento del registro es un resumen que le permite a las
                                empresas, a través del tablero de administración de postulantes, ver la información de
                                todos los postulantes. Pero esto, es insuficiente y es importante que subas tu
                                currículum en formato Word o PDF para que las empresas puedan acceder a toda la
                                información laboral relevante. Para esto, en el formulario de registro existe una opción
                                donde podrás cargarlo desde tu computador. El archivo que subas no puede pesar más de 2
                                MB.
                            </div>
                        </div>
                    </div>
                </div>
                @php $faqHtml = ob_get_clean(); echo $faqHtml; $faq = \App\Support\Schema::faqFromHtml($faqHtml); @endphp
            </div>
        </div>
    </div>
@endsection

@push('meta')
    <link rel="canonical" href="{{ route('faq') }}" />
    {!! \App\Support\Schema::script(\App\Support\Schema::webPage('FAQPage', 'Preguntas frecuentes', route('faq'), 'Preguntas frecuentes sobre postulación y publicación de ofertas en EmpleosAqua.', ['mainEntity' => ($faq['mainEntity'] ?? [])])) !!}
@endpush
