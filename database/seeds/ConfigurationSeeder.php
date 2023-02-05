<?php

use Illuminate\Database\Seeder;
use App\Configuration;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configuration = new Configuration();
        $configuration->user_id = 1;
        $configuration->name = 'Alert System Notification';
        $configuration->path = 'alert_system_notification';
        $configuration->value = 1;
        $configuration->save();

        $configuration = new Configuration();
        $configuration->user_id = 1;
        $configuration->name = 'Alert Email Notification';
        $configuration->path = 'alert_email_notification';
        $configuration->value = 1;
        $configuration->save();
    }
}
