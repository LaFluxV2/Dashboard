<?php

namespace ExtensionsValley\Dashboard;

use ExtensionsValley\Dashboard\Models\Userroles;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class UserroleController extends Controller
{
    public function __construct()
    {
    }

    public function assignUsers(Request $request)
    {
        $role_id = $request->input('filter_role');
//        $group_id = $request->input('filter_group');
        $user_id = $request->input('filter_user');

        if ($role_id > 0) {
//            // Add by Group
//            if ($group_id > 0) {
//                $already_added = Userrole::Where('role_id', $role_id)
//                    ->Where('group_id', $group_id)
//                    ->count();
//                if ($already_added == 0) {
//                    Userrole::create(['role_id' => $role_id,
//                        'group_id' => $group_id, '
//                        user_id' => 0,
//                        'created_by' => \Auth::user()->id,
//                        'updated_by' => \Auth::user()->id]);
//                }
//            }
            // Add by User

            if ($user_id > 0) {
                $already_added = Userrole::Where('role_id', $role_id)
                    ->Where('user_id', $user_id)
                    ->count();
                if ($already_added == 0) {
                    Userrole::create(['role_id' => $role_id,
                        'user_id' => $user_id,
                        'group_id' => 0,
                        'created_by' => \Auth::user()->id,
                        'updated_by' => \Auth::user()->id
                    ]);
                }
            }
        } else {
            return redirect('admin/list/userrole')
                ->with(['error' => 'Oops...Something went wrong!']);
        }
        return redirect('admin/list/userrole')
            ->with(['message' => 'Users assigned successfully!']);
    }


    public function removeUsers(Request $request)
    {
        $users = $request->input('cid');
        $role_to_remove = $request->input('filter_role');

        if ($role_to_remove > 0) {
            Userrole::where('role_id', '=', $role_to_remove)->whereIn('user_id', $users)->delete();
        } else {
            Userrole::whereIn('user_id', $users) > forceDelete();
        }

        return redirect('admin/list/userrole')
            ->with(['message' => 'Users removed successfully!']);
    }

    public function removeUser(Request $request)
    {
        $user_id = $request->input('user_id');
        $role_id = $request->input('role_id');

        Userroles::where('role_id', '=', $role_id)->where('user_id', $user_id)->forceDelete();

        return redirect('admin/list/userroles')
            ->with(['message' => 'User removed successfully!']);
    }


}
