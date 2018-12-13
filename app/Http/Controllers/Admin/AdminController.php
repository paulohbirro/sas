<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\AvaliacaoComentarioRepository;
use App\Contracts\Repositories\TurmaRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    /**
     * Index
     *
     */
    public function index()
    {

    	
        return redirect()->route('admin.regioes');
    }
}
