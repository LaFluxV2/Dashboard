<?php

namespace ExtensionsValley\Dashboard\Events;

\Event::listen('admin.menu.groups', function ($collection) {

    $collection->put('extensionsvalley.users', [
        'menu_text' => 'Control Panel'
        , 'menu_icon' => '<i class="fa fa-tasks"></i>'
        , 'acl_key' => 'extensionsvalley.dashboard.userpanel'
        , 'main_menu_key' => 'control.panel'
        , 'level' => '0'
        , 'sub_menu' => [

            '0' => [
                'link' => '#'
                , 'menu_text' => 'User Management'
                , 'menu_icon' => '<i class="fa fa-tasks"></i>'
                , 'acl_key' => 'extensionsvalley.dashboard.usermanagement'
                , 'sub_menu_key' => 'control.panel'
                , 'level' => '1'
                , 'sub_sub_menu' => [
                    '0' => [
                        'link' => '/admin/list/users'
                        , 'menu_text' => 'Users'
                        , 'menu_icon' => '<i class="fa fa-tasks"></i>'
                        , 'acl_key' => 'extensionsvalley.dashboard.users'
                        , 'sub_sub_menu_key' => 'control.panel'
                        , 'level' => '2'
                        , 'vendor' => 'ExtensionsValley'
                        , 'namespace' => 'ExtensionsValley\Dashboard'
                        , 'model' => 'Users'
                    ],
                    '1' => [
                        'link' => '/admin/list/roles'
                        , 'menu_text' => 'Roles'
                        , 'menu_icon' => '<i class="fa fa-tasks"></i>'
                        , 'acl_key' => 'extensionsvalley.dashboard.roles'
                        , 'sub_sub_menu_key' => 'control.panel'
                        , 'level' => '2'
                        , 'vendor' => 'ExtensionsValley'
                        , 'namespace' => 'ExtensionsValley\Dashboard'
                        , 'model' => 'Roles'
                    ],
                    '2' => [
                        'link' => '/admin/list/userroles'
                        , 'menu_text' => 'User - Role Mapping'
                        , 'menu_icon' => '<i class="fa fa-tasks"></i>'
                        , 'acl_key' => 'extensionsvalley.dashboard.userrole'
                        , 'sub_sub_menu_key' => 'control.panel'
                        , 'level' => '2'
                        , 'vendor' => 'ExtensionsValley'
                        , 'namespace' => 'ExtensionsValley\Dashboard'
                        , 'model' => 'Userroles'
                    ],
                ],
            ],



//            '1' => [
//                'link' => '#'
//                , 'menu_text' => 'Dummy'
//                , 'menu_icon' => '<i class="fa fa-tasks"></i>'
//                , 'acl_key' => 'extensionsvalley.dashboard.dummymanagement'
//                , 'sub_menu_key' => 'control.panel'
//                , 'level' => '1'
//                , 'sub_sub_menu' => [
//                    '0' => [
//                        'link' => '/admin/list/users'
//                        , 'menu_text' => 'Dummy'
//                        , 'menu_icon' => '<i class="fa fa-tasks"></i>'
//                        , 'acl_key' => 'extensionsvalley.dashboard.users'
//                        , 'sub_sub_menu_key' => 'control.panel'
//                        , 'level' => '2'
//                        , 'vendor' => 'ExtensionsValley'
//                        , 'namespace' => 'ExtensionsValley\Dashboard'
//                        , 'model' => 'Users'
//                    ],
//                ],
//            ],



        ],
    ]);
});
