<?php

namespace App;

use App\Slot;
use App\User;
use File;
use Illuminate\Database\Eloquent\Model;
use Request;

class Playground extends Model
{
    protected $table= 'playgrounds';
    protected $fillable = ['name','details','address', 'user_id','image']; 

    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * ManyToMany relation
     * between Slot and Playground
     * belongsToMany(relation Model name, pivotTable name, current model id, id of relation model)
    */
    public function slots() {
        return $this->belongsToMany(Slot::class, 'playground_slot','playground_id', 'slot_id');
    }


    public function deleteFile($file_name = "", $path = "uploads/") {
	    if (!@$file_name) return false;
	    if (file_exists($path . $file_name)) unlink($path . $file_name);
	}

    public function uploadFile($field, $object) {
        $uploadPath = 'uploads/';
        if (Request::hasFile($field) && Request::file($field)->isValid()) {
            $file = Request::file($field);
            $fileName = str_random(10) . time() . '.' . $file->getClientOriginalExtension();
            Request::file($field)->move($uploadPath, $fileName);
            $filePath = $uploadPath . $fileName;
            if ($object->$field) {
                $this->deleteFile($object->$field);
            }
            $object->$field = $fileName;
            $object->save();
        }
    }

}
