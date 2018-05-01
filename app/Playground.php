<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Request;
use File;

class Playground extends Model
{
    protected $table= 'playgrounds';
    protected $fillable = ['name','details','address', 'user_id','image']; 

    public function user() {
        return $this->belongsTo(User::class);
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
