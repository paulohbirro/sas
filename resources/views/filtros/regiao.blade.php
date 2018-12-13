<div class="form-group">
    <h2>Regional</h2>
    <select class="form-control input-sm dropdown" name="regiao_id">
        <option value="">Selecione</option>
        @foreach($regioes as $regiao)
            <option value="{{ $regiao->id }}" {{ Input::get('regiao_id')==$regiao->id?'selected':'' }}>{{ $regiao->nome }}</option>
        @endforeach
    </select>
</div>