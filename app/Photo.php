<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $directory = '/images/';
    protected $fillable = ['photo_id', 'photo_path'];

    public function getPhotoPathAttribute($photo) {
        return  $this->directory . $photo;
    }

}
