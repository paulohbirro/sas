<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


use App\Contracts\Repositories\AvaliacaoFichaRepository;
use App\Contracts\Repositories\AvaliacaoRepository;
use App\Contracts\Repositories\TurmaRepository;
use App\Facades\Sebrae;
use App\Jobs\Scan;
use App\SyncTurma;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

Route::controller('auth', 'Auth\AuthController');
Route::controller('consultorExterno', 'ConsultorExternoController');

Route::get('/', function () {

    if(Sebrae::is('Expedição'))
        return redirect()->action('FichaController@index');

    return redirect()->action('AvaliacaoController@index');
});

Route::group(['middleware' => 'auth'], function() {

    Route::controller('/selecionar', 'SelecionarController');
});


Route::group(['middleware' => ['auth', 'sebrae']], function() {

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {

        Route::get('/regioes', ['as' => 'admin.regioes', 'uses' => 'RegiaoController@index']);
        Route::get('/regioes/excluir/{id}', ['as' => 'admin.regioes.excluir', 'uses' => 'RegiaoController@excluir']);

        
        Route::get('/microregioes', ['as' => 'admin.microregioes', 'uses' => 'MicroregiaoController@index']);
        Route::get('/microregioes/editar/{id}', ['as' => 'admin.microregioes.editar', 'uses' => 'MicroregiaoController@editar']); 
        Route::get('/microregioes/exlcuir/{id}', ['as' => 'admin.microregioes.excluir', 'uses' => 'MicroregiaoController@excluir']); 
        Route::post('/microregioes/atualizar/{id}', ['as' => 'admin.microregioes.atualizar', 'uses' => 'MicroregiaoController@atualizar']); 


        Route::get('/municipios', ['as' => 'admin.municipios', 'uses' => 'MunicipioController@index']);
        Route::get('/tecnicos', ['as' => 'admin.tecnicos', 'uses' => 'TecnicoController@index']);
        Route::get('/consultores', ['as' => 'admin.consultores', 'uses' => 'ConsultorController@index']);
        Route::get('/gerentesRegiao', ['as' => 'admin.gerentesRegiao', 'uses' => 'GerenteRegiaoController@index']);
        Route::get('/solucoes', ['as' => 'admin.solucoes', 'uses' => 'SolucaoController@index']);
        Route::get('/gestores', ['as' => 'admin.gestores', 'uses' => 'GestorController@index']);
        Route::get('/gerentesGestor', ['as' => 'admin.gerentesGestor', 'uses' => 'GerenteGestorController@index']);
        Route::get('/ueds', ['as' => 'admin.ueds', 'uses' => 'UedController@index']);
        Route::get('/ugps', ['as' => 'admin.ugps', 'uses' => 'UgpController@index']);

        Route::get('/', ['as' => 'admin.index', 'uses' => 'AdminController@index']);
    });

  

    Route::get('/digitalizacoes', ['as' => 'digitalizacoes.index', 'uses' => 'DigitalizacaoController@index']);
    Route::get('/digitalizacoes/ver/{avaliacaoId}/{avaliacaoFichaId?}', ['as' => 'digitalizacoes.ver', 'uses' => 'DigitalizacaoController@ver']);
    Route::get('/digitalizacoes/excluir/{avaliacaoId}', ['as' => 'digitalizacoes.excluir', 'uses' => 'DigitalizacaoController@excluir']);
    Route::post('/digitalizacoes/upload', ['as' => 'digitalizacoes.upload', 'uses' => 'DigitalizacaoController@upload']);

    Route::get('/digitalizacoes/ficha/{avaliacaoFichaId}', ['as' => 'digitalizacoes.ficha', 'uses' => 'DigitalizacaoController@ficha']);
    Route::get('/digitalizacoes/atualizarResposta/{avaliacaoFichaId}', ['as' => 'digitalizacoes.atualizarResposta', 'uses' => 'DigitalizacaoController@atualizarResposta']);
    Route::get('/digitalizacoes/comentario/{avaliacaoComentarioId}', ['as' => 'digitalizacoes.comentario', 'uses' => 'DigitalizacaoController@comentario']);
    Route::get('/digitalizacoes/deletarComentario/{avaliacaoComentarioId}', ['as' => 'digitalizacoes.deletarComentario', 'uses' => 'DigitalizacaoController@deletarComentario']);
    Route::post('/digitalizacoes/uploadComentario/{avaliacaoFichaId}', ['as' => 'digitalizacoes.uploadComentario', 'uses' => 'DigitalizacaoController@uploadComentario']);

    Route::get('/avaliacoes', ['as' => 'avaliacoes.index', 'uses' => 'AvaliacaoController@index']);
    Route::get('/avaliacoes/ver/{codigoTurma}/{aba?}', ['as' => 'avaliacoes.ver', 'uses' => 'AvaliacaoController@ver']);
    Route::get('/avaliacoes/comentario/{avaliacaoComentarioId}', ['as' => 'avaliacoes.comentario', 'uses' => 'AvaliacaoController@comentario']);
    Route::post('/avaliacoes/transcricaoComentario/{avaliacaoComentarioId}', ['as' => 'avaliacoes.transcricao', 'uses' => 'AvaliacaoController@transcricaoComentario']);

    Route::get('/fichas', ['as' => 'fichas.index', 'uses' => 'FichaController@index']);
    Route::get('/fichas/impressas', ['as' => 'fichas.impressas', 'uses' => 'FichaController@impressas']);
    Route::get('/fichas/imprimir', ['as' => 'fichas.imprimir', 'uses' => 'FichaController@imprimir']);
    Route::get('/fichas/envio', ['as' => 'fichas.envio', 'uses' => 'FichaController@envio']);
    Route::get('/fichas/envio/formulario/{codigoTurma}', ['as' => 'fichas.envio.formulario', 'uses' => 'FichaController@formulario']);
    Route::post('/fichas/envio/enviar', ['as' => 'fichas.envio.enviar', 'uses' => 'FichaController@enviar']);

    Route::get('/consultores', ['as' => 'consultores.index', 'uses' => 'ConsultorController@index']);
    Route::get('/consultores/interno', ['as' => 'consultores.interno', 'uses' => 'ConsultorController@interno']);
    Route::get('/consultores/externo', ['as' => 'consultores.externo', 'uses' => 'ConsultorController@externo']);
    Route::get('/consultores/ver/{consultorId}/{aba?}', ['as' => 'consultores.ver', 'uses' => 'ConsultorController@ver']);

    Route::get('/microregioes', ['as' => 'microregioes.index', 'uses' => 'MicroRegiaoController@index']);
    Route::get('/microregioes/ver/{microregiaoId}/{aba?}', ['as' => 'microregioes.ver', 'uses' => 'MicroRegiaoController@ver']);

    Route::get('/regioes', ['as' => 'regioes.index', 'uses' => 'RegiaoController@index']);
    Route::get('/regioes/ver/{regiaoId}/{aba?}', ['as' => 'regioes.ver', 'uses' => 'RegiaoController@ver']);

    Route::get('/solucoes', ['as' => 'solucoes.index', 'uses' => 'SolucaoController@index']);
    Route::get('/solucoes/ver/{solucaoId}/{aba?}', ['as' => 'solucoes.ver', 'uses' => 'SolucaoController@ver']);
});