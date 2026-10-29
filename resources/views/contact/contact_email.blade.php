<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<div class="card">
    <div class="card-header">
        <div class="row justify-content-center">
            <div class="col-8">
                <h2 class="card-title">Hola Administrador, tienes un nuvo mensaje de {{$email}}</h2>

                <h3 class="card-title">Nombre: {{ $name }}</h3>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-10">
                <b>Name:</b> {{ $name }}
                <b>Email:</b> {{ $email }}
                <b>Phone Number:</b> {{ $phone }}
                <b>Subject:</b> {{ $subject }}
                <b>Message:</b> {{ $message_user }}
            </div>
        </div>
    </div>
</div>