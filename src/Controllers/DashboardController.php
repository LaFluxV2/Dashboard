<?php

namespace ExtensionsValley\Dashboard;

use ExtensionsValley\Dashboard\Models\traits\DashboardTraits;
use ExtensionsValley\Dashboard\Models\WebSettings;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ExtensionsValley\Dashboard\Models\Userroles;


class DashboardController extends Controller
{

    use DashboardTraits;

    public function __construct()
    {

        $this->getNavigationBar();
        $this->getWidgets();
    }

    public function getDashboard()
    {

        $title = 'Dashboard';
        return \View::make('Dashboard::dashboard.index', compact('title'));
    }

//    public function getBasicViewold($vendor, $namespace, $table_name)
//    {
//
//        $namespace = $vendor . "\\" . str_replace(" ", "", ucwords(str_replace('-', " ", $namespace)));
//        $table_name = $namespace . '\Tables\\' . ucfirst(str_replace("_", "", $table_name)) . "Table";
//
//        $table = with(new $table_name);
//        $table->vendor = $vendor;
//
//        $table->namespace = $table_name;
//        if (isset($table->overrideview)) {
//
//            if (trim($table->overrideview) != "") {
//
//                $partials_path = $table->overrideview;
//
//            } else {
//
//                $partials_path = "Dashboard::dashboard.partials.table";
//            }
//
//
//            return \View::make($partials_path, [
//                'title' => $table->page_title
//                ,
//                'table' => $table,
//            ]);
//        }
//
//    }

    public function getBasicView($model_name)
    {

        $model_name = ucfirst($model_name);
//        print_r($model_name);

        $acl_data = \DB::table('acl_permission')->Where('model',$model_name)->first();
//        print_r($acl_data);
//        exit;

        $table_name = $acl_data->namespace. '\Models\\' .$acl_data->model;
//        echo $table_name; exit;

        $table = with(new $table_name);
        $table->vendor = $acl_data->vendor;
        $table->namespace = $table_name;
//        print_r($table->overrideview); exit;


        if (isset($table->overrideview)) {

//            echo "here"; exit;

            if (trim($table->overrideview) != "") {
                $partials_path = $table->overrideview;
            } else {
                $partials_path = "Dashboard::dashboard.partials.table";
            }
            return \View::make($partials_path, [
                'title' => $table->page_title,
                'table' => $table,
            ]);
        }





    }


    public function getAjaxView(Request $request)
    {
        $table_name = base64_decode($request->input('namespace'));
        $table = with(new $table_name);
        return $table->getQuery();
    }

    public function getCommonAction()
    {
        $cid = \Input::get('cid');
        $action_type = \Input::get('action_type');
        $table_name = \Input::get('table_name');
        $acl_key = base64_decode(\Input::get('acl_key'));
        $model_name = base64_decode(\Input::get('model_name'));
//        echo $model_name; exit;
        $return_url = base64_decode(\Input::get('return_url'));
        $message = "Please select an actions to perform";

        if (\Schema::hasTable($table_name) && sizeof($cid) > 0) {

            $acl_status = 1;
            if ($action_type == "enable" || $action_type == "disable") {
                $acl_status = $this->checkACLPermission($acl_key, 'edit');
            } else {
                $acl_status = $this->checkACLPermission($acl_key, 'trash');
            }

            if ($acl_status == 0) {
                return redirect($return_url)->with(['error' => 'Access Permission Denied..!']);
            }

            if ($action_type == "enable") {

                $model_name::whereIn('id', $cid)->update(array('status' => 1));
                $message = "Records Published successfully";

            } elseif ($action_type == "disable") {

                $relation_status = $model_name::getRlationstatus($cid);

                if ($relation_status == 0) {

                    $model_name::whereIn('id', $cid)->update(array('status' => 0));
                    $message = "Records Unpublished successfully";

                } else {
                    return redirect($return_url)->with(['error' => 'Sorry unable to update ! Some related records found.']);
                }

            } elseif ($action_type == "remove") {
                $relation_status = $model_name::getRlationstatus($cid);
                if ($relation_status == 0) {
                    $model_name::whereIn('id', $cid)->delete();
                    $message = "Records Trashed successfully";

                } else {
                    return redirect($return_url)->with(['error' => 'Sorry unable to trash ! Some related records found, may be in Trashed list.']);
                }
            } elseif ($action_type == "restore") {

                $model_name::whereIn('id', $cid)->restore();
                $message = "Records Restored successfully";


            } elseif ($action_type == "forcedelete") {

                $model_name::whereIn('id', $cid)->forceDelete();

                if (method_exists($model_name, 'forceDeletetrigger')) {
                    $model_name::forceDeletetrigger($cid);
                }

                $message = "Records Deleted successfully";


            } elseif ($action_type == "view") {

                $redirect_path = $model_name::$view_route;

                return redirect()->route($redirect_path, ['id' => $cid[0], 'return_url' => base64_encode($return_url)]);
            }

            if (method_exists($model_name, 'getCommonActionHandler')) {
                //Check Action function in modles.
                call_user_func_array([$model_name, 'getCommonActionHandler'], [$action_type, $cid]);
            }
            return redirect($return_url)->with(['message' => $message]);

        } else {

            return redirect($return_url)->with(['error' => 'Unauthorized action detected ..!']);
        }

    }

