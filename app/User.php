<?php

namespace App;

use App\Playground;
use App\Reservation;
use App\Role;
use App\Slot;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Zizaco\Entrust\Traits\EntrustUserTrait;

// implements JWTSubject
class User extends Authenticatable 
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'phone', 'role_id', 'password_confirmation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function playgrounds(){
        return $this->hasMany(Playground::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function slots() {
        return $this->hasMany(Slot::class);
    }

    public function link(){
        return 'hello';
    }
    public function hasRole($role)
    {
      return null !== $this->role()->where('name', $role)->first();
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
