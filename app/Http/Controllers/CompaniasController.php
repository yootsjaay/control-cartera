<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compania;
class CompaniasController extends Controller
{
    public function index()
    {
        $companias = Compania::all();
        return view('companias.index', compact('companias'));
    }

    public function create()
    {
        return view('companias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:companias',
        ]);

        Compania::create($request->all());

        return redirect()->route('companias.index')->with('success', 'Compañía registrada exitosamente');
    }

    public function edit($id)
    {
        $compania = Compania::find($id);
        return view('companias.edit', compact('compania'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:companias,nombre,'.$id,
        ]);

        $compania = Compania::find($id);
        $compania->update($request->all());

        return redirect()->route('companias.index')->with('success', 'Compañía actualizada exitosamente');
    }

    public function destroy($id)
    {
        $compania = Compania::find($id);
        $compania->delete();

        return redirect()->route('companias.index')->with('success', 'Compañía eliminada exitosamente');
    }
    public function show(){
        
    }
}