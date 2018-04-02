<?php

namespace App\Http\Controllers;

use App\Photo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index', [
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::query()->findOrFail($id);
        return view('user.show', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function showPost($id)
    {
        $posts = User::findOrFail($id)->posts;
        return view('user.show_post', compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $location = $user->location;
        if($location->phone_num)
            $user['phone_num'] = $location->phone_num;
        if($location->long_address)
            $user['long_address'] = $location->long_address;


        return view('user.edit', compact('user'));
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
        $inputUser = $this->formInputUser($request);
        $inputLocation = $this->formInputLocation($request);
        $user = User::findOrFail($id);
        Session::flash('msg', "User " . $user->name . " updated");
        $user->update($inputUser);
        $user->location->update($inputLocation);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = User::query()->findOrFail($id);
        Session::flash('msg', $user->name . " deleted");

        if ($user->photo_id > 4) {
            unlink(public_path() . $user->photo->photo_path);
            $user->photo->delete();
        }
        $user->delete();
        return redirect('/');
    }

    /**
     * @param $request
     * @return mixed
     */
    public function formInputUser($request)
    {
        if(trim($request->password) !== ""){
            $input['password'] = bcrypt($request->password);
        }
        $input['name'] = $request->name;
        $input['email'] = $request->email;
        if ($request->is_shareable !== null)
            $input['is_shareable'] = $request->is_shareable;

        if ($photoFile = $request->file('photo_id')) {
            $photoName = time() . " " . $photoFile->getClientOriginalName();
            $photoFile->move('images', $photoName);

            $photo = Photo::create(['photo_path'=> $photoName]);
            $input['photo_id'] = $photo->id;
        }
        return $input;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function formInputLocation($request)
    {
        if(trim($request->phone_num) != "")
            $input['phone_num'] = $request->phone_num;
        if(trim($request->position) != "")
            $input['position'] = json_decode($request->position, true);
        if(trim($request->short_address) != "")
            $input['short_address'] = $request->short_address;
        if(trim($request->long_address) != "")
            $input['long_address'] = $request->long_address;

        return $input;
    }
}
