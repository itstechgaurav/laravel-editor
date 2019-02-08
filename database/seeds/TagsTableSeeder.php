<?php

use Illuminate\Database\Seeder;

use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $allTags = ['HTML', 'CSS', 'JAVASCRIPT', 'VUE.JS', 'LARAVEL', 'ANIMATION', 'SVG', 'WEB', 'DEMO', 'REACT.JS', 'ANGULAR.JS'];

        foreach($allTags as $item) {
            $tag = new Tag();
            $tag->name = $item;
            $tag->save();
        };
    }
}
