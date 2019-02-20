<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes(['verify' => true]);

Route::get('/home', 'ProjectController@index')->middleware('verified')->name('home');


// For Admin

Route::group(['prefix' => 'admin', 'middleware' =>[ 'verified', 'admin']], function () {
    Route::get("/", "AdminController@main")->name('admin-dash');
    Route::get("/dash", "AdminController@main");
    Route::get("/users", "AdminController@main")->name('users');
    Route::get("/roles", "RoleController@index")->name('roles');
    Route::get("/roles/create", "RoleController@create")->name('roles-create');
    Route::post("/roles/create", "RoleController@store");
    Route::get("/tags", "TagController@index")->name('tags');
    Route::get("/tags/create", "TagController@create")->name('tags-create');
    Route::post("/tags/create", "TagController@store");
    Route::get("/tags/{tag_id}/edit", "TagController@edit")->name('tags-edit');
    Route::post("/tags/{tag_id}/edit", "TagController@update");
    Route::get("/tags/del/{tag_id}", "TagController@confirm")->name('tags-confirm');
    Route::post("/tags/del/{tag_id}", "TagController@destroy");
});

// For All Users

Route::group(['prefix' => 'main', 'middleware' => 'verified'], function () {


    // Dash

    Route::get("/", "ProjectController@index")->name('main-dash');
    Route::get("/dash", "ProjectController@index");

    // Project

    Route::get('/proj', "ProjectController@index")->name('proj');
    Route::get('/proj/all', "ProjectController@all")->name('proj-all');
    Route::get("/proj/create", "ProjectController@create")->name('proj-create');
    Route::post("/proj/create", "ProjectController@store");
    Route::get("/proj/create/quick", "ProjectController@quick")->name('proj-create-quick');
    Route::get("/proj/img/{project_slug}", "ProjectController@img")->name('proj-img');
    Route::get("/proj/edit/{project_slug}", "ProjectController@edit")->name('proj-edit');
    Route::post("/proj/edit/{project_slug}", "ProjectController@update");
    Route::get("/proj/del/{project_slug}", "ProjectController@confirm")->name('proj-del-confirm');
    Route::post("/proj/del/{project_slug}", "ProjectController@destroy");


    // Profile

    Route::get("/profile", "ProfileController@index")->name('profile');
    Route::get("/profile/edit", "ProfileController@edit")->name('profile-edit');
    Route::post("/profile/edit", "ProfileController@update");

    // Assets

    Route::get("/proj/{project_slug}/assets", "AssetController@index")->name('assets');
    Route::post("/proj/{project_slug}/assets/store", "AssetController@store")->name('assets-store');
    Route::get("/proj/{project_slug}/asset/del/{url}", "AssetController@confirm")->name('asset-del-confirm');
    Route::post("/proj/{project_slug}/asset/del/{url}", "AssetController@destroy")->name('asset-del');
});


// Editor Routes

Route::group(['prefix' => 'editor'], function() {
    Route::get("{project_name}", "EditorController@boot")->name('editor-boot');
    Route::get("{project_name}/get", "EditorController@load")->name('editor-load');
    Route::post("{project_name}", "EditorController@save")->name('editor-save');
    Route::post("{project_name}/fork", "EditorController@fork")->name('editor-fork');
    Route::get("{project_name}/like", "EditorController@like")->name('editor-like');
});

Route::get("/project/{project_name}/full", "EditorController@fullView")->name('full-view');
Route::get("/by/user/{user_name}", "EditorController@byUser")->name('by-user');
Route::get("/by/tag/{tag_name}", "TagController@byTag")->name('by-tag');
Route::get("/tags", "TagController@tags");


// Route::get('lab', "lab@lab");