<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings; 
use Barryvdh\Dompdf\Facade as PDF;
use App\Models\Poliza;
use App\Models\Cliente;
use App\Models\Compania;
use App\Models\Seguros;
use App\Models\TipoSeguro;
use Smalot\PdfParser\Parser;


class PolizasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polizas = Poliza::with(['clientes', 'companias', 'seguros'])->get();
        return view('polizas.index' , compact('polizas'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $companias = Compania::all();
        $seguros = TipoSeguro::all();
        return view('polizas.create', compact('clientes', 'companias', 'seguros'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
            $validated = $request->validate([
                'archivo_pdf.*' => 'required|file|mimes:pdf|max:10240',
                'compania_id' => 'required|exists:companias,id',
                'tipo_seguro_id' => 'required|exists:tipos_seguros,id',
            ]);
            $compania_id= $request->input('compania_id');
            $compania=Compania::find('compania_id');

            foreach($request->file('archivo_pdf') as $archivo){
                //Alamacenar el archivo pdf cargado 
                $pdfPath= $archivo->store('polizas', 'public');
            }

        
        
        
        

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
