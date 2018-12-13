@extends('app')

@section('breadcrumb')
    Avaliações
@endsection

@section('content')


    <div class="col-left">
        <table class="table table-hover">
            <thead>
            <tr class="orderBy">
                <th><a href="{{Order::url('codigo')}}">Turma</a><i class="caret"></i></th>
                <th><a href="{{Order::url('inicio')}}">Data<i class="caret"></i></a></th>
                <th><a href="{{Order::url('solucao.nome')}}">Solução<i class="caret"></i></a></th>
                <th><a href="{{Order::url('municipio.nome')}}">Município<i class="caret"></i></a></th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>

            @forelse($turmas as $turma)
                <tr>
                    <td><a href="{{ route('avaliacoes.ver', ['codigoTurma' => $turma->codigo]) }}">{{ Utils::highlighting($turma->codigo, Input::get('like')) }}</a></td>
                    <td>{{ $turma->inicio->format('d/m/Y') }}</td>
                    <td class="limita-texto">{{ Utils::highlighting($turma->solucao->nome, Input::get('like')) }}</td>
                    <td>{{ Utils::highlighting($turma->municipio->nome, Input::get('like')) }}</td>
                    <td class="smile">{{ $turma->avaliacao->nps }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhum registro encontrado</td>
                </tr>
            @endforelse

            </tbody>
        </table>

        <?php echo $turmas->appends(Input::query())->render() ?>

    </div>

    <div class="col-right space">

        <form id="formFilter" method="get">

            <div class="form-group">
                <input type="hidden" value="{{ $periodoDef }}" id="periodoDef" name="periodoDef" />
                <h2>Período em dias</h2>
                <div class="btn-group">
                    <button type="button" class="periodoDef btn btn-periodo {{ $periodoDef == '30' ? 'select' : '' }}">30</button>
                    <button type="button" class="periodoDef btn btn-periodo {{ $periodoDef == '90' ? 'select' : '' }}">90</button>
                    <button type="button" class="periodoDef btn btn-periodo {{ $periodoDef == '180' ? 'select' : '' }}">180</button>
                    <button type="button" class="periodoDef btn btn-periodo {{ $periodoDef == '360' ? 'select' : '' }}">360</button>
                    <button type="button" class="periodoDef btn btn-periodo {{ $periodoDef == 'PER' ? 'select' : '' }}">PER</button>
                </div>
            </div>

            <div class="form-group" id="divPeriodo" style="{{ $periodoDef != 'PER' ? 'display:none;' : '' }}">
                <h2>Período:</h2>
                <div>
                    <input type="text" class="datePicker" style="width: 45%;" id="frmInicio" name="inicio" placeholder="De"  value="{{ Input::get('inicio') }}">
                    <input type="text" class="datePicker" style="width: 45%;" id="frmFim" name="fim" placeholder="Até" value="{{ Input::get('fim') }}">
                </div>
            </div>

            <div class="form-group">
                <h2>Palavra-chave:</h2>
                <input type="text" class="form-control input-sm textbox" name="like" value="{{ Input::get('like') }}" />
            </div>

            @if(!Sebrae::in(['Gerente de Regional', 'Técnico de Microregião']) )
                @include('filtros.regiao')
            @endif

            @if(!Sebrae::is('Técnico de Microregião') )
                @include('filtros.microRegiao')
            @endif

            @include('filtros.municipio')


            @if(!Sebrae::is('Consultor') )
                @include('filtros.solucao')

                @include('filtros.consultor')
            @endif

            <div class="form-group">
                <button type="submit" class="btn btn-primary select">Filtrar</button>
            </div>

        </form>

        <script>
            $(".periodoDef").click(function() {
                var val = $(this).html();
                $("#periodoDef").val(val);

                if (val === 'PER') {
                    $("#divPeriodo").css('display', '');
                } else {
                    $("#frmInicio").val('');
                    $("#frmFim").val('');
                    $("#formFilter").submit();
                }
            });
        </script>

    </div>
@endsection