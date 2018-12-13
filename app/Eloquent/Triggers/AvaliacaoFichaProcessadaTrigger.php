<?php


namespace App\Eloquent\Triggers;


use App\Eloquent\Models\Avaliacao;
use App\Eloquent\Models\AvaliacaoFicha;
use Illuminate\Support\Facades\Log;

class AvaliacaoFichaProcessadaTrigger
{

    /**
     * Updated
     *
     * @param AvaliacaoFicha $ficha
     */
    public function updated(AvaliacaoFicha $ficha)
    {
        if($ficha->getOriginal('status') == 'PROCESSANDO' && $ficha->status == 'PROCESSADO')
        {
            Log::info("Ficha [$ficha->id] processada! Atualizando avaliação [$ficha->avaliacao_id]");

            $this->atualizarNPS($ficha->avaliacao);
            $this->atualizarNotaConsultor($ficha->avaliacao);
            $this->atualizarNotaMetodologia($ficha->avaliacao);
            $this->atualizarNotaAtendimento($ficha->avaliacao);

            $ficha->avaliacao->update([
                'digitalizado' => AvaliacaoFicha::where(['avaliacao_id' => $ficha->avaliacao_id, 'status' => 'PROCESSADO'])->count()
            ]);
        }
    }

    /**
     * Atualiza resultado NPS da avaliacao
     *
     * @param Avaliacao $avaliacao
     */
    private function atualizarNPS(Avaliacao $avaliacao)
    {
        $nps = $avaliacao->respostas->filter(function($item){ return !is_null($item->resposta) && $item->avaliacao_pergunta_id == 10; });

        /*
         * Detratores, Passivos e Promotores
         */
        $detratores = $nps->filter(function($item){
            return $item->resposta >= 0 && $item->resposta <= 6;
        });

        $passivos = $nps->filter(function($item){
            return $item->resposta >= 7 && $item->resposta <= 8;
        });

        $promotores = $nps->filter(function($item){
            return $item->resposta >= 9 && $item->resposta <= 10;
        });


        if($nps->count()>0)
        {
            $promotoresPercent = 100 * $promotores->count() / $nps->count();
            $detratoresPercent = 100 * $detratores->count() / $nps->count();
        }else{

            $promotoresPercent = 0;
            $detratoresPercent = 0;
        }

        $avaliacao->update([
            'nps' => ($promotoresPercent - $detratoresPercent),
            'detratores' => $detratores->count(),
            'passivos' => $passivos->count(),
            'promotores' => $promotores->count()
        ]);
    }

    /**
     * Atualiza resultado Nota Consultor da avaliacao
     *
     * @param Avaliacao $avaliacao
     */
    private function atualizarNotaConsultor(Avaliacao $avaliacao)
    {
        $consultor = $avaliacao->respostas->filter(function($item){ return !is_null($item->resposta) && $item->avaliacao_pergunta_id == 1; })->avg('resposta');
        $dominio   = $avaliacao->respostas->filter(function($item){ return !is_null($item->resposta) && $item->avaliacao_pergunta_id == 2; })->avg('resposta');
        $clareza   = $avaliacao->respostas->filter(function($item){ return !is_null($item->resposta) && $item->avaliacao_pergunta_id == 3; })->avg('resposta');
        $recursos  = $avaliacao->respostas->filter(function($item){ return !is_null($item->resposta) && $item->avaliacao_pergunta_id == 4; })->avg('resposta');
        $exemplos  = $avaliacao->respostas->filter(function($item){ return !is_null($item->resposta) && $item->avaliacao_pergunta_id == 5; })->avg('resposta');


        $avaliacao->update([
            'nota_consultor' => $consultor,
            'nota_consultor_dominio' => $dominio,
            'nota_consultor_clareza' => $clareza,
            'nota_consultor_recursos' => $recursos,
            'nota_consultor_exemplos' => $exemplos
        ]);
    }

    /**
     * Atualiza resultado Nota Metodologia da avaliacao
     *
     * @param Avaliacao $avaliacao
     */
    private function atualizarNotaMetodologia(Avaliacao $avaliacao)
    {
        $metodologia = $avaliacao->respostas->filter(function($item){ return ($item->avaliacao_pergunta_id == 6 || $item->avaliacao_pergunta_id == 7) && !is_null($item->resposta); })->avg('resposta');

        $material = $avaliacao->respostas->filter(function($item){ return !is_null($item->resposta) && $item->avaliacao_pergunta_id == 6; })->avg('resposta');
        $duracao  = $avaliacao->respostas->filter(function($item){ return !is_null($item->resposta) && $item->avaliacao_pergunta_id == 7; })->avg('resposta');

        $avaliacao->update([
            'nota_metodologia' => $metodologia,
            'nota_metodologia_duracao' => $duracao,
            'nota_metodologia_material' => $material
        ]);
    }

    /**
     * Atualiza resultado Nota Atendimento da avaliacao
     *
     * @param Avaliacao $avaliacao
     */
    private function atualizarNotaAtendimento(Avaliacao $avaliacao)
    {
        $atendimento = $avaliacao->respostas->filter(function($item){ return ($item->avaliacao_pergunta_id == 8 || $item->avaliacao_pergunta_id == 9) && !is_null($item->resposta); })->avg('resposta');

        $ambiente = $avaliacao->respostas->filter(function($item){ return !is_null($item->resposta) && $item->avaliacao_pergunta_id == 8; })->avg('resposta');
        $prestado = $avaliacao->respostas->filter(function($item){ return !is_null($item->resposta) && $item->avaliacao_pergunta_id == 9; })->avg('resposta');

        $avaliacao->update([
            'nota_atendimento' => $atendimento,
            'nota_atendimento_prestado' => $prestado,
            'nota_atendimento_ambiente' => $ambiente
        ]);
    }

}