<?php

namespace App\Libraries\S2Cms;

use App,
    Cache;
use App\Models\Setting\Menu;
use Auth;

class BackendLib {

    /**
     *
     * @return get menu for admin
     */
    static function getMenuList() {
        $menu = Menu::menuAdmin();
        return $menu;
    }

    /**
     *
     * @param type $reset_cache
     * @return string
     */
    static function getMenuList_2($reset_cache = false) {
        $menu = Cache::get('backend_menu', '');
        if (!$menu || $reset_cache) {
            $menu = [];
            $icons = ['fa fa-th'];
            $list_ignore_of_dir = array('.', '..');

            $backend_class_method = get_class_methods('App\\Http\\Controllers\\BackendController'); /* BackendController Method */
            $dir_admin = 'Controllers/Admin'; /* Dir Admin Controller */

            /* Read all File Of Dir Admin */
            $handle = opendir(app_path($dir_admin));
            while (($directory = readdir($handle)) !== false) {
                if (!in_array($directory, $list_ignore_of_dir)) {
                    $item['name'] = ucwords($directory);
                    $item['icon'] = $icons[rand(0, count($icons) - 1)];
                    // get list item
                    $page_class_name = 'App\\Controllers\\Admin\\' . ucwords($directory) . '\\FormController';
                    $current_class_methods = get_class_methods($page_class_name);
                    if ($current_class_methods) {
                        $class_methods = array_diff($current_class_methods, $backend_class_method);
                        $list = [];
                        foreach ($class_methods as $method_name) {
                            $name_page = $directory;
                            $list_cmd_method = splitAtUpperCase($method_name);
                            $name_action = $list_cmd_method[1];
                            $name_cmd = count($list_cmd_method) > 3 ? $list_cmd_method[2] : '';
                            if ($name_cmd) {
                                $name_url = route('AminPost', [ strtolower($name_page), strtolower($name_action), strtolower($name_cmd)]);
                            } else {
                                $name_url = route('AminPost', [ strtolower($name_page), strtolower($name_action)]);
                            }

                            $list[] = [
                                'name' => ucwords($name_action) . ' ' . ucfirst($name_cmd),
                                'url' => $name_url,
                            ];
                        }
                        $item['list'] = $list;
                    }
                    $menu[] = $item;
                }
            }
            closedir($handle);
            Cache::put('backend_menu', $menu, 3600);
        }
        return $menu;
    }

}
