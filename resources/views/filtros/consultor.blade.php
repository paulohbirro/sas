<div class="form-group">
    <h2>Consultor</h2>
    <select class="form-control input-sm dropdown" name="consultor_id">
        <option value="">Selecione</option>
        @foreach($consultores as $consultor)
            <option value="{{ $consultor->id }}" {{ Input::get('consultor_id')==$consultor->id?'selected':'' }}>{{ $consultor->nome }}</option>
        @endforeach
    </select>
</div>