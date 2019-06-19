<?php

namespace ExtensionsValley\Dashboard\Validators;

class UserroleValidation
{

    public function getRules()
    {
        return [
            'user_id' => 'required|max:200',
            'group_id' => 'required',
            'role_id' => 'required',

            'status' => 'required',
        ];
    }

    public function getUpdateRules($Userrole)
    {
        return [
            'user_id' => 'required|max:200',
            'group_id' => 'required',
            'role_id' => 'required',
            'status' => 'required',
        ];
    }

}
