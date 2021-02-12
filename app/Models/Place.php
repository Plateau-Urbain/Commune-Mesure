<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Section;

class Place extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public function sections()
    {
        return $this->belongsToMany(Section::class)->withTimestamps();
    }
}
