@extends('app')

@section('breadcrumb')
    Consultores
@endsection

@section('content')

    <nav class="tab-nav">
        <ul>
            <li class="consultor select">
                <a href="#">
                    Internos
                </a>
            </li>

            <li class="consultor">
                <a href="/consultores/externo">
                    Externos
                </a>
            </li>
        </ul>
    </nav>

    <div class="tab-content">
        <div id="internos" class="tab-select" style="padding: 15px;">

            <div class="col-left">
                <table class="table table-hover">
                    <thead>
                    <tr class="orderBy">
                        <th><a href="{{Order::url('nome')}}">Turma</a><i class="caret"></i></th>
                        <th><a href="{{Order::url('avaliacao.nps')}}"></a></th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($consultores as $consultor)
                        <tr>
                            <td><a href="{{ route('consultores.ver', ['consultorId' => $consultor->id]) }}">{{ Utils::highlighting($consultor->nome, Input::get('like')) }}</a></td>
                            <td class="smile2">{{ $consultor->notaConsultor() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Nenhum registro encontrado</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

                <?php echo $consultores->appends(Input::query())->render() ?>

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

            <div style="clear: both; "></div>

        </div>
    </div>
@endsection