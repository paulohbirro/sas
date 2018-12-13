<?php

namespace App\Sebrae\Auth;

use App\Contracts\Repositories\AdminRepository;
use App\Contracts\Repositories\ConsultorRepository;
use App\Contracts\Repositories\ExpedicaoRepository;
use App\Contracts\Repositories\GerenteGestorRepository;
use App\Contracts\Repositories\GerenteRegiaoRepository;
use App\Contracts\Repositories\GestorRepository;
use App\Contracts\Repositories\TecnicoRepository;
use App\Contracts\Repositories\UedRepository;
use App\Contracts\Repositories\UgpRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;

class SebraePerfil
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Instancia de repositorios dos perfis.
     *
     * @var array
     */
    protected $perfisRepositories;

    /**
     * Constructor
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->perfisRepositories = [
            'Admin' => $this->app->make(AdminRepository::class),
            'UED' => $this->app->make(UedRepository::class),
            'UGP' => $this->app->make(UgpRepository::class),
            'Técnico de Microregião' => $this->app->make(TecnicoRepository::class),
            'Gerente de Regional' => $this->app->make(GerenteRegiaoRepository::class),
            'Gestor de Solução' => $this->app->make(GestorRepository::class),
            'Expedição' => $this->app->make(ExpedicaoRepository::class),
            'Consultor' => $this->app->make(ConsultorRepository::class),
            'Gerente de Gestor' => $this->app->make(GerenteGestorRepository::class),
        ];
    }

    /**
     * Retorna o perfil selecionado
     *
     * @return string
     */
    public function getPerfil()
    {
        if($this->check())
        {
            return $this->app['session']->get('perfil');
        }
    }

    /**
     * Informa o perfil selecionado
     *
     * @return string
     */
    public function setPerfil($perfil, $perfilID)
    {
        $this->app['session']->set('perfil', $perfil);
        $this->app['session']->set('perfilID', $perfilID);

        return $perfil;
    }

    /**
     * Retorna o detalhes do perfil selecionado
     *
     * @return string
     */
    public function getDetalhes()
    {
        if($this->check() && $this->app['auth']->check())
        {
            $user = $this->app['auth']->user();

            if($user instanceof ConsultorExternoUser)
            {
                return $user->getConsultor();

            } else {
                $userAD = $user->getAuthIdentifier();

                $perfil = $this->app['session']->get('perfil');
                $perfilID = $this->app['session']->get('perfilID');

                return $this->perfisRepositories[$perfil]->getByUserAD($userAD)->filter(function ($item) use ($perfilID) {
                    return $item->id == $perfilID;
                })->first();
            }
        }
    }

    /**
     * Verifica se perfil foi selecionado
     *
     * @return boolean
     */
    public function check()
    {
        return !is_null($this->app['session']->get('perfil')) && !is_null($this->app['session']->get('perfilID'));
    }

    /**
     * Testa se o perfil é o mesmo passado por parametro
     *
     * @param string $perfil
     * @return boolean
     */
    public function is($perfil)
    {
        if($this->check())
        {
            return $this->getPerfil() == $perfil;
        }

        return false;
    }

    /**
     * Testa se o perfil está entre algum passado por parametro
     *
     * @param array $perfis
     * @return boolean
     */
    public function in($perfis)
    {
        if($this->check())
        {
            return in_array($this->getPerfil(), $perfis);
        }

        return false;
    }

    /**
     * Retorna perfis habilitados para o usuario logado
     *
     * @return array
     */
    public function getPerfis()
    {
        $retorno = [];

        if($this->app['auth']->check())
        {
            $user = $this->app['auth']->user();

            if($user instanceof ConsultorExternoUser)
            {
                $collection = new Collection();
                $collection->push($user->getConsultor());

                $retorno['Consultor'] = $collection;

            }else{

                $userAD = $user->getAuthIdentifier();

                foreach($this->perfisRepositories as $perfil => $repositorio)
                {
                    $rows = $repositorio->getByUserAD($userAD);

                    if($rows->count() != 0)
                        $retorno[$perfil] = $rows;
                }
            }

        }

        return $retorno;
    }

    /**
     * Remove perfil da sessao
     *
     * @return void
     */
    public function forget()
    {
        $this->app['session']->forget('perfil');
        $this->app['session']->forget('perfilID');
    }

}