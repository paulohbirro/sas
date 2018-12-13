<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\ConsultorRepository;
use App\Http\Requests\ConsultorExternoCriarSenha;
use App\Http\Requests\ConsultorExternoEsqueci;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use JansenFelipe\Utils\Utils;


class ConsultorExternoController extends Controller
{
    protected $consultorRepository;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(ConsultorRepository $consultorRepository)
    {
        $this->consultorRepository = $consultorRepository;
    }

    /**
     * Mostra formulario de login do consultor externo
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('auth.externo.login');
    }

    /**
     * Mostra formulario para criar uma senha senha
     *
     * @return \Illuminate\Http\Response
     */
    public function getCriarSenha()
    {
        return view('auth.externo.criarSenha');
    }

    /**
     * Cria uma senha
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCriarSenha(ConsultorExternoCriarSenha $request)
    {
        if($request->get('senha') != $request->get('confirmacaoSenha'))
            return redirect()->back()->withErrors('As senhas não coincidem');

        if(!Utils::isCpf($request->get('cpf')))
            return redirect()->back()->withErrors('CPF não é valido');

        $consultor = $this->consultorRepository->where(['cpf' => $request->get('cpf')])->all()->first();

        if(is_null($consultor))
            return redirect()->back()->withErrors('Consultor não encontrado');

        if(!is_null($consultor->senha))
            return redirect()->back()->withErrors('O consultor informado já possui senha cadastrada.');
        else{

            $consultor->update([
                'senha' => md5($request->get('senha')),
                'email' => $request->get('email')
            ]);

            return redirect()->action('ConsultorExternoController@getLogin')->withErrors('Senha cadastrada com sucesso. Efetue o login!');
        }
    }

    /**
     * Mostra formulario para recuperação de senha
     *
     * @return \Illuminate\Http\Response
     */
    public function getEsqueci()
    {
        return view('auth.externo.esqueci');
    }

    /**
     * Envia senha por email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEsqueci(ConsultorExternoEsqueci $request)
    {
        if(!Utils::isCpf($request->get('cpf')))
            return redirect()->back()->withErrors('CPF não é valido');

        $consultor = $this->consultorRepository->where(['cpf' => $request->get('cpf')])->all()->first();

        if(is_null($consultor))
            return redirect()->back()->withErrors('Consultor não encontrado');

        if($consultor->email != $request->get('email'))
            return redirect()->back()->withErrors('O email informado não consta no cadastro');
        else{

            $chave = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 16);

            $consultor->update([
                'chave_recuperacao' => $chave
            ]);

            Mail::send('auth.externo.reminder', compact('consultor', 'chave'), function ($m) use ($consultor) {
                $m->from('sistemas@sebraemg.com.br', 'SAS - SEBRAE MG');

                $m->to($consultor->email, $consultor->nome)->subject('[Sebrae MG] Recuperação de senha do sistema SAS');
            });

            return redirect()->action('ConsultorExternoController@getLogin')->withErrors('Solicitação enviada. Acesse seu email e clique no link para cadastrar uma nova senha.');
        }
    }

    /**
     * Mostra formulario para recuperação de senha
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecuperar(Request $request)
    {
        $consultor = $this->consultorRepository->where(['chave_recuperacao' => $request->get('chave')])->all()->first();

        if(is_null($consultor))
            return redirect()->action('ConsultorExternoController@getLogin')->withErrors("Chave não encontrada");
        else
            return view('auth.externo.recuperar', ['chave'=> $request->get('chave')]);
    }

    /**
     * Altera senha utilizando chave de recuperação
     *
     * @return \Illuminate\Http\Response
     */
    public function postRecuperar(Request $request)
    {
        if($request->get('senha') != $request->get('confirmacaoSenha'))
            return redirect()->back()->withErrors('As senhas não coincidem');

        $consultor = $this->consultorRepository->where(['chave_recuperacao' => $request->get('chave')])->all()->first();

        if(is_null($consultor))
            return redirect()->action('ConsultorExternoController@getLogin')->withErrors("Chave não encontrada");
        else{

            $consultor->update([
                'senha' => md5($request->get('senha')),
                'chave_recuperacao' => null
            ]);

            return redirect()->action('ConsultorExternoController@getLogin')->withErrors("Senha alterada com sucesso!");
        }
    }
}
