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
                        <a class="btn btn-success" href="{{ route('client.create') }}">Nova Tag</a>
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
                                            {{ $client->address }} /
                                        </td>
                                        <td>
                                            {{ date('d/m/Y', strtotime($client->birth))}}
                                        </td>
                                        <td>
                                            {{ $client->phone }}
                                        </td>
                                        <td>
                                            <ul>
                                                @foreach ($client->clientTags as $clientTag)
                                                    <li>{{ $clientTag->tags->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <a href="{{ route('client.edit', $client->id) }}" class="btn btn-success">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a class="btn btn-danger">
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


    <script>
        new DataTable('#clients');

        $(document).ready(function() {
            
        })
    </script>
@endsection