@extends('app')

@section('breadcrumb')
    Selecionar perfil
@endsection

@section('content')

    <section id="content">



        <form id="login-form" action="{{ action('SelecionarController@getSelecionar') }}" class="form" method="GET">
            <input type="hidden" id="perfil" name="perfil" value="">

            <fieldset>
                <div class="form-group">
                    <h2>Perfil</h2>

                    @if(empty($perfis))
                        Nenhum perfil configurado. Consulte o administrador do sistema
                    @else
                        <select class="form-control" name="perfilID" id="perfilID" style="width: 400px;">
                            <option value="">Selecione um perfil</option>
                            @foreach($perfis as $perfil => $collection)
                                <optgroup label="{{ $perfil }}">

                                    @foreach($collection as $item)
                                        <option value="{{ $item->id }}">

                                            @if($item instanceof \App\Eloquent\Models\Tecnico)
                                                {{ $item->nome.' ('.$item->microregiao->nome.')' }}

                                            @elseif($item instanceof \App\Eloquent\Models\GerenteRegiao)
                                                {{ $item->nome.' ('.$item->regiao->nome.')' }}

                                            @else
                                                {{ $item->nome }}
                                            @endif

                                        </option>
                                    @endforeach

                                </optgroup>
                            @endforeach
                        </select>

                        <br /><br /><br />

                        <button type="submit" id="login-btn" class="btn btn-primary btn-block btn-blue">ACESSAR</button>
                    @endif
                </div>

            </fieldset>
        </form>

    </section>

    <script>
        $(function(){
            $('#perfilID').change(function(){
                var option = $('option:selected', this);
                var perfil = option.closest('optgroup').attr('label');

                $('#perfil').val(perfil);
            });
        });
    </script>


@endsection