<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Repositories\ClienteRepository;

class ClienteController extends Controller
{

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clienteRepository = new ClienteRepository($this->cliente);

        if ($request->has('filtro')) {
            $clienteRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $clienteRepository->selectAtributos($request->atributos);
        }

        return response()->json([
            'cliente' => $clienteRepository->getResultado()
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
            $this->cliente->rules(),
            $this->cliente->feedback()
        );

        $cliente = $this->cliente->create([
            'nome' => $request->nome
        ]);

        return response()->json([
            'cliente' => $cliente,
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
        $cliente = $this->cliente->find($id);

        if ($cliente == null) {
            return response()->json(['msg' => 'Cliente não encontrado'], 404);
        }

        return response()->json([
            'cliente: ' => $cliente
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
        $cliente = $this->cliente->find($id);

        if ($cliente == null) {
            return response()->json(['msg' => 'Cliente não encontrado'], 404);
        }

        if ($request->method() === 'PATCH') {
            $regrasDinamicas = array();

            foreach ($cliente->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate(
                $regrasDinamicas,
                $this->cliente->feedback()
            );
        } else {
            $request->validate(
                $this->cliente->rules(),
                $this->cliente->feedback()
            );
        }

        $cliente->fill($request->all());
        $cliente->save();

        return response()->json([
            'cliente' => $cliente,
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
        $cliente = $this->cliente->find($id);

        if ($cliente == null) {
            return response()->json(['msg' => 'Cliente não encontrado'], 404);
        }

        $cliente->delete();

        return response()->json([
            'msg' => 'Deletado com sucesso'
        ], 200);
    }
}
