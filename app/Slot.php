<?php

namespace App;

use App\Playground;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $fillable = ['from', 'to', 'status'];

    /**
     * ManyToMany relation
     * between Slot and Playground
     * belongsToMany(relation Model name, pivotTable name, current model id, id of relation model)
    */
    public function playgrounds() {
        return $this->belongsToMany(Playground::class, 'playground_slot');
    }
  
}
