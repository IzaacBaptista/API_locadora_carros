<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Marca;
use Illuminate\Http\Request;
use App\Repositories\MarcaRepository;

class MarcaController extends Controller
{

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $marcaRepository = new MarcaRepository($this->marca);

        if ($request->has('atributos_modelos')) {
            $atributos_modelos = 'modelos:marca_id,' . $request->atributos_modelos;
            $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
        } else {
            $marcaRepository->selectAtributosRegistrosRelacionados('modelos');
        }

        if ($request->has('filtro')) {
            $marcaRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $marcaRepository->selectAtributos($request->atributos);
        }

        return response()->json([
            'marcas' => $marcaRepository->getResultado()
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

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/marcas', 'public');

        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);

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
        $marca = $this->marca->with('modelos')->find($id);

        if ($marca == null) {
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

        if ($marca == null) {
            return response()->json(['msg' => 'Marca não encontrada'], 404);
        }

        if ($request->method() === 'PATCH') {
            $regrasDinamicas = array();

            foreach ($marca->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate(
                $regrasDinamicas,
                $this->marca->feedback()
            );
        } else {
            $request->validate(
                $this->marca->rules(),
                $this->marca->feedback()
            );
        }

        if ($request->file('imagem')) {
            Storage::disk('public')->delete($marca->imagem);
        }

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/marcas', 'public');

        $marca->fill($request->all());
        $marca->imagem = $imagem_urn;
        $marca->save();

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

        if ($marca == null) {
            return response()->json(['msg' => 'Marca não encontrada'], 404);
        }

        if ($marca->imagem) {
            Storage::disk('public')->delete($marca->imagem);
        }

        $marca->delete();

        return response()->json([
            'msg' => 'Deletado com sucesso'
        ], 200);
    }
}
