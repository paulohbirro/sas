<div class="form-group">
    <h2>Microrregião</h2>
    <select class="form-control input-sm dropdown" name="micro_regiao_id">
        <option value="">Selecione</option>
        @foreach($microregioes as $microregiao)
            <option value="{{ $microregiao->id }}" {{ Input::get('micro_regiao_id')==$microregiao->id?'selected':'' }}>{{ $microregiao->nome }}</option>
        @endforeach
    </select>
</div>