<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{
    use HasFactory;
    
    protected $table = 'locacoes';

    protected $fillable = [
        'cliente_id',
        'carro_id',
        'data_inicio_periodo', //format example: 2021-01-01
        'data_final_previsto_periodo', //format example: 2021-01-01
        'data_final_realizado_periodo', //format example: 2021-01-01
        'valor_diaria',
        'km_inicial',
        'km_final',
    ];

    public function rules() {
        return [
            'cliente_id' => 'required|integer',
            'carro_id' => 'required|integer',
            'data_inicio_periodo' => 'required|date',
            'data_final_previsto_periodo' => 'required|date',
            'data_final_realizado_periodo' => 'required|date',
            'valor_diaria' => 'required|numeric',
            'km_inicial' => 'required|integer',
            'km_final' => 'required|integer',
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'integer' => 'O campo :attribute deve ser um número inteiro',
            'numeric' => 'O campo :attribute deve ser um número',
            'date' => 'O campo :attribute deve ser uma data',
        ];
    }
}
