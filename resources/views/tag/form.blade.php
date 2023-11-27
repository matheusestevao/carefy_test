@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">
                    Nova Tag
                </div>

                @include('includes.alerts')

                <div class="card-body">
                    @if (isset($tag))
                        <form class="row g-3" action="{{ route('tag.update', $tag->id) }}" method="POST">
                    @else
                        <form class="row g-3" action="{{ route('tag.store') }}" method="POST">
                    @endif
                        @csrf
                        <div class="col-md-6">
                            <label for="inputName" class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" id="inputName" value="{{ $tag->name ?? old('name')}}">
                        </div>
                        
                        <div class="col-12">
                            <a href="{{ route('tag.index') }}"class="btn btn-danger">Voltar</a>
                            <button type="submit" class="btn btn-primary">
                                @if (isset($tag))
                                    Atualizar
                                @else
                                    Salvar
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection