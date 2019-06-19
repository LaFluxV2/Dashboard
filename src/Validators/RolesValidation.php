<?php

namespace ExtensionsValley\Dashboard\Validators;

class RolesValidation
{

    public function getRules()
    {
        return [
            'name' => 'required|max:200|unique:roles',
            'status' => 'required',
        ];
    }

    public function getUpdateRules($roles)
    {
        return [
            'name' => 'required|max:200|unique:roles,name,' . $roles->id,
            'status' => 'required',
        ];
    }

}
