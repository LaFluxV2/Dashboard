<?php

namespace ExtensionsValley\Dashboard\Validators;

class WorkflowmasterValidation
{

    public function getRules()
    {
        return [
            'menu_id' => 'required|max:200',
            'name' => 'required',
            'status' => 'required',
        ];
    }

    public function getUpdateRules($Workflowmaster)
    {
        return [
            'menu_id' => 'required|max:200',
            'name' => 'required',
            'status' => 'required',
        ];
    }

}
