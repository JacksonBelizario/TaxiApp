<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $placa
 * @property int $id_motorista
 * @property string $modelo
 * @property string $tipo
 * @property string $created_at
 * @property string $updated_at
 * @property Motoristum $motoristum
 */
class Veiculo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'veiculo';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'placa';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_motorista', 'modelo', 'tipo', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motoristum()
    {
        return $this->belongsTo('App\Motoristum', 'id_motorista', 'id_motorista');
    }
}
