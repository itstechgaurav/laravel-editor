<?php

namespace App\Http\Controllers;

use App\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_slug)
    {
        //
        $user = User::with(['assets' =>  function($q) use ($project_slug) {
            $q->where('project_slug', '=', $project_slug);
        }])->where('id', '=', \Auth::user()->id)->first();
        // return $user;
        return view('admin.asset.all')->with([
            'project_slug' => $project_slug,
            'user' => $user
        ]);
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
    public function store(Request $request, $project_slug)
    {
        // Stroring Assets

        if ($request->file('assets')) {
            foreach ($request->file('assets') as $asset) {
                $ext = $asset->getClientOriginalExtension();
                $nm = 'assets' . '-' . date_timestamp_get(date_create()) . '-' . \Auth::user()->id . '-' . $asset->getClientOriginalName();
                if (in_array($ext, ['jpeg', 'jpg', 'png', 'gif', 'svg'])) {
                    $asst = new Asset();
                    $asst->user_id = \Auth::user()->id;
                    $asst->project_slug = $project_slug;
                    $asst->name = $asset->getClientOriginalName();
                    $asst->url = $nm;
                    $asst->save();
                    $asst->url = $asst->id . '-' . $asst->url;
                    $asst->save();
                    $asset->move(public_path("uploads"), $asst->url);
                } else {
                    Session::flash("danger", "Only Accep jpg, jpeg, svg, gif, png");
                    return redirect()->back();
                }
            }
            Session::flash("ter", "Uploaded");
            return redirect()->back();
        }

        return $request;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */

    public function confirm($project_slug, $url)
    {
        $asst = Asset::where('url', '=', $url)->where('project_slug', '=', $project_slug)->where('user_id', '=', \Auth::user()->id)->first();
        if ($asst && $asst->user_id === \Auth::user()->id) {
            return view('confirm');
        } else {
            Session::flash("danger", "Sorry Something Went Wrong");
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $project_slug, $url)
    {
        //
        // return $request;

        if (!$request || strtolower($request->confirm) !== "confirm") {
            Session::flash("danger", "Please Type Confirm");
            return redirect()->back();
        } else {
            $asst = Asset::where('url', '=', $url)->where('project_slug', '=', $project_slug)->where('user_id', '=', \Auth::user()->id)->first();
            if ($asst && $asst->user_id === \Auth::user()->id) {
                $asst->delete();
                Session::flash("prime", "Deleted");
                return redirect()->route('assets', ['project_slug' => $project_slug]);
            } else {
                Session::flash("danger", "Sorry Something Went Wrong");
                return redirect()->back();
            }
        }
    }
}
