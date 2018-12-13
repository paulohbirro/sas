<?php

namespace App\Eloquent\Triggers;

use App\Eloquent\Models\Avaliacao;
use Illuminate\Support\Facades\Log;

class AvaliacaoProcessadaTrigger
{
    /**
     * Updated
     *
     * @param Avaliacao $avaliacao
     */
    public function updated(Avaliacao $avaliacao)
    {
        if(in_array($avaliacao->status, ['PROCESSANDO', 'AUDITORIA']) && $avaliacao->quantidade == $avaliacao->digitalizado)
        {
            Log::info("Avaliação [$avaliacao->id] processada!");

            if($avaliacao->fichasComErro() == 0)
            {
                $avaliacao->turma->update(['status' =>  'PUBLICADO']);

                Avaliacao::where('id', $avaliacao->id)->update([
                    'status' => 'PROCESSADO'
                ]);

            }else{

                Avaliacao::where('id', $avaliacao->id)->update([
                    'status' => 'AUDITORIA'
                ]);
            }

        }
    }

    /**
     * Deleted
     *
     * @param Avaliacao $avaliacao
     */
    public function deleted(Avaliacao $avaliacao)
    {
        $avaliacao->turma->update([
            'status' => 'ENVIADO'
        ]);
    }

}