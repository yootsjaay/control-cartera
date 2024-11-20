<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Poliza
 * 
 * @property int $id
 * @property string $numero_poliza
 * @property Carbon $vigencia_inicio
 * @property Carbon $vigencia_fin
 * @property string $forma_pago
 * @property float $total_a_pagar
 * @property string|null $archivo_pdf
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $cliente_id
 * @property int $compania_id
 * @property int $agente_id
 * @property int $tipo_seguro_id
 * 
 * @property Agente $agente
 * @property Cliente $cliente
 * @property Compania $compania
 * @property TipoSeguro $tipo_seguro
 * @property Collection|VehiculosAsegurado[] $vehiculos_asegurados
 *
 * @package App\Models
 */
class Poliza extends Model
{
	protected $table = 'polizas';

	protected $casts = [
		'vigencia_inicio' => 'datetime',
		'vigencia_fin' => 'datetime',
		'total_a_pagar' => 'float',
		'cliente_id' => 'int',
		'compania_id' => 'int',
		'agente_id' => 'int',
		'tipo_seguro_id' => 'int'
	];

	protected $fillable = [
		'numero_poliza',
		'vigencia_inicio',
		'vigencia_fin',
		'forma_pago',
		'total_a_pagar',
		'archivo_pdf',
		'cliente_id',
		'compania_id',
		'agente_id',
		'tipo_seguro_id'
	];

	public function agente()
	{
		return $this->belongsTo(Agente::class);
	}

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function compania()
	{
		return $this->belongsTo(Compania::class);
	}

	public function tipo_seguro()
	{
		return $this->belongsTo(TipoSeguro::class);
	}

	public function vehiculos_asegurados()
	{
		return $this->hasMany(VehiculosAsegurado::class);
	}
}
