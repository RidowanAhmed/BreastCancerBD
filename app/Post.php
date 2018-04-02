<?php

namespace App;

use Carbon\Carbon;
use DOMDocument;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Post extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }
    protected $fillable = ['user_id', 'photo_id', 'category_id', 'title', 'body'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function date() {
        $datetime = new Carbon($this->created_at);
        return $datetime->toDayDateTimeString();
    }

    /**
     *
     */
    public function imageSrc() {
        $doc = new DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->body);
        libxml_use_internal_errors(false);
        $images = $doc->getElementsByTagName('img');
        // Echo first <img>'s src attribute if we found any <img>s
        if ($images->length > 0) {
            return $images->item(0)->getAttribute('src');
        } else {
            return $this->user->photo->photo_path;
        }
    }
}
