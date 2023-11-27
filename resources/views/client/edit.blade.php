@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">
                    Edit Cliente - {{ $client->name }}
                </div>

                @include('includes.alerts')

                <div class="card-body">
                    <form class="row g-3" action="{{ route('client.update', $client->id) }}" method="POST">
                        @csrf
                        <div class="col-md-6">
                            <label for="inputName" class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control name" id="inputName" value="{{ $client->name ?? old('name')}}">
                        </div>

                        <div class="col-md-2">
                            <label for="inputBirth" class="form-label">Data de Nascimento</label>
                            <input type="date" name="birth" class="form-control birth" id="inputBirth" value="{{ $client->birth ?? old('birth')}}">
                        </div>

                        <div class="col-md-3">
                            <label for="inputPhone" class="form-label">Contato</label>
                            <input type="text" name="phone" class="form-control phone" id="inputPhone" value="{{ $client->phone ?? old('phone')}}" placeholder="(00) 0000-0000">
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-2">
                                <label for="inputZipCode" class="form-label">CEP:</label>
                                <input type="text" name="zip_code" class="form-control zip_code" id="zip_code" value="{{ $client->zip_code ?? old('zip_code')}}">
                            </div>

                            <div class="col-md-4">
                                <label for="inputAddress" class="form-label">Endereço:</label>
                                <input type="text" name="address" class="form-control address" id="address" value="{{ $client->address ?? old('address')}}">
                            </div>

                            <div class="col-md-1">
                                <label for="inputNumberAddress" class="form-label">Número:</label>
                                <input type="text" name="number_address" class="form-control number_address" id="number_address" value="{{ $client->number_address ?? old('number_address')}}">
                            </div>

                            <div class="col-md-3">
                                <label for="inputComplement" class="form-label">Complemento:</label>
                                <input type="text" name="complement" class="form-control complement" id="complement" value="{{ $client->complement ?? old('complement')}}">
                            </div>

                            <div class="col-md-2">
                                <label for="inputNeighborhood" class="form-label">Bairro:</label>
                                <input type="text" name="neighborhood" class="form-control neighborhood" id="neighborhood" value="{{ $client->neighborhood ?? old('neighborhood')}}">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="inputState" class="form-label">Estado:</label>
                                <select name="state_id" class="state_id form-select form-select-sm mb-3" id="state_id" aria-label="Estado">
                                    <option value="">Selecione...</option>
                                  </select>
                            </div>

                            <div class="col-md-4">
                                <label for="inputCity" class="form-label">Cidade:</label>
                                <select name="city_id" class="city_id form-select form-select-sm mb-3" id="city_id" aria-label="Cidade">
                                    <option value="">Selecione...</option>
                                  </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="inputTags" class="form-label">Tags:</label>
                                <select name="tag_id[]" multiple class="tag_id form-select form-select-sm mb-3" id="tag_id" aria-label="tag">
                                    <option value="">Selecione...</option>
                                    @forelse ($tags as $tag)
                                        <option value="{{ $tag->id }}"
                                            {{ in_array($tag->id, $client->clientTags->pluck('tag_id')->toArray()) ? 'selected' : '' }}
                                        >{{ $tag->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <a href="{{ route('client.index') }}"class="btn btn-danger">Voltar</a>
                            <button type="submit" class="btn btn-primary">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('bottom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function clearFormZipCode() {
            $("#address").val("");
            $("#neighborhood").val("");
            $("#state_id").val("");
            $("#city_id").val("");
            $("#number_address").val("");
            $("#complement_address").val("");
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.zip_code').mask('00000-000');
            $('.phone').mask('(00) 0000-00000');

            $('#zip_code').on('blur', function() {
                let zipCode = $(this).val().replace(/\D/g, "");

                if (zipCode != "") {
                    let validateZipCode = /^[0-9]{8}$/;

                    if (validateZipCode.test(zipCode)) {
                        $("#address").val("...");
                        $("#neighborhood").val("...");
                        $("#state_id").val("...");
                        $("#city_id").val("...");

                        $.getJSON("https://viacep.com.br/ws/" + zipCode + "/json/?callback=?", function (data) {
                            if (!("erro" in data)) {
                                $("#address").val(data.logradouro);
                                $("#neighborhood").val(data.bairro);

                                $.post("{{ route('client.setStateCity') }}",{ city: data.ibge }, function (dataComplement) {
                                    let states = "<option value=''>Selecione...</option>";
                                    let cities = "<option value=''>Selecione...</option>";

                                    $.each(dataComplement.states, function (index, state) {
                                        let selectedState = state.id == dataComplement.selected_state ? "selected" : "";

                                        states += '<option value="' + state.id + '" ' + selectedState + "  >" + state.name + "</option>";
                                    });

                                    $.each(dataComplement.cities, function (index, city) {
                                        let selectedCity = city.number == data.ibge ? "selected" : "";

                                        cities += '<option value="' + city.id + '" ' + selectedCity + "  >" + city.name + "</option>";
                                    });
                                    
                                    $("#state_id").html(states);
                                    $("#city_id").html(cities);
                                });
                            } else {
                                clearFormZipCode();
                                alert("CEP não encontrado.");
                            }
                        });
                    } else {
                        clearFormZipCode();
                        alert('Formato de CEP inválido.')
                    }
                } else {
                    clearFormZipCode();
                }
            }).trigger('blur');

            $('.tag_id').select2({
                tags: true,
                placeholder: 'Selecione, ou cadastre, uma TAG...'
            });
        })
    </script>
@endsection