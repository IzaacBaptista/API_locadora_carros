<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'imagem'
    ];

    public function rules(){
        return [
            'nome' => 'required|unique:marcas|max:255|min:3',
            'descricao' => 'required',
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'O nome informado já existe',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
        ];
    }
    
}
