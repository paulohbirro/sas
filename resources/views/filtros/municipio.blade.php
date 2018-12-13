<div class="form-group">
    <h2>Município</h2>
    <select class="form-control input-sm dropdown" name="municipio_id">
        <option value="">Selecione</option>
        @foreach($municipios as $municipio)
            <option value="{{ $municipio->id }}" {{ Input::get('municipio_id')==$municipio->id?'selected':'' }}>{{ $municipio->nome }}</option>
        @endforeach
    </select>
</div>