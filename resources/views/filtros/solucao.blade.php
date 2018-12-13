<div class="form-group">
    <h2>Solução</h2>
    <select class="form-control input-sm dropdown" name="solucao_id">
        <option value="">Selecione</option>
        @foreach($solucoes as $solucao)
            <option value="{{ $solucao->id }}" {{ Input::get('solucao_id')==$solucao->id?'selected':'' }}>{{ $solucao->nome }}</option>
        @endforeach
    </select>
</div>