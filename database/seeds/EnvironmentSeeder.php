<?php

use Illuminate\Database\Seeder;
use App\Environment;

class EnvironmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $environment = new Environment();
        $environment->user_id = 1;
        $environment->name = 'Development';
        $environment->summary = 'Development Environment';
        $environment->save();

        $environment = new Environment();
        $environment->user_id = 1;
        $environment->name = 'Staging';
        $environment->summary = 'Staging Environment';
        $environment->save();

        $environment = new Environment();
        $environment->user_id = 1;
        $environment->name = 'Pre Production';
        $environment->summary = 'Pre Production Environment';
        $environment->save();

        $environment = new Environment();
        $environment->user_id = 1;
        $environment->name = 'Production';
        $environment->summary = 'Production Environment';
        $environment->save();
    }
}
