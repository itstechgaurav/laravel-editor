<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.tags.all')->with(['tags' => Tag::all()]);
    }


    public function tags() {
        return view('tags')->with(['tags' => Tag::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = new Tag();
        $tag->name = $request->name;
        $tag->save();
        return redirect()->route('tags');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit($tag_id)
    {
        //
        return view('admin.tags.edit')->with(['tag' => Tag::find($tag_id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tag_id)
    {
        //
        $tag = Tag::find($tag_id);
        $tag->name = $request->name;
        $tag->save();
        return redirect()->route('tags');

    }

    public function confirm($project_slug)
    {
        return view('confirm');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $tag_id)
    {
        if(strtolower($request->confirm) === "confirm" && $tag = Tag::with(['projects'])->find($tag_id)) {
            $tag->projects()->detach($tag->projects);
            $tag->delete();
            return redirect()->route('tags');
        } else {
            return response("Error !!!", 404);
        }
    }


    public function byTag($tag_name) {
        $tags = Tag::with([
            'projects' => function($query) {
                $query->where('is_private', '=', 0);
            },
            'projects.file',
            'projects.user'
        ])->where('name', '=', $tag_name)->orderby('id', 'desc')->paginate(10);

        return view('byTag')->with(['tags' => $tags]);
    }
}
