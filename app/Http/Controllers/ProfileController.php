<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('profile.profile');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
        return view('profile.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $this->validate($request,[
            'name' => 'required|string|max:255',
            'meta' => 'required|string',
        ]);

        $user = \Auth::user();
        $user->name = $request->name;
        $user->profile->meta = $request->meta;

        if(isset($request->profileImage)) {
            $this->validate($request,[
                'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif'
            ]);

            $image = $request->file('profileImage');
            $newName = microtime(true) . rand() . $image->getClientOriginalName() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path("uploads"), $newName);
            // return $newName;
            $user->profile->image = $newName;
            $user->profile->save();
        }

        $user->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
