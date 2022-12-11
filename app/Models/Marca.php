<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'marcas';

    protected $fillable = [
        'nome',
        'imagem'
    ];

    public function rules(){
        return [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|max:255|min:3',
            'imagem' => 'required|file|mimes:jpg,png,jpeg',
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'imagem.mimes' => 'A imagem deve ser do tipo jpg, png ou jpeg',
            'nome.unique' => 'O nome informado já existe',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
        ];
    }

    public function modelos(){
        return $this->hasMany('App\Models\Modelo');
    }    
}
