<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\AvaliacaoComentarioRepository;
use App\Contracts\Repositories\MicroRegiaoRepository;
use App\Contracts\Repositories\RegiaoRepository;
use App\Contracts\Repositories\TurmaRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Eloquent\Models\MicroRegiao;
use App\Eloquent\Models\Regiao;



class MicroregiaoController extends Controller
{

    protected $microRegiaoRepository;

    /**
     * Constructor
     *
     * @param $solucaoRepository
     */
    public function __construct(MicroRegiaoRepository $microRegiaoRepository,RegiaoRepository $RegiaoRepository)
    {
        $this->microRegiaoRepository = $microRegiaoRepository;
        $this->RegiaoRepository = $RegiaoRepository;
    }

    /**
     * Index
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        //Ordenação
        $this->microRegiaoRepository->order($request->get('by', 'nome'), $request->get('order', 'ASC'));

        //Resultado
        $microregioes= $this->microRegiaoRepository
            ->whereLike($request->get('like'))
            ->paginate($request->get('limit', 15));

        return view('admin.microregiao.index')->with(compact('microregioes'));
    }

    /**
     * @param $id
     */
    public function excluir($id){
        
        $teste =  $this->microRegiaoRepository->hasDpendencias($id);
        if($teste){
            //não pode excluir por causa das depêndencias
            //session()->flash('msg', 'Não foi possível excluir essa microregião, pois ela contém depenências');
            return redirect()->back()->withErrors('Não foi possível excluir essa microregião, pois ela contém depenências');

        }else{
            //remove o registro 
          $this->microRegiaoRepository->remove($id);
          return redirect()->back();

        }
    }

      public function editar($id){

        
          $regiaoByID = $this->microRegiaoRepository->getById($id);

          //dd($regiaoByID);


          $regioes =  $this->RegiaoRepository->all(array('id','nome')); 

          //dd($regioes);
          
          // return view('admin.regiao.editar_frm', array('regioesid' =>$regiaoByID,'regioes'=>$regioes));  

         return view('admin.microregiao.editar_frm')->with(compact('regioes','id','regiaoByID'));  
       
         
    }


    public function atualizar($id){

        dd($id);


    }
}
