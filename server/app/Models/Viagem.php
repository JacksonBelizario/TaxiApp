<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_viagem
 * @property int $id_cliente
 * @property int $id_motorista
 * @property string $status
 * @property string $duracao
 * @property float $distancia
 * @property string $forma_pagamento
 * @property float $valor
 * @property string $origem
 * @property string $destino
 * @property string $data_hora
 * @property string $created_at
 * @property string $updated_at
 * @property Cliente $cliente
 * @property Motoristum $motoristum
 */
class Viagem extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'viagem';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_viagem';

    /**
     * @var array
     */
    protected $fillable = ['id_cliente', 'id_motorista', 'status', 'duracao', 'distancia', 'forma_pagamento', 'valor', 'origem', 'destino', 'data_hora', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'id_cliente', 'id_cliente');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motoristum()
    {
        return $this->belongsTo('App\Motoristum', 'id_motorista', 'id_motorista');
    }
}
