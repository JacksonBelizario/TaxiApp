<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_cliente
 * @property string $email
 * @property string $nome
 * @property string $contato
 * @property string $senha
 * @property string $created_at
 * @property string $updated_at
 * @property Viagem[] $viagems
 */
class Cliente extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cliente';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_cliente';

    /**
     * @var array
     */
    protected $fillable = ['email', 'nome', 'contato', 'senha', 'created_at', 'updated_at'];

    /**
     * Define os atributos não exibidos após a serialização
     *
     * @var array
     */
    protected $hidden = ['senha'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viagems()
    {
        return $this->hasMany('App\Viagem', 'id_cliente', 'id_cliente');
    }
}
