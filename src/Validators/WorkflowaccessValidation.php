<?php

namespace ExtensionsValley\Dashboard\Validators;

class WorkflowaccessValidation
{

    public function getRules()
    {
        return [
            'workflow_master_id' => 'required|max:255',
            'access_mode' => 'required',
            'user_id' => 'required',
            'role_id' => 'required',
            'status' => 'required',
        ];
    }

    public function getUpdateRules($user)
    {
        return [
            'workflow_master_id' => 'required|max:255',
            'access_mode' => 'required',
            'user_id' => 'required',
            'role_id' => 'required',
            'status' => 'required',
        ];
    }

}
