<?php

use ExtensionsValley\Dashboard\Models\SystemSettings;
use Illuminate\Database\Seeder;

class SystemSettingsSeeder extends Seeder
{

    public function run()
    {
        SystemSettings::create([
            'key' => 'maintenance_mode',
            'value' => '0',  // 0 - Not. 1 - Maintenance Mode
            'status' => '1'
        ]);

        SystemSettings::create([
            'key' => 'show_visit_page_link',
            'value' => '0',  // 0 - Not Show. 1 - Show
            'status' => '1'
        ]);

        SystemSettings::create([
            'key' => 'minimized_sidebar',
            'value' => '0', // 0 - Not minimized. 1 - Minimized
            'status' => '1'
        ]);

        SystemSettings::create([
            'key' => 'fixed_sidebar',
            'value' => 'menu_fixed', // Class Name
            'status' => '1'
        ]);

        SystemSettings::create([
            'key' => 'fixed_footer',
            'value' => 'footer_fixed', // Class Name
            'status' => '1'
        ]);
    }
}
