@extends('app')

@section('breadcrumb')
    Microrregiões
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

            @forelse($microregioes as $microregiao)
                <tr>
                    <td><a href="{{ route('microregioes.ver', ['microregiaoId' => $microregiao->id]) }}">{{ Utils::highlighting($microregiao->nome, Input::get('like')) }}</a></td>
                    <td class="smile">{{ $microregiao->nps() }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhum registro encontrado</td>
                </tr>
            @endforelse

            </tbody>
        </table>

        <?php echo $microregioes->appends(Input::query())->render() ?>

    </div>

    <div class="col-right space">

        <form id="formFilter" method="get">


            <div class="form-group">
                <h2>Palavra-chave:</h2>
                <input type="text" class="form-control input-sm textbox" name="like" value="{{ Input::get('like') }}" />
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-primary select">Filtrar</button>
            </div>

        </form>

    </div>

@endsection