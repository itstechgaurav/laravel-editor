<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App\Project;
use App\User;
use App\Like;
use App\Asset;
use function GuzzleHttp\json_encode;


class EditorController extends Controller
{
    //
    public function boot($project_name) {
        if($proj = Project::with('user')->where('slug', '=', $project_name)->first()) {
            if($proj->is_private) {
                if($user = \Auth::user()) {
                    if($user->username === $proj->username) {
                        return view('editor')->with(['project' => $proj]);
                    } else {
                        return view('error')->with(['msg' => 'Access Denied To This Project']);
                    }
                } else {
                    return view('error')->with(['msg' => 'Access Denied To This Project']);
                }
            } else {
                return view('editor')->with(['project' => $proj]);
            }
        } else {
            return view('error')->with(['msg' => 'Project Not Found']);
        }
    }

    public function load($project_name) {
        
        if($proj = Project::with(['assets', 'likes', 'liked' => function($query) {
            if($usr = \Auth::user()) {
                $query->where('user_id', '=', $usr->id)->first();
            }
        }, 'tags','user' =>  function($query) {
            $query->select('username', 'id', 'name');
        }, 'user.profile'])->where('slug', '=', $project_name)->first()) {
            
            $proj->likedBy = $proj->likes->count();
            $proj->isLiked = $proj->liked ? true : false;
            if($proj->is_private) {
                if($user = \Auth::user()) {
                    $proj->loged = true;
                    if($proj->username === $user->username) {
                        $proj->file;
                        $proj->cUser = json_decode(json_encode(
                            [
                                'name' => $user->name,
                                'username' => $user->username,
                                'image' => $user->profile->image
                            ]
                        ));
                        $proj->own = true;
                        return $proj;
                    } else {
                        return response('Error !!!', 404);
                    }
                } else {
                    return response('Error !!!', 404);
                }
            } else {
                if($user = \Auth::user()) {
                    $proj->loged = true;
                    $proj->cUser = json_decode(json_encode(
                        [
                            'name' => $user->name,
                            'username' => $user->username,
                            'image' => $user->profile->image
                        ]
                    ));
                    if($proj->username === $user->username) {
                        $proj->own = true;
                    } else {
                        $proj->own = false;
                    }
                } else {
                    $proj->loged = false;
                    $proj->own = false;
                }
                
                $proj->file;
                return $proj;
            }
        } else {
            return response('Error !!!', 404);
        }

        
        
    }

    public function save(Request $request, $project_name) {
        if($project_name === "demo-project") {
            response('Success !!!', 200);
        }
        if($proj = Project::with('file')->where('slug', '=', $project_name)->first()) {
            if($user = \Auth::user()) {
                if($user->username === $proj->username) {

                    $proj->file->meta = $request->meta;
                    $proj->file->save();
                
                    return response('Success !!!', 200);
                } else {
                    return response('Error !!!', 404);
                }
            } else {
                return response('Error !!!', 404);
            }
        } else {
            return response('Error !!!', 404);
        }
    }

    public function fork($project_name) {
        if($project_name === "demo-project") {
            response('Success !!!', 200);
        }
        if($proj = Project::with(['assets', 'file'])->where('slug', '=', $project_name)->first()) {
            if($user = \Auth::user()) {
                if($user->username !== $proj->username) {
                    $nProj = new Project();
                    $nProj->name = $proj->name;
                    $nProj->username = $user->username;
                    $nProj->slug = $proj->name;
                    $nProj->meta = $proj->meta;
                    $nProj->is_private = $proj->is_private;
                    $nProj->forked_id = $proj->id;
                    $nProj->save();
                    $nProj->slug = str_slug($nProj->name . " " . $nProj->id, "-");
                    $nProj->save();


                    foreach($proj->assets as $oAsset) {
                        $asst = new Asset();
                        $asst->user_id = \Auth::user()->id;
                        $asst->project_slug = $nProj->slug;
                        $asst->name = $oAsset->name;
                        $asst->url = $oAsset->url;
                        $asst->save();
                    }


                    $this->createProjectFile($nProj->slug);
                    return response(route('editor-boot', ['project-name' => $nProj->slug]), 200);
                } else {
                    return response('Error !!!', 404);
                }
            } else {
                return response('Error !!!', 404);
            }
        } else {
            return response('Error !!!', 404);
        }
    }

    public function createProjectFile($project_slug) {
        $file = new File();
        $file->meta = file_get_contents(dirname(__DIR__) . '/Controllers/files/full.html');
        $file->project_slug = $project_slug;
        $file->save();
    }


    public function byUser($user_name) {
        $user = User::with([
            'projects' => function($query) {
                $query->where('is_private', '=', 0);
            },
            'projects.file',
            'projects.tags']
        )->where('username', '=', $user_name)->orderby('id', 'desc')->paginate(10);
        return view('byUser')->with(['user' => $user]);
    }

    public function fullView($project_name) {
        if($project = $this->load($project_name)) {
            $meta = json_decode($project->file->meta)->result;
            return $meta;
        };
    }

    public function like($project_name) {
        $user = \Auth::user();
        if($user && $proj = Project::with(['liked' => function($query) use ($user) {
            $query->where('user_id', '=', $user->id)->first();
        }])->where('slug', '=', $project_name)->first()) {
            if($proj->liked) {
                $proj->liked->delete();
            } else {
                $like = new Like();
                $like->project_id = $proj->id;
                $like->user_id = $user->id;
                $like->save();
            }
            return response("Success !!!", 200);
        } else {
            return response("Error !!!", 404);
        }
    }
}
