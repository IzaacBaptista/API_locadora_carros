<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public function __construct(Marca $marca){
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas = $this->marca->all();
        return response()->json([
            'marca' => $marcas
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $request->validate(
            $this->marca->rules(), 
            $this->marca->feedback()
        );
        
        $marca = $this->marca->create($request->all());
        
        return response()->json([
            'marca' => $marca, 
            'msg' => 'Salvo com sucesso'
        ], 201);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $marca = $this->marca::find($id);

        if(!$marca || $marca == null){
            return response()->json(['msg' => 'Marca não encontrada'], 404);
        }

        return response()->json([
            'marca: ' => $marca
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $marca = $this->marca->find($id);
        
        if(!$marca || $marca == null){
            return response()->json(['msg' => 'Marca não encontrada'], 404);
        }

        

        $marca->update($request->all());
        
        return response()->json([
            'marca' => $marca, 
            'msg' => 'Atualizado com sucesso'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $marca = $this->marca->find($id);

        if(!$marca || $marca == null){
            return response()->json(['msg' => 'Marca não encontrada'], 404);
        }
        
        $marca->delete();

        return response()->json([
            'marca' => $marca, 
            'msg' => 'Deletado com sucesso'
        ], 200);

    }
}
