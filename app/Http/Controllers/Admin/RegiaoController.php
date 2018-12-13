<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\AvaliacaoComentarioRepository;
use App\Contracts\Repositories\RegiaoRepository;
use App\Contracts\Repositories\TurmaRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class RegiaoController extends Controller
{

    protected $regiaoRepository;

    /**
     * Constructor
     *
     * @param $solucaoRepository
     */
    public function __construct(RegiaoRepository $regiaoRepository)
    {
        $this->regiaoRepository = $regiaoRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        //Ordenação
        $this->regiaoRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        //Resultado
        $regioes = $this->regiaoRepository
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));


      

        return view('admin.regiao.index')->with(compact('regioes'));
    }


  


    public function excluir($id){


         $teste =  $this->regiaoRepository->hasDpendencias($id);
        if($teste){
            //não pode excluir por causa das depêndencias
            //session()->flash('msg', 'Não foi possível excluir essa microregião, pois ela contém depenências');
            return redirect()->back()->withErrors('Não foi possível excluir essa Região, pois ela contém depenências');

        }else{
            //remove o registro 
          $this->regiaoRepository->remove($id);
          return redirect()->back();

        }
        
        }



}
