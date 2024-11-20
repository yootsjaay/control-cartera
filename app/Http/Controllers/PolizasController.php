<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings; 
use Barryvdh\Dompdf\Facade as PDF;
use App\Models\Poliza;
use App\Models\Cliente;
use App\Models\Compania;


class PolizasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polizas = Poliza::with(['clientes', 'companias'])->get();
        return view('polizas.index' , compact('polizas'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:2048',

        ]);
        //subir archivos pdf 
        

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
