<?php

namespace App;

use App\Playground;
use App\Slot;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['user_id','slot_id','playground_id','date','playground_cost','payment_type'];

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function playground() {
        return $this->belongsTo(Playground::class, 'playground_id');
    }

    public function slots() {
    	return $this->belongsTo(Slot::class, 'slot_id');
    }
}
