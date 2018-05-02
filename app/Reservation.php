<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [];

    public function reservations(){
        return $this->belongsToMany(Reservation::class);
    }
}
