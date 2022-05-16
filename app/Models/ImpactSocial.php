<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImpactSocial extends Model
{
    use SoftDeletes;

    const TYPE_DONNEES_DATAPANORAMA = 'datapanorama';
    const TYPE_DONNEES_IMPACT = 'impact';

    protected $table = 'places';
    protected $primaryKey = 'place';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        //'data' => 'array'
    ];

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }

    public function setDataAttribute($value)
    {
        $this->attribute['data'] = json_encode($value);
    }
}
