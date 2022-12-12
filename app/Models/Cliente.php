<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = ['nome'];

    public function rules() {
        return [
            'nome' => 'required'
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatório',
        ];
    }
}