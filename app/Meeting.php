<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'user_id', 'dateTime', 'users'
    ];

    protected $casts = [
        'users' => 'array',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * @return array
     */
    public function queuedUsers() {
        $users = array();
        $meeting_users = $this->users;
        if (isset($meeting_users)) {
            foreach ($meeting_users as $id) {
                $user = User::query()->find($id);
                if(isset($user))
                    array_push($users, $user);
            }
        }

        return $users;
    }
    public function usersLocation() {
        $locations = array();
        foreach ($this->queuedUsers() as $user) {
            $loc = $user->location;
            if(isset($loc) && $loc->position != null)
                array_push($locations, ['name'=>$user->name,'position'=>$loc->position,'address'=>$loc->short_address]);
        }
        return $locations;
    }
}
