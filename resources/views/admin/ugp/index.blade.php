@extends('app')

@section('breadcrumb')
    Administração
@endsection

@section('content')

    @include('admin.abas')

    <div class="tab-content">
        <div id="internos" class="tab-select" style="padding: 15px;">

            <div class="col-left">
                <table class="table table-hover">
                    <thead>
                    <tr class="orderBy">
                        <th><a href="{{Order::url('nome')}}">UGP</a><i class="caret"></i></th>
                        <th><a href="{{Order::url('user_ad')}}">Usuário</a><i class="caret"></i></th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($ugps as $ugp)
                        <tr>
                            <td><a href="#">{{ Utils::highlighting($ugp->nome, Input::get('like')) }}</a></td>
                            <td>{{ $ugp->user_ad }}</td>
                            <td><a href="#">Excluir</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Nenhum registro encontrado</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

                <?php echo $ugps->appends(Input::query())->render() ?>

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