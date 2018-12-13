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
                        <th><a href="{{Order::url('nome')}}">Região</a><i class="caret"></i></th>
                        <th>Microregiões</th>
                        <th>Municípios</th>
                        <th>Gerentes</th>
                        <th>Turmas</th>
                        <th colspan="2"></th>
                      
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($regioes as $regiao)


                    
                    
                        <tr>
                            <td><a href="#">{{ Utils::highlighting($regiao->nome, Input::get('like')) }}</a></td>
                            <td>{{ $regiao->microregioes->count() }}</td>
                            <td>{{ $regiao->municipios->count() }}</td>
                            <td>{{ $regiao->gerentes->count() }}</td>
                            <td>{{ $regiao->turmas->count() }}</td>
                            <td colspan="2"> <a class="excluirTurma" data-href="{{ route('admin.regioes.excluir',$regiao->id) }}" href="#">Excluir</a></td> 

                          
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Nenhum registro encontrado</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

                <?php echo $regioes->appends(Input::query())->render() ?>

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
                    <h4 class="modal-title"><strong>Excluir Região</strong></h4>
                </div>
                <div class="modal-body">
                    <h3>{Deseja realmente excluir essa Região?}</h3><br />
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