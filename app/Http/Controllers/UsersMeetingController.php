<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\Array_;

class UsersMeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Auth::user()->meeting->queuedUsers();
        return view('user.meeting', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $meeting = Auth::user()->meeting;
        return $meeting->usersLocation();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function store(Request $request)
    {
        $id = $request->id;
        if(isset($id)) {
            $id = (int)$request->id;
            $meeting = Auth::user()->meeting;
            $users = $meeting->users;
            if (in_array( $id ,$users )) {
                return "User already in the meeting";
            }
            else {
                array_push($users, $id);
                $meeting->users = $users;
                $meeting->save();
                return "User added in the meeting";

            }
        } else {
            $name = $request->name;
            $id = User::whereName($name)->first()->id;
            $meeting = Auth::user()->meeting;
            $users = $meeting->users;
            if (($key = array_search($id, $users)) !== false) {
                unset($users[$key]);
                $meeting->users = $users;
                $meeting->save();
                return "User removed from the meeting";
            }
            else {
                return "Can't remove user";
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return string
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setMeeting(Request $request)
    {
        $user = User::query()->findOrFail($request->id);
        $data = [
            'date' =>  substr($request->dateTime,0,10),
            'time' =>  substr($request->dateTime,11),
            'place' =>  $request->place,
            'user' =>  $user->name,
            'link' =>  'https://www.google.com/maps/place/?q=place_id:' . $request->place_id
        ];
//        return response()->json($data);
        $users = $user->userList();
        foreach ($users as $user) {
            Mail::send('emails.meeting_email', $data, function ($message) use ($user) {
                $message->to($user['email'], $user['name'])->subject('Invitation to Breast Cancer Meeting');
            });
        }
        return response()->json($request->dateTime);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
