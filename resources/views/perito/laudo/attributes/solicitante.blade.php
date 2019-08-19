<div class="col-lg-{{ $size ?? "4" }} mt-2">
    <label for="solicitante_id">Órgão Solicitante</label>
    <select class="form-control {{ $errors->has('solicitante_id') ? ' is-invalid' : '' }}"
            name="solicitante_id" id="solicitante_id">
        <option value="selecionar">Selecione uma Cidade</option>
        @foreach([] ?? $solicitantes as $solicitante)
            <option value="{{ $solicitante->id }}" {{ $solicitante->id == $solicitante2 ? 'selected=selected' : '' }}>
                {{$solicitante->nome}}
            </option>
        @endforeach
        <option id="cadastrar_solicitante">Cadastrar Opção</option>
    </select>
    @include('shared.error_feedback', ['name' => 'solicitante_id'])
</div>