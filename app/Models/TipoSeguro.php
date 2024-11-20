<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoSeguro
 * 
 * @property int $id
 * @property string $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Poliza[] $polizas
 *
 * @package App\Models
 */
class TipoSeguro extends Model
{
	protected $table = 'tipo_seguros';

	protected $fillable = [
		'nombre'
	];

	public function polizas()
	{
		return $this->hasMany(Poliza::class);
	}
}
