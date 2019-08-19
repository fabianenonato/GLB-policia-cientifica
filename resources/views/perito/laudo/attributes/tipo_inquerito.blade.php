<div class="col-lg-{{ $size ?? "8" }} mt-2">
    <label for="tipo_inquerito">Tipo do Inquerito</label>
    <select class="form-control {{ $errors->has('tipo_inquerito') ? ' is-invalid' : '' }}"
            name="tipo_inquerito">
        @foreach(['BO', 'Inquerito Policial', 'Inquerito Policial Flagrante Delito'] as $tipo_inquerito)
            <option value="{{ $tipo_inquerito->id }}" {{ $tipo_inquerito->id == $tipo_inquerito2 ? 'selected=selected' : '' }}>
                {{$tipo_inquerito->nome}}
            </option>
        @endforeach
    </select>
    @include('shared.error_feedback', ['name' => 'tipo_inquerito'])
</div>