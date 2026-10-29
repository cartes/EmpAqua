@extends('layout.app')

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
                                necesitando contratar gente y las personas que están buscando ofertas laborales. En esta
                                plataforma, las empresas tienen la posibilidad de publicar las ofertas laborales y, los
                                postulantes, tienen la opción de postular a los avisos difundidos. Las empresas,
                                posteriormente, pueden contactar a los postulantes y continuar con sus procesos de
                                selección.
                                <br><br>
                                Para esto, hemos diseñado diversos avisos, de acuerdo con la necesidad de
                                cada una de las empresas, así como un formulario único y permanente para los
                                postulantes. Además, se ofrecen vías directas de comunicación, como es el WhatsApp.
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
                                No. El rol de <strong>www.empleosaqua.cl</strong> es servir solamente como una
                                plataforma para la
                                comunicación entre avisadores y postulantes. El sitio presenta tableros de gestión,
                                tanto para avisadores, como para los postulantes, con el fin de que el encuentro sea más
                                rápido y eficiente. Este portal, en ningún caso, formará parte de los proceso de
                                selección de una compañía.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThree"
                                        aria-expanded="true" aria-controls="collapseThree">
                                    ¿Cuál es la forma de pago?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseThree" class="collapse hide" aria-labelledby="headingThree"
                             data-parent="#accordion">
                            <div class="card-body">
                                En <strong>www.empleosaqua.cl</strong> se puede utilizar Webpay –de Transbank S.A.– para
                                pagar los
                                productos Básico, Premium y Corporativo. Al momento de escoger el tipo de aviso que la
                                empresa desea publicar, en la página de los productos, al hacer click en contratar, se
                                va a desplegar la página de Webpay y se podrá elegir el método de pago que más le
                                acomode.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFour"
                                        aria-expanded="true" aria-controls="collapseFour">
                                    ¿Cuánto tarda un aviso en ser publicado en la web?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseFour" class="collapse hide" aria-labelledby="headingFour"
                             data-parent="#accordion">
                            <div class="card-body">
                                Los avisos son publicados de forma inmediata, una vez que estos han sido creados en el
                                formulario correspondiente. Al hacer click en “Publicar Aviso”, este se desplegará según
                                el tipo de aviso que el cliente haya contratado.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFive">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFive"
                                        aria-expanded="true" aria-controls="collapseFive">
                                    ¿Cuándo recibo la factura por los servicios adquiridos?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseFive" class="collapse hide" aria-labelledby="headingFive"
                             data-parent="#accordion">
                            <div class="card-body">
                                Una vez realizada la transacción, nuestro proceso de cobranza necesita 48 horas para
                                verificar el pago y, luego de eso, enviamos la factura a la dirección tributaria
                                electrónica.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingSix">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseSix"
                                        aria-expanded="true" aria-controls="collapseSix">
                                    Registro en <strong>www.empleosaqua.cl </strong>
                                </button>
                            </h5>
                        </div>

                        <div id="collapseSix" class="collapse hide" aria-labelledby="headingSix"
                             data-parent="#accordion">
                            <div class="card-body">
                                Tanto para los usuarios empresa, como para los usuarios postulantes, la plataforma
                                presenta la oportunidad de registrarse una sola vez. De esta manera, cuando los usuarios
                                quieran usar el sitio solo deberán autentificarse con su e-mail y password. El sitio,
                                además, presenta la posibilidad de ir modificando los datos de registro.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingSeven">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseSeven"
                                        aria-expanded="true" aria-controls="collapseSeven">
                                    Mi empresa ya se encuentra registrada ¿cuál es el motivo?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseSeven" class="collapse hide" aria-labelledby="headingSeven"
                             data-parent="#accordion">
                            <div class="card-body">
                                Si al momento de registrar tu empresa te das cuenta de que ya está registrada, esto
                                significa que alguien ya lo hizo por ti, para lo cual te pedimos que te contactes con
                                nosotros con el fin de determinar si esto es incorrecto y poder corregirlo a la brevedad
                                posible.
                                El e-mail es el siguiente: <a href="mailto:contacto@emplesoaqua.cl">contacto@emplesoaqua.cl</a>.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingEight">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseEight"
                                        aria-expanded="true" aria-controls="collapseEight">
                                    ¿Cuántos tipos de avisos existen?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseEight" class="collapse hide" aria-labelledby="headingEight"
                             data-parent="#accordion">
                            <div class="card-body">
                                En <strong>www.empleosaqua.cl</strong> hemos creado cuatro tipos distintos de avisos que
                                vienen a dar
                                respuesta a las distintas necesidades de las empresas. Para ver los tipos de avisos y
                                sus distintas funciones, por favor hacer click <a
                                        href="http://www.empleosaqua.cl/prices">aquí</a>.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingNine">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseNine"
                                        aria-expanded="true" aria-controls="collapseNine">
                                    ¿Cuánto tiempo permanece publicado el aviso en www.empleosaqua.cl?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseNine" class="collapse hide" aria-labelledby="headingNine"
                             data-parent="#accordion">
                            <div class="card-body">
                                La vigencia del aviso no es lo más importante; lo importante es que la mayor cantidad de
                                gente conteste tu aviso. De todas maneras, el tiempo de vigencia tendrá relación con el
                                plan que hayas contratado (ver más en <a href="www.empleosaqua.cl/prices">www.empleosaqua.cl/prices</a>).
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTen"
                                        aria-expanded="true" aria-controls="collapseTen">
                                    ¿Qué tipo de avisos no están permitidos?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseTen" class="collapse hide" aria-labelledby="headingTen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Publicar avisos en <strong>www.empleosaqua.cl</strong> es la mejor herramienta existente
                                en la actualidad
                                en la zona sur del país para el sector acuícola y pesquero y queremos que siga siendo
                                así. Por ello, si tu aviso tiene relación con servicios sexuales, promocionar productos
                                o servicios específicos, negocios piramidales o multinivel, entre otros, estos serán
                                eliminados.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingEleven">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseEleven"
                                        aria-expanded="true" aria-controls="collapseEleven">
                                    ¿Puedo editar o eliminar un aviso ya publicado?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseEleven" class="collapse hide" aria-labelledby="headingEleven"
                             data-parent="#accordion">
                            <div class="card-body">
                                Si. Hemos creado un tablero de administración de avisos donde podrás ver el status de tu
                                aviso y podrás modificar, guardar y eliminar la información que estimes conveniente.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwelve">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwelve"
                                        aria-expanded="true" aria-controls="collapseTwelve">
                                    ¿Cómo puedo crear mi currículum?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseTwelve" class="collapse hide" aria-labelledby="headingTwelve"
                             data-parent="#accordion">
                            <div class="card-body">
                                Para poder postular a los distintos avisos, tienes que regístrate y crear tu C.V. Para
                                eso, sigue los pasos en la página de registro y completa los datos que ahí te
                                consultados. Entre más completo tengas tu perfil, más información valiosa le entregas a
                                las empresas para que te contacten.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThirteen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThirteen"
                                        aria-expanded="true" aria-controls="collapseThirteen">
                                    ¿Qué hago si olvidé mi password?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseThirteen" class="collapse hide" aria-labelledby="headingThirteen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Si al momento de autentificarte en el sitio has olvidado tu password, has click en el
                                botón “Olvidaste tu contraseña” y, en forma automática, te llegará un e-mail a la
                                dirección que tengas registrada. Sigue las instrucciones para que puedas crear una nueva
                                contraseña.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFourteen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFourteen"
                                        aria-expanded="true" aria-controls="collapseFourteen">
                                    ¿Cómo puedo postular a una oferta laboral?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseFourteen" class="collapse hide" aria-labelledby="headingFourteen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Los avisos se publican en el home del sitio, según el tipo de aviso que la empresa haya
                                contratado. De igual forma, puedes buscar con las palabras claves en el buscador o hacer
                                click en alguna de las categorías o, simplemente, desplegar todos los avisos. Para
                                postular, solo debes descargar el aviso en cuestión, leerlo con detalle y, si te
                                interesa, hacer click en “Postula Acá”. Una vez realizada la postulación en línea, el
                                avisador recibirá los datos que hayas proporcionado en el formulario de creación de C.V.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingFifteen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFifteen"
                                        aria-expanded="true" aria-controls="collapseFifteen">
                                    ¿Cómo puedo saber en qué estado está mi postulación?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseFifteen" class="collapse hide" aria-labelledby="headingFifteen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Dentro de tu perfil, hemos creado un tablero de administración de postulaciones. En él
                                podrás ver toda la información referente a tus postulaciones, como, por ejemplo, si la
                                empresa vio tu C.V., si tienes agendada entrevista o si te han enviado un mensaje.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingSixteen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseSixteen"
                                        aria-expanded="true" aria-controls="collapseSixteen">
                                    ¿Me puedo contactar directo con la empresa?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseSixteen" class="collapse hide" aria-labelledby="headingSixteen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Las empresas publican los avisos y son ellas las que se van contactar directamente con
                                los postulantes, si es que así lo consideran.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingSeventeen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseSeventeen"
                                        aria-expanded="true" aria-controls="collapseSeventeen">
                                    ¿De qué manera las empresas se pueden contactar conmigo?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseSeventeen" class="collapse hide" aria-labelledby="headingSeventeen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Las empresas se contactan directamente con los postulantes a través de los datos de
                                contacto que tú entregas. Es por eso que es muy importante que registres un e-mail que
                                uses con regularidad y tu teléfono celular.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingEighteen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseEighteen"
                                        aria-expanded="true" aria-controls="collapseEighteen">
                                    ¿Quién puede ver mi currículum?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseEighteen" class="collapse hide" aria-labelledby="headingEighteen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Tu C.V. es visto por la persona que publicó el aviso al cuál postulaste.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingNineteen">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseNineteen"
                                        aria-expanded="true" aria-controls="collapseNineteen">
                                    ¿Por qué las empresas no se contactan conmigo?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseNineteen" class="collapse hide" aria-labelledby="headingNineteen"
                             data-parent="#accordion">
                            <div class="card-body">
                                Puede ser que no hayas ingresado correctamente tus datos de contacto. También te
                                recomendamos que, al momento de crear tu C.V., llenes todos los campos. Las empresas se
                                fijan en ese detalle y, entre más completo esté tu currículum, más interés habrá, por
                                parte de los reclutadores, de contactarte.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwenty">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwenty"
                                        aria-expanded="true" aria-controls="collapseTwenty">
                                    ¿Cómo puedo actualizar mi C.V.?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseTwenty" class="collapse hide" aria-labelledby="headingTwenty"
                             data-parent="#accordion">
                            <div class="card-body">
                                En “Editar Perfil” podrás editar y cambiar todos los datos que ingresaste, así como
                                agregar datos, si es que corresponde. Es muy recomendable que mantengas al día tu C.V.,
                                ya sea porque te cambiaste de trabajo, porque realizaste algún tipo de capacitación o
                                cambiaste tus datos de contacto. Las actualizaciones que hagas en tu perfil quedarán
                                registradas en forma automática y estarán disponibles para ser vistas por las empresas
                                desde el momento de la actualización, incluso para las empresas a cuyo aviso ya hayas
                                postulado con anterioridad.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwentyone">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwentyone"
                                        aria-expanded="true" aria-controls="collapseTwentyone">
                                    ¿Cómo puedo cargar mi CV en formato Word o PDF?
                                </button>
                            </h5>
                        </div>

                        <div id="collapseTwentyone" class="collapse hide" aria-labelledby="headingTwentyone"
                             data-parent="#accordion">
                            <div class="card-body">
                                El formato de C.V. que tú llenas es un resumen que le permite a las empresas, a través
                                del tablero de administración de postulantes, administrar a todos los postulantes. Pero
                                esto es insuficiente y es importante que subas tu C.V. en formato Word o PDF para que
                                las empresas puedan acceder a toda tu información laboral relevante. Para esto, en el
                                formulario de registro existe una opción donde podrás subir tu C.V. desde tu computador.
                                El archivo que subas no puede pesar más de 2 MB.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
