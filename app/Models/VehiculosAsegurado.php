<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VehiculosAsegurado
 * 
 * @property int $id
 * @property int $poliza_id
 * @property string $marca
 * @property string $modelo
 * @property Carbon $anio
 * @property string|null $numero_motor
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Poliza $poliza
 *
 * @package App\Models
 */
class VehiculosAsegurado extends Model
{
	protected $table = 'vehiculos_asegurados';

	protected $casts = [
		'poliza_id' => 'int',
		'anio' => 'datetime'
	];

	protected $fillable = [
		'poliza_id',
		'marca',
		'modelo',
		'anio',
		'numero_motor'
	];

	public function poliza()
	{
		return $this->belongsTo(Poliza::class);
	}
}
