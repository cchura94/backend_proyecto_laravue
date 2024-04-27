<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // /api/producto?page=1&limit=20&q=laptop
        $limit = $request->limit?$request->limit:10;
        $buscar = $request->q?$request->q:'';
        
        if(isset($buscar)){
            $productos = Producto::where('nombre', 'like', "%$buscar%")
                                    ->orWhere('cod_producto', 'like', "%$buscar%")
                                    ->with('categoria')
                                    ->paginate($limit);
            
        }else{
            $productos = Producto::with('categoria')->paginate($limit);
        }


        return response()->json($productos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required"
        ]);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->cod_producto = $request->cod_producto;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->estado = $request->estado;
        $producto->save();

        return response()->json($producto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
