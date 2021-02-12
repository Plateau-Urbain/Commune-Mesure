<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['place_id', 'section', 'visible'];

    public function place()
    {
        return $this->belongsToMany(Place::class)->withTimestamps();
    }
}
