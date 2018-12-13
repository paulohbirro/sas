@extends('app')

@section('breadcrumb')
    Administração
@endsection

@section('content')

    @include('admin.abas')

<style type="text/css">
    @import url('//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');


</style>







@if ($flag)
     
        <div class="tab-content">
        <div id="internos" class="tab-select" style="padding: 15px;">

            <div class="col-left" >
                <table class="table table-hover" >
                    <thead >
                    <tr >
                       <th  align="center"> Deseja Realmente excluir?</th>
                    </tr>



                    </thead>
                    <tbody>

               

                    </tbody>
                </table>

                     <div style="text-align: center;padding-top: 40px;" class="form-group">
                       <button type="submit" class="btn btn-primary select">Sim</button> 
                       <button type="button" onclick="window.location='/admin/regioes'" class="btn btn-primary select">Não</button>
                    </div>

               

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

@else
  
   <div class="tab-content">
        <div id="internos" class="tab-select" style="padding: 15px;">

            <div class="col-left">
                <table class="table table-hover">
                    <thead style="background-color:red;color:white;">
                    <tr >
                       <th><i class="fa fa-times-circle"></i> Não foi possível excluir essa Região, pois ela contém dependências.</th>
                    </tr>
                    </thead>
                    <tbody>

               

                    </tbody>
                </table>


                 <div style="text-align: center;padding-top: 100px;" class="form-group">
                        <button type="button" onclick="window.location='/admin/regioes'" class="btn btn-primary select">Voltar</button>
                 </div>


               

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



@endif



   
@endsection