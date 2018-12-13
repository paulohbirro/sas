@extends('app')

@section('breadcrumb')
    Administração
@endsection

@section('content')

    @include('admin.abas')




    <link href="/css/style.css" rel="stylesheet">




    
    <div class="tab-content">
        <div id="internos" class="tab-select" style="padding: 15px;">



            <div class="col-left">
                <table class="table table-hover">
                    <thead>
                    <tr class="orderBy">
                        <th><a href="{{Order::url('nome')}}">Microregião</a><i class="caret"></i></th>
                        <th>Região</th>
                        <th>Municípios</th>
                        <th>Técnicos</th>
                        <th>Turmas</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($microregioes as $micro)

                       <tr>
                            <td><a href="#">{{ Utils::highlighting($micro->nome, Input::get('like')) }}</a></td>
                            <td>{{ $micro->regiao->nome }}</td>
                            <td>{{ $micro->municipios->count() }}</td>
                            <td>{{ $micro->tecnicos->count() }}</td>
                            <td>{{ $micro->turmas->count() }}</td>
                            <td> <a  href="{{route('admin.microregioes.editar',$micro->id) }}">Editar</a></td>
                            <td><a class="excluirTurma" data-href="{{ route('admin.microregioes.excluir',$micro->id) }}" href="#">Excluir</a></td>
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

            <div style="clear: both; "></div>

        </div>
    </div>




    <div class="modal fade" tabindex="-1" role="dialog" id="modalConfirm" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Excluir Microregião</strong></h4>
                </div>
                <div class="modal-body">
                    <h3>Deseja realmente excluir essa Microregião?</h3><br />
                    <a href="#" id="linkExcluir" class="btn btn-primary select" style="color: #FFF !important; text-decoration: none;">Sim</a>
                    <a href="#" data-dismiss="modal" class="btn btn-primary" style="text-decoration: none;">Não</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script src="/js/bootstrap.min.js"></script>
    <script>
        $(function(){
           

            $("a.excluirTurma").click(function(){

                $("#linkExcluir").attr('href', $(this).attr('data-href'));
                $('#modalConfirm').modal('show');

            });                   
        });
    </script>

@endsection