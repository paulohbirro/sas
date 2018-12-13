<?php

namespace App\Providers;

use adLDAP\adLDAP;
use App\Contracts\Repositories\AdminRepository;
use App\Contracts\Repositories\AvaliacaoComentarioRepository;
use App\Contracts\Repositories\AvaliacaoFichaRepository;
use App\Contracts\Repositories\AvaliacaoPerguntaRepository;
use App\Contracts\Repositories\AvaliacaoRepository;
use App\Contracts\Repositories\AvaliacaoRespostaRepository;
use App\Contracts\Repositories\ConsultorRepository;
use App\Contracts\Repositories\ExpedicaoRepository;
use App\Contracts\Repositories\GerenteGestorRepository;
use App\Contracts\Repositories\GerenteRegiaoRepository;
use App\Contracts\Repositories\GestorRepository;
use App\Contracts\Repositories\MicroRegiaoRepository;
use App\Contracts\Repositories\MunicipioRepository;
use App\Contracts\Repositories\RegiaoRepository;
use App\Contracts\Repositories\SolucaoRepository;
use App\Contracts\Repositories\TecnicoRepository;
use App\Contracts\Repositories\TurmaRepository;
use App\Contracts\Repositories\UedRepository;
use App\Contracts\Repositories\UgpRepository;
use App\Eloquent\Repositories\AdminEloquentRepository;
use App\Eloquent\Repositories\AvaliacaoComentarioEloquentRepository;
use App\Eloquent\Repositories\AvaliacaoEloquentRepository;
use App\Eloquent\Repositories\AvaliacaoFichaEloquentRepository;
use App\Eloquent\Repositories\AvaliacaoPerguntaEloquentRepository;
use App\Eloquent\Repositories\AvaliacaoRespostaEloquentRepository;
use App\Eloquent\Repositories\ConsultorEloquentRepository;
use App\Eloquent\Repositories\ExpedicaoEloquentRepository;
use App\Eloquent\Repositories\GerenteGestorEloquentRepository;
use App\Eloquent\Repositories\GerenteRegiaoEloquentRepository;
use App\Eloquent\Repositories\GestorEloquentRepository;
use App\Eloquent\Repositories\MicroRegiaoEloquentRepository;
use App\Eloquent\Repositories\MunicipioEloquentRepository;
use App\Eloquent\Repositories\RegiaoEloquentRepository;
use App\Eloquent\Repositories\SolucaoEloquentRepository;
use App\Eloquent\Repositories\TecnicoEloquentRepository;
use App\Eloquent\Repositories\TurmaEloquentRepository;
use App\Eloquent\Repositories\UedEloquentRepository;
use App\Eloquent\Repositories\UgpEloquentRepository;
use App\Sebrae\Auth\SebraePerfil;
use App\Sebrae\Auth\SebraeUserProvider;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*
         * Bind repositories
         */
        $this->app->bind(AvaliacaoRepository::class, AvaliacaoEloquentRepository::class);
        $this->app->bind(AvaliacaoFichaRepository::class, AvaliacaoFichaEloquentRepository::class);
        $this->app->bind(AvaliacaoComentarioRepository::class, AvaliacaoComentarioEloquentRepository::class);
        $this->app->bind(AvaliacaoPerguntaRepository::class, AvaliacaoPerguntaEloquentRepository::class);
        $this->app->bind(AvaliacaoRespostaRepository::class, AvaliacaoRespostaEloquentRepository::class);
        $this->app->bind(ConsultorRepository::class, ConsultorEloquentRepository::class);
        $this->app->bind(ExpedicaoRepository::class, ExpedicaoEloquentRepository::class);
        $this->app->bind(GerenteGestorRepository::class, GerenteGestorEloquentRepository::class);
        $this->app->bind(GerenteRegiaoRepository::class, GerenteRegiaoEloquentRepository::class);
        $this->app->bind(GestorRepository::class, GestorEloquentRepository::class);
        $this->app->bind(MicroRegiaoRepository::class, MicroRegiaoEloquentRepository::class);
        $this->app->bind(MunicipioRepository::class, MunicipioEloquentRepository::class);
        $this->app->bind(RegiaoRepository::class, RegiaoEloquentRepository::class);
        $this->app->bind(SolucaoRepository::class, SolucaoEloquentRepository::class);
        $this->app->bind(TecnicoRepository::class, TecnicoEloquentRepository::class);
        $this->app->bind(TurmaRepository::class, TurmaEloquentRepository::class);
        $this->app->bind(UedRepository::class, UedEloquentRepository::class);
        $this->app->bind(UgpRepository::class, UgpEloquentRepository::class);
        $this->app->bind(AdminRepository::class, AdminEloquentRepository::class);


        $this->app->singleton('sebrae', function ($app) {
            return new SebraePerfil($app);
        });

        /*
         * Driver de autenticação customizado
         */
        Auth::extend('sebrae', function ($app) {

            $adLDAP = new adLDAP([
                'account_suffix'=>  '@mg.sebrae.corp',
                'domain_controllers'=>  [
                    'mg.sebrae.corp'
                ],
                'base_dn'   =>  'OU=SEBRAE-MG,DC=mg,DC=sebrae,DC=corp',
                'admin_username' => env('LDAP_USERNAME'),
                'admin_password' => env('LDAP_PASSWORD')
            ]);

            return new Guard(new SebraeUserProvider($adLDAP), $app['session.store']);
        });
    }
}
