<div class="form-group">
    <h2>Gestor da solução</h2>
    <select class="form-control input-sm dropdown" name="gestor_id">
        <option value="">Selecione</option>
        @foreach($gestores as $gestor)
            <option value="{{ $gestor->id }}" {{ Input::get('gestor_id')==$gestor->id?'selected':'' }}>{{ $gestor->nome }}</option>
        @endforeach
    </select>
</div>