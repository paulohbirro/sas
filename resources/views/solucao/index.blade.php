@extends('app')

@section('breadcrumb')
    Soluções
@endsection

@section('content')

    <div class="col-left">
        <table class="table table-hover">
            <thead>
            <tr class="orderBy">
                <th><a href="{{Order::url('nome')}}">Turma</a><i class="caret"></i></th>
                <th><a href="{{Order::url('avaliacao.nps')}}"></a></th>
            </tr>
            </thead>
            <tbody>

            @forelse($solucoes as $solucao)
                <tr>
                    <td><a href="{{ route('solucoes.ver', ['solucaoId' => $solucao->id]) }}">{{ Utils::highlighting($solucao->nome, Input::get('like')) }}</a></td>
                    <td class="smile">{{ $solucao->nps() }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhum registro encontrado</td>
                </tr>
            @endforelse

            </tbody>
        </table>

        <?php echo $solucoes->appends(Input::query())->render() ?>

    </div>

    <div class="col-right space">

        <form id="formFilter" method="get">


            <div class="form-group">
                <h2>Palavra-chave:</h2>
                <input type="text" class="form-control input-sm textbox" name="like" value="{{ Input::get('like') }}" />
            </div>

            @include('filtros.regiao')


            @include('filtros.microRegiao')


            @include('filtros.municipio')


            <div class="form-group">
                <button type="submit" class="btn btn-primary select">Filtrar</button>
            </div>

        </form>

    </div>

@endsection