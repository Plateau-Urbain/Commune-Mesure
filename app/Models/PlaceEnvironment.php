<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlaceEnvironment extends Model
{
    use HasFactory;

    protected $table = 'place_environment';

    protected $fillable = [
        'place_id',
        'visible',
        'data',
    ];

    protected $casts = [
        'data' => 'json',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function setData($data){
        $this->data = json_decode($data);
    }

    public function getData(){
      return $this->data;
    }

    public static function findByPlaceId($placeId)
    {
        $db = DB::table('place_environment')
                    ->where('place_id', $placeId)
                    ->first();

        if ($db === null) {
            return false;
        }

        $placeEnvironment = new PlaceEnvironment();
        $placeEnvironment->setData($db->data);
        return $placeEnvironment;
    }

    public function get($chemin)
    {
        return self::getValueByChemin($this->getData(), $chemin);
    }

    public static function getValueByChemin($place, $chemin){
        $keyPath = explode("->", $chemin);
        return array_reduce($keyPath, fn ($carry, $key) => $carry[$key] ?? null, $place);
    }
}
