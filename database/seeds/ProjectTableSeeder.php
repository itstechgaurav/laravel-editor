<?php

use Illuminate\Database\Seeder;
use App\Project;
use \App\Http\Controllers\ProjectController;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $proj = new Project();
        $proj->name = "Demo Project";
        $proj->slug = str_slug($proj->name);
        $proj->meta = "A Demo Project For Only Demo Purpose But You Can Also Fork This Project";
        $proj->username = "test";
        $proj->save();

        $files = new ProjectController();
        $files->createProjectFile($proj->slug);
    }
}
