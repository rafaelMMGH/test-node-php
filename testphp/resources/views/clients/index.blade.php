@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" style="float: right" onclick="openClientModal()">
            Crear Cliente
        </button>
        <br><br>
        <div class="row" id="clientsContainer">

        @foreach($clients as $client)
            <div class="col-sm-4 mb-4">
                <div class="card" style="width: 18rem;">
                    <img src="https://www.hablax.com/includes/img/profile.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{$client->name}} {{$client->last_name_p}} {{$client->last_name_m}}</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Email: </b> {{ $client->email }}</li>
                        <li class="list-group-item"><b>Creado: </b> {{$client->created_at}}</li>
                    </ul>
                    <div class="card-body">
                        <button onclick="openClientModal({{ $client->id }})" class="btn btn-primary">Edit</button>
                        <button onclick="deleteClient({{ $client->id }})" class="btn btn-link">Delete</button>
                    </div>
                </div>
            </div>

        @endforeach
        </div>

    
    @include('clients.show')

    @section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function(){

                $("#form-client").on('submit', function(e){
                    e.preventDefault();

                    var clientData = $("#form-client").serialize();

                        $.ajax({
                            url: $("#form-client").attr('action'),
                            type: $("#form-client").attr('method'),
                            dataType: 'JSON',
                            headers: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: clientData
                        }).done(function(data){
                            Swal.fire({
                                icon: 'success',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            
                            refreshData(data.items);

                    }).fail(function(data){
                        Swal.fire({
                                icon: 'error',
                                title: 'Algo no salió bien... Intenta de nuevo',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            console.log(data);
                        })
                    
                })

            });
            
            function deleteClient(id){
                Swal.fire({
                title: 'Esta seguro de eliminar?',
                text: "Esta acción no puede ser revertida",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '/client/delete',
                        type: 'POST',
                        dataType: 'JSON',
                        headers: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {id: id, _token: $('meta[name="csrf-token"]').attr('content') }
                    }).done(function(data){
                        Swal.fire(
                            'Realizado!',
                            data.msg,
                            'success'
                        )
                        refreshData(data.items);
                    })
                }
                })
            }

            function openClientModal(id){
                $("#form-client").trigger("reset");
                if(id){
                        $.ajax({
                        url: '/client/'+id,
                        type: 'GET',
                        dataType: 'JSON',
                    }).done(function(data){
                        $("#clientModalLabel").html("Editar Cliente");
                        $("#btn-client").html("Editar");

                        $("#id").val(data.item.id);
                        $("#name").val(data.item.name);
                        $("#last_name_p").val(data.item.last_name_p);
                        $("#last_name_m").val(data.item.last_name_m);
                        $("#address").val(data.item.address);
                        $("#email").val(data.item.email);

                    }).fail(function(data){
                        console.log(data);
                    })
                }      
                
                $("#clientModal").modal('show');
            }

            function refreshData(items){
                $("#clientModal").modal('hide');
                        $("#clientsContainer").empty();

                        if(items.length >0){
                            for(var i=0; i< items.length; i++){
                                $("#clientsContainer").append(`
                                <div class="col-sm-4 mb-4">
                                    <div class="card" style="width: 18rem;">
                                        <img src="https://www.hablax.com/includes/img/profile.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">  ${items[i].name} ${items[i].last_name_p} ${items[i].last_name_m}  </h5>
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><b>Email: </b> ${items[i].email}</li>
                                            <li class="list-group-item"><b>Creado: </b> ${items[i].created_at}</li>
                                        </ul>
                                        <div class="card-body">
                                            <button onclick="openClientModal(${items[i].id})" class="btn btn-primary">Edit</button>
                                            <button onclick="deleteClient(${items[i].id})" class="btn btn-link">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                `);
                            }
                        }
            }

        </script>
    @endsection

</div>
@endsection
