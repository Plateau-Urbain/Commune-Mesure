<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['section'];

    public function places()
    {
        return $this->belongsToMany(Place::class)->withTimestamps();
    }
}
