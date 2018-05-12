<?php

namespace App;

use App\Playground;
use App\Reservation;
use App\User;
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


    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    /*
        one hour(slot) can reserved by user
    */
    public function user() {
        return $this->belongsTo(User::class);
    }
  
}
