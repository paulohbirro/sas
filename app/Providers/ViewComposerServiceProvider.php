<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['filtros.regiao'], 'App\Http\ViewComposers\Filtros\RegiaoFiltroComposer');
        view()->composer(['filtros.microRegiao'], 'App\Http\ViewComposers\Filtros\MicroRegiaoFiltroComposer');
        view()->composer(['filtros.municipio'], 'App\Http\ViewComposers\Filtros\MunicipioFiltroComposer');
        view()->composer(['filtros.solucao'], 'App\Http\ViewComposers\Filtros\SolucaoFiltroComposer');
        view()->composer(['filtros.consultor'], 'App\Http\ViewComposers\Filtros\ConsultorFiltroComposer');
        view()->composer(['filtros.gestor'], 'App\Http\ViewComposers\Filtros\GestorFiltroComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
