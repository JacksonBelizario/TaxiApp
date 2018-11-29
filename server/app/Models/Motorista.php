<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_motorista
 * @property string $email
 * @property string $nome
 * @property string $contato
 * @property string $senha
 * @property string $endereco
 * @property int $documento
 * @property string $created_at
 * @property string $updated_at
 * @property Veiculo[] $veiculos
 * @property Viagem[] $viagems
 */
class Motorista extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'motorista';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_motorista';

    /**
     * @var array
     */
    protected $fillable = ['email', 'nome', 'contato', 'senha', 'endereco', 'documento', 'created_at', 'updated_at'];

    /**
     * Define os atributos não exibidos após a serialização
     *
     * @var array
     */
    protected $hidden = ['senha'];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function veiculos()
    {
        return $this->hasMany('App\Veiculo', 'id_motorista', 'id_motorista');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viagems()
    {
        return $this->hasMany('App\Viagem', 'id_motorista', 'id_motorista');
    }
}
