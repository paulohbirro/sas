<h3>Olá {{ $consultor->nome }}!</h3>
<p>Você está recebendo este email porque solicitou a recuperação de senha do SAS.</p>
<p>Para cadastrar uma nova senha clique no link abaixo:</p>
<p><a href="{{ action('ConsultorExternoController@getRecuperar') }}?chave={{ $chave }}">{{ action('ConsultorExternoController@getRecuperar') }}?chave={{ $chave }}</a></p><br />
<p>Favor desconsiderar essa mensagem caso você não tenha feito esta solicitação.</p>