    public function checkACLPermission($acl_key, $action)
    {

        $user_roles = \DB::table('user_role')->Where('user_id', \Auth::user()->id)->pluck('role_id');

        $user_id = \Auth::user()->id;

        $user_role_type =  Userroles::getUserRoleType($user_id);

        if ($user_role_type != 'SU' && $user_role_type != 'A') {
            return \DB::table('acl_permission')
                ->WhereIn('role_id', $user_roles)
                ->where('acl_key', $acl_key)
                ->Where($action, 1)
                ->count();
        } else {
            return \DB::table('acl_permission')
                ->WhereIn('role_id', $user_roles)
                ->where('acl_key', $acl_key)
                ->Where($action, 1)
                ->count();
        }

    }

    public function getSettings()
    {


        $title = 'General Settings';

        $user_roles = \DB::table('user_role')->Where('user_id', \Auth::user()->id)->pluck('role_id');

        $user_id = \Auth::user()->id;

        $user_role_type =  Userroles::getUserRoleType($user_id);

        if ($user_role_type != 'SU' && $user_role_type != 'A') {
            return redirect('admin/dashboard')->with(['error' => 'Unauthorized action detected..!']);
        }

        return \View::make('Dashboard::dashboard.settings', compact('title'));
    }

    public function updateSettings(Request $request)
    {

        $settings = \Input::get('settings');

        foreach ($settings as $key => $value) {

            if (\DB::table('gen_settings')->Where('settings_key', $key)->count()) {
                \DB::table('gen_settings')->Where('settings_key', $key)
                    ->update(['settings_value' => $value]);
            } else {
                WebSettings::Create(['settings_key' => $key, 'settings_value' => $value]);

            }
            ## Reset or update cache entries
            \Cache::forget($key);
            \Cache::forever($key, $value);

        }

        ## Validate Logo
        $validation = \Validator::make($request->all()
            , [
                'site_log' => 'mimes:jpeg,jpg,png,gif|max:10000'
                ,
                'fav_icon' => 'mimes:ico|max:1024'
            ]);
        if ($validation->fails()) {
            return redirect('admin/gensettings')->withErrors($validation)->withInput();
        }


        $media = "";
        if ($request->file('site_logo')) {
            $destinationPath = "packages/extensionsvalley/dashboard/images/";
            $final_location = $destinationPath;
            $file_name = "logo";
            $request->file('site_logo')->move($final_location,
                $file_name . '.' . $request->file('site_logo')->getClientOriginalExtension());
            $media = $final_location . $file_name . '.' . $request->file('site_logo')->getClientOriginalExtension() . "?i=" . rand(1,
                    10);
        } else {
            $media = \WebConf::get('site_logo');
        }
        $favicon = "";
        if ($request->file('fav_icon')) {
            $destinationPath = "packages/extensionsvalley/dashboard/images/";
            $final_location = $destinationPath;
            $file_name = "favicon";
            $request->file('fav_icon')->move($final_location,
                $file_name . '.' . $request->file('fav_icon')->getClientOriginalExtension());
            $favicon = $final_location . $file_name . '.' . $request->file('fav_icon')->getClientOriginalExtension() . "?i=" . rand(1,
                    10);
        } else {
            $favicon = \WebConf::get('fav_icon');
        }

        if ($media != "") {
            if (\WebConf::checkKey('site_logo')) {
                \DB::table('gen_settings')->Where('settings_key', 'site_logo')
                    ->update(['settings_value' => $media]);
            } else {
                WebSettings::Create([
                    'settings_key' => 'site_logo'
                    ,
                    'settings_value' => $media
                ]);
            }
            ## Reset or update cache entries
            \Cache::forget('site_logo');
            \Cache::forever('site_logo', $media);
        }
        if ($favicon != "") {

            if (\WebConf::checkKey('fav_icon')) {
                \DB::table('gen_settings')->Where('settings_key', 'fav_icon')
                    ->update(['settings_value' => $favicon]);
            } else {
                WebSettings::Create([
                    'settings_key' => 'fav_icon'
                    ,
                    'settings_value' => $favicon
                ]);
            }
            ## Reset or update cache entries
            \Cache::forget('fav_icon');
            \Cache::forever('fav_icon', $favicon);
        }

        return redirect('admin/gensettings')->with(['message' => 'Settings update successfully!']);
    }

}
