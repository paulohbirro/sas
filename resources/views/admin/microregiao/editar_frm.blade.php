@extends('app')
@section('breadcrumb')
    Edição de Microregião
@endsection

@section('content')
   
    <div class="tab-content">
        <div id="internos" class="tab-select" style="padding: 15px;">
            <div class="col-left">          
               <form name="frm" method="post" action="{{ route('admin.microregioes.atualizar',$id) }}">  	
              

               <div class="form-group">

               		<h3>MicroRegião:</h3>
                    <p> {{ $regiaoByID->nome }}  </p>	

               	
               </div>

                   <div class="form-group">
                        
                         <h3>Regional</h3>



							    <select class="form-control input-sm dropdown" name="regiao_id">
							        <option value="">Selecione</option>
							        @foreach($regioes as $regiao)
							            <option value="">{{ $regiao->nome }}</option>
							        @endforeach
							    </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary select">Alterar</button>
                        <button type="submit" class="btn btn-primary select">Voltar</button>
                    </div>
                    </div>

                </form>

            </div>           

            <div style="clear: both; "></div>
        </div>
    </div>   
@endsection
