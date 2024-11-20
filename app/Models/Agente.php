<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Agente
 * 
 * @property int $id
 * @property string $numero_agentes
 * @property string $nombre_agentes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Poliza[] $polizas
 *
 * @package App\Models
 */
class Agente extends Model
{
	protected $table = 'agentes';

	protected $fillable = [
		'numero_agentes',
		'nombre_agentes'
	];

	public function polizas()
	{
		return $this->hasMany(Poliza::class);
	}
}
