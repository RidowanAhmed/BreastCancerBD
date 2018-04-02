<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'photo_id', 'location_id', 'is_shareable'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($user)
        {
            //$user->name is available
            //$user->email is available
            //Do now what you want with them
            $user->meeting()->create(['user_id'=>$user->id,'users'=>[]]);
            $user->location()->create(['user_id'=>$user->id,'position'=>[]]);
        });
    }

    public function role() {
        return $this->belongsTo('App\Role');
    }

    public function meeting() {
        return $this->hasOne('App\Meeting');
    }

    public function location() {
        return $this->hasOne('App\Location');
    }

    public function photo() {
        return $this->belongsTo('App\Photo');
    }

    public function posts() {
        return $this->hasMany('App\Post');
    }

    public function emailList() {
        $userList = $this->meeting->users;
        $emails = array();
        foreach ($userList as $id) {
            $user = User::query()->find($id);
            if (isset($user))
                array_push($emails, $user->email);
        }
        return $emails;
    }
    public function userList() {
        $userList = $this->meeting->users;
        $users = array();
        foreach ($userList as $id) {
            $user = User::query()->find($id);
            if (isset($user))
                $users[] = array('name' => $user->name, 'email' => $user->email);
        }
        return $users;
    }

    public function getGravatarAttribute() {
        $hash = md5(strtolower(trim($this->attributes['email']))) . "?d=mm";
        return "https://en.gravatar.com/avatar/$hash";
    }
}
