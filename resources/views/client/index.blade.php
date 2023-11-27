@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">
                    Clientes
                </div>

                @include('includes.alerts')

                <div class="row mt-3">
                    <div class="col-md-12">
                        <a class="btn btn-success" href="{{ route('client.create') }}">Novo Cliente</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="clients">
                            <thead>
                                <tr class="text-center">
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>Endereço</th>
                                    <th>Data de Nascimento</th>
                                    <th>Telefone</th>
                                    <th>Tags</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clients as $client)
                                    <tr>
                                        <td>{{ $client->code }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>
                                            {{ $client->setAddress() }}
                                        </td>
                                        <td>
                                            {{ date('d/m/Y', strtotime($client->birth))}}
                                        </td>
                                        <td>
                                            {{ $client->phone }}
                                        </td>
                                        <td>
                                            <ul>
                                                @forelse ($client->clientTags as $clientTag)
                                                    <li>{{ $clientTag->tags->name }}</li>
                                                @empty
                                                @endforelse
                                            </ul>
                                        </td>
                                        <td>
                                            <a href="{{ route('client.edit', $client->id) }}" class="btn btn-success">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a class="btn btn-danger delete-client" data-id="{{ $client->id }}">
                                                <i class="bi bi-trash3"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="7">Sem Registros</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#clients').DataTable();

            $('.delete-client').on('click', function() {
                let deleteButton = $(this);
                let client = deleteButton.attr('data-id');

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: "Deseja deletar esse cliente?",
                    text: "Essa ação não pode ser revertida",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sim",
                    cancelButtonText: "Não",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('{{ route("client.destroy")}}',  {
                            client: client
                        })
                        .done(function (data) {
                            swalWithBootstrapButtons.fire({
                                title: "Removido!",
                                text: data.message,
                                icon: "success"
                            });

                            deleteButton.closest('tr').remove();
                        })
                        .fail(function (jqXHR) {
                            swalWithBootstrapButtons.fire({
                                title: "Falha ao Deletar!",
                                text: jqXHR.message,
                                icon: "error"
                            });
                        })
                    }
                });
            })
        });
    </script>
@endsection