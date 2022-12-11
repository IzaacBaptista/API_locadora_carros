<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    protected $table = 'modelos';

    protected $fillable = [
        'marca_id',
        'nome',
        'imagem',
        'numero_portas',
        'lugares',
        'air_bag',
        'abs'
    ];

    public function rules(){
        return [
            'marca_id' => 'required',
            'nome' => 'required|unique:modelos,nome,'.$this->id.'|max:255|min:3',
            'imagem' => 'required|file|mimes:jpg,png,jpeg',
            'numero_portas' => 'required|integer|digits_between:1,5',
            'lugares' => 'required|integer|digits_between:1,5',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean'
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'integer' => 'O campo :attribute deve ser um número inteiro',
            'digits_between' => 'O campo :attribute deve ter entre :min e :max dígitos',
            'boolean' => 'O campo :attribute deve ser verdadeiro ou falso',
            'imagem.mimes' => 'A imagem deve ser do tipo jpg, png ou jpeg',
            'nome.unique' => 'O nome informado já existe',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
        ];
    }

    public function marca(){
        return $this->belongsTo('App\Models\Marca');
    }
}
