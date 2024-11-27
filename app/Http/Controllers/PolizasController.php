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
        // Traer las pólizas con sus relaciones (clientes, compañías, seguros)
        $polizas = Poliza::with(['cliente', 'compania', 'seguro'])->get();

        // Retornar la vista con los datos compactados
        return view('polizas.index', compact('polizas'));
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
    $validated = $request->validate([
        'archivo_pdf.*' => 'required|file|mimes:pdf|max:10240',
        'compania_id' => 'required|exists:companias,id',
        'tipo_seguro_id' => 'required|exists:tipos_seguros,id',
    ]);

    $compania_id = $request->input('compania_id');
    $compania = Compania::find($compania_id);

    $errores = [];
    $procesados = 0;

    foreach ($request->file('archivo_pdf', []) as $archivo) {
        try {
            // Procesar cada archivo
            $this->procesarArchivo($archivo, $compania, $validated['tipo_seguro_id']);
            $procesados++;
        } catch (\Exception $e) {
            // Registrar errores por archivo
            \Log::error('Error procesando archivo: ' . $archivo->getClientOriginalName(), [
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            $errores[] = $archivo->getClientOriginalName() . ': ' . $e->getMessage();
        }
    }

    // Mensajes de retorno
    if (count($errores) > 0) {
        return redirect()->back()->with('warning', "Se procesaron $procesados archivos con algunos errores: " . implode(', ', $errores));
    }

    return redirect()->back()->with('success', "Todos los archivos ($procesados) se procesaron exitosamente.");
}

private function procesarArchivo($archivo, $compania, $tipoSeguroId)
{
    // Almacenar archivo
    $pdfPath = $archivo->store('polizas', 'public');
    $parser = new Parser();

    // Procesar PDF
    $pdfParsed = $parser->parseFile(storage_path('app/public/' . $pdfPath));
    $allText = $this->obtenerTextoDePaginas($pdfParsed, [0, 3]);

    // Extraer datos
    $datos = $this->extraerDatosPorCompania($compania->nombre, $allText);

    // Crear o asociar registros
    $cliente = Cliente::firstOrCreate(
        ['rfc' => $datos['rfc']],
        ['nombre_completo' => $datos['nombre_cliente']]
    );

    $agente = Agente::firstOrCreate(
        ['numero_agente' => $datos['numero_agente']],
        ['nombre_agente' => $datos['nombre_agente']]
    );

    Poliza::create([
        'cliente_id' => $cliente->id,
        'compania_id' => $compania->id,
        'agente_id' => $agente->id,
        'tipo_seguro_id' => $tipoSeguroId,
        'numero_poliza' => $datos['numero_poliza'] ?? 'No disponible',
        'vigencia_inicio' => $datos['vigencia_inicio'] ?? null,
        'vigencia_fin' => $datos['vigencia_fin'] ?? null,
        'forma_pago' => $datos['forma_pago'] ?? 'No especificada',
        'total_a_pagar' => isset($datos['total_pagar']) ? floatval(str_replace(',', '', $datos['total_pagar'])) : 0,
        'archivo_pdf' => $pdfPath,
        'pagos_capturados' => false,
    ]);
}

private function extraerDatosPorCompania($nombreCompania, $texto)
{
    switch ($nombreCompania) {
        case 'HDI Seguros':
            return $this->extraerDatosHdi($texto);
        case 'Banorte':
            return $this->extraerDatosBanorte($texto);
        default:
            throw new \Exception("Compañía no soportada: $nombreCompania");
    }
}

private function obtenerTextoDePaginas($pdfParsed, $selectedPages)
{
    $allText = '';
    foreach ($pdfParsed->getPages() as $index => $page) {
        if (in_array($index, $selectedPages)) {
            $allText .= "Página " . ($index + 1) . ":\n" . $page->getText() . "\n";
        }
    }
    return $allText;
}

public function PagoSubsecuente(Request $request)
{
    // Validar la solicitud
    $request->validate([
        'poliza_id' => 'required|exists:polizas,id',
        'pagos' => 'required|array',
        'pagos.*.importe' => 'required|numeric',
        'pagos.*.fecha_vencimiento' => 'required|date',
        'pagos.*.status_pago' => 'required|string|in:PENDIENTE,PAGADO,CANCELADO',
       'pagos.*.numero_recibo' => 'required|string|max:255',
    ]);

    // Encontrar la póliza usando el poliza_id
    $poliza = Poliza::find($request->poliza_id);

    // Crear los pagos
    foreach($request->pagos as $pago){
        Pago::create([
            'poliza_id' => $poliza->id,
            'importe' => $pago['importe'],
            'fecha_vencimiento' => $pago['fecha_vencimiento'],
            'status_pago' => $pago['status_pago'],
            'numero_recibo' => $pago['numero_recibo'], // Añade este campo
    
        ]);
    } 


    return redirect()->route('polizas.index')->with('success', 'Pago subsecuente registrado exitosamente.');
}

public function showPolizas(){
    $polizas = Polizas::Whith('pagos')->get();
    return view('polizas.show', compact('polizas'));
    
}
// Función para convertir la fecha
public function convertirFecha($fecha)
{
    try {
        $fechaObj = DateTime::createFromFormat('d/m/Y', $fecha);
        if ($fechaObj === false) {
            // Manejo de error si el formato no es válido
            return null;
        }
        return $fechaObj->format('Y-m-d');
    } catch (Exception $e) {
        return null;
    }
}



public function extraerDatosHdi($text) {
    $datos = [];

    // Extraer número de póliza
    if (preg_match('/Póliza:\s*([0-9\-]+)/', $text, $matches)) {
        $datos['numero_poliza'] = trim($matches[1]);
    } else {
        $datos['numero_poliza'] = 'No encontrado';
    }

    // Extraer nombre del cliente
    if (preg_match('/\n([A-Z\s]+)\n\s*RFC:/', $text, $matches)) {
        $datos['nombre_cliente'] = trim($matches[1]);
    } else {
        $datos['nombre_cliente'] = 'No encontrado';
    }

    // Extraer RFC
    if (preg_match('/RFC:\s*([A-Z0-9]+)/', $text, $matches)) {
        $datos['rfc'] = $matches[1];
    } else {
        $datos['rfc'] = 'No encontrado';
    }

    // Extraer marca, modelo y año del vehículo
    if (preg_match('/([A-Z\s]+)\s*,\s*([A-Z\s]+)\s*([0-9]{4})/', $text, $matches)) {
        $marca = trim($matches[1]);
        if (strpos($marca, 'NO APLICA') !== false) {
            $marca = str_replace('NO APLICA', '', $marca);
            $marca = trim($marca);
        }
        $datos['marca'] = $marca;
        $datos['modelo'] = trim($matches[2]);
        $datos['anio'] = trim($matches[3]);
    } else {
        $datos['marca'] = 'No encontrado';
        $datos['modelo'] = 'No encontrado';
        $datos['anio'] = 'No encontrado';
    }

    // Forma de pago
    $formas_pago = ['SEMESTRAL EFECTIVO', 'TRIMESTRAL EFECTIVO', 'ANUAL EFECTIVO', 'MENSUAL EFECTIVO'];
    foreach ($formas_pago as $forma) {
        if (preg_match('/' . preg_quote($forma, '/') . '/i', $text)) {
            $datos['forma_pago'] = $forma;
            break;
        }
    }
    if (!isset($datos['forma_pago'])) {
        $datos['forma_pago'] = 'NO APLICA';
    }

    // Extraer el total a pagar
    if (preg_match('/([0-9,]+\.\d{2})\s*Total a Pagar/', $text, $matches)) {
        $datos['total_pagar'] = trim($matches[1]);
    } else {
        $datos['total_pagar'] = 'No encontrado';
    }

    // Extraer agente (número y nombre)
    if (preg_match('/Agente:\s*([0-9]+)\s*([A-Z\s]+)\s*(?=\n\s*Descripción|$)/', $text, $matches)) {
        $datos['numero_agente'] = trim($matches[1]);
        $nombre_agente = trim(preg_replace('/\s+/', ' ', $matches[2]));
        $datos['nombre_agente'] = $nombre_agente;
    } else {
        $datos['numero_agente'] = 'No encontrado';
        $datos['nombre_agente'] = 'No encontrado';
    }

    // Extraer recibos (fechas de pago, importes, vigencia)
    $pattern = '/(\d{2}-\w{3}-\d{4})al\d+\s+([\d,]+\.\d{2})\s+(\d{2}-\w{3}-\d{4})\s+(\d{2}-\w{3}-\d{4})/';
    preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);
    
    $recibos = [];
    foreach ($matches as $match) {
        $recibos[] = [
            'fecha_pago' => $this->convertirFecha($match[1]),
            'importe' => floatval(str_replace(',', '', $match[2])),
            'vigencia_inicio' => $this->convertirFecha($match[3]),
            'vigencia_fin' => $this->convertirFecha($match[4]),
        ];
    }
    
    // Agregar los recibos a los datos extraídos
    $datos['recibos'] = $recibos;

    // Retornar todos los datos extraídos
    return $datos;
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
