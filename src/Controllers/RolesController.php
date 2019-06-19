<?php

namespace ExtensionsValley\Dashboard;

use ExtensionsValley\Dashboard\Validators\RolesValidation;
use ExtensionsValley\Dashboard\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RolesController extends Controller
{

    public function addRoles()
    {
        $title = 'Add New Roles';
        return \View::make('Dashboard::roles.rolesform', compact('title'));
    }

    protected function saveRoles()
    {
        $validation = \Validator::make(\Input::all(), with(new RolesValidation)->getRules());

        if ($validation->fails()) {
            return redirect()->route('extensionsvalley.admin.addroles', ['accesstoken' => \Input::get('accesstoken')])
                ->withErrors($validation)
                ->withInput();
        }

        $name = \Input::get('name');
        $status = \Input::get('status');

        Roles::create([
            'name' => $name,
            'status' => $status,
            'created_by' => \Auth::user()->id,
            'updated_by' => \Auth::user()->id,
            'created_at' => date('Y-m-d h:i:s')
        ]);

        return redirect('admin/list/roles')->with(['message' => 'Details added successfully!']);
    }

    public function editRoles($id)
    {
        $title = 'Edit Roles';
        $roles = Roles::findOrFail($id);
        return \View::make('Dashboard::roles.rolesform', compact('title', 'roles'));
    }

    public function viewRoles($id)
    {
        $title = 'View Roless';
        $roles = Roles::findOrFail($id);
        $viewmode = 'view';
        return \View::make('Dashboard::roles.rolesform', compact('title', 'roles', 'viewmode'));
    }

    public function updateRoles(Request $request)
    {

        $roles_id = $request->input('roles_id');
        $name = $request->input('name');
        $status = $request->input('status');

        $roles = Roles::findOrFail($roles_id);
        $validation = \Validator::make($request->only('roles_id', 'name', 'status')
            , with(new RolesValidation)->getUpdateRules($roles));
        if ($validation->fails()) {
            return redirect()->route('extensionsvalley.admin.editroles', ['id' => $roles->id, 'accesstoken' => \Input::get('accesstoken')])->withErrors($validation)->withInput();
        }

        Roles::Where('id', $roles->id)->update(['name' => $name, 'status' => $status]);

        return redirect('admin/list/roles')->with(['message' => 'Details updated successfully!']);

    }

}
