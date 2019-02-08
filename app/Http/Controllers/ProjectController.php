<?php

namespace App\Http\Controllers;

use App\Project;
use App\File;
use App\User;
use App\Tag;
use Illuminate\Http\Request;
use Session;
use function GuzzleHttp\json_encode;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('file', 'tags')->where('username', '=', \Auth::user()->username)->orderBy('id', 'desc')->paginate(10);

        return view('admin.projects.all')->with([
            'projects' => $projects
        ]);
    }

    public function all()
    {
        
        $projects = Project::with('tags', 'file')->orderBy('id', 'desc')->paginate(10);

        return view('admin.projects.all')->with([
            'projects' => $projects
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
        return view('admin.projects.create')->with(['tags' => Tag::all()]);
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
        // return $request;
        $project = new Project();
        $project->username = \Auth::user()->username;
        $project->name = $request->name;
        $project->slug = str_slug($request->name);
        $project->meta = $request->meta;
        $project->is_private = isset($request->is_private) ? ($request->is_private ? 1 : 0)  : 0; 
        $project->save();
        $project->slug = str_slug($request->name . " - " . $project->id);
        $project->save();
        $project->tags()->attach($request->tags);
        Session::flash("prime", "Project Created");
        $this->createProjectFile($project->slug);
        return redirect()->route('proj');
    }

    public function createProjectFile($project_slug) {
        $file = new File();
        $file->meta = file_get_contents(dirname(__DIR__) . '\Controllers\files\full.html');
        $file->project_slug = $project_slug;
        $file->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($project_slug)
    {
        //
        $project = project::with('tags')->where('slug', '=', $project_slug)->first();
        $project->nonSelectedTags = Tag::whereNotIn('id', $project->tags->pluck('id'))->get();
        return view('admin.projects.edit')->with(['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_slug)
    {
        //
        $project = project::with('file', 'tags')->where('slug', '=', $project_slug)->first();
        $project->name = $request->name;
        $project->slug = str_slug($request->name . " - " . $project->id);
        $project->meta = $request->meta;
        $project->is_private = isset($request->is_private) ? ($request->is_private ? 1 : 0)  : 0; 
        $project->file->project_slug = $project->slug;
        $project->file->save();
        $project->save();
        $project->tags()->detach($project->tags);
        $project->tags()->attach($request->tags);
        return redirect()->route('proj');
    }

    

    public function confirm($project_slug)
    {
        return view('confirm');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $project_slug)
    {
        //
        if(isset($request->confirm) && strtolower($request->confirm) === "confirm" && $proj = project::with('file')->where('slug', '=', $project_slug)->first()) {
            if(\Auth::user() && \Auth::user()->username === $proj->username) {
                $proj->file->delete();
                $proj->delete();
                return redirect()->route('proj');
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }
}
