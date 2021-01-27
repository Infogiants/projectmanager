<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->user_id = 1;
        $category->name = 'Lumen';
        $category->slug = 'lumen';
        $category->image = '';
        $category->save();

        $category = new Category();
        $category->user_id = 1;
        $category->name = 'Drupal';
        $category->slug = 'drupal';
        $category->image = '';
        $category->save();
        
        $category = new Category();
        $category->user_id = 1;
        $category->name = 'Joomla';
        $category->slug = 'joomla';
        $category->image = '';
        $category->save();
        
        $category = new Category();
        $category->user_id = 1;
        $category->name = 'Wordpress';
        $category->slug = 'wordpress';
        $category->image = '';
        $category->save();

        $category = new Category();
        $category->user_id = 1;
        $category->name = 'Laravel';
        $category->slug = 'laravel';
        $category->image = '';
        $category->save();
    }
}
