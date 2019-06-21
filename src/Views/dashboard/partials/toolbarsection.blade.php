<div class="x_panel">
    <div class="pull-right">
        <?php
        // Check individual user permission here and override with it
        // Code for ...
        // Code for ...
        // Code for ...

        $user_roles = \DB::table('user_role')->Where('user_id', \Auth::user()->id)->pluck('role_id');
        $acl_key = $table->parameter_array['acl_key'];
        $acl_permission = \DB::table('acl_permission')
            ->WhereIn('role_id', $user_roles)
            ->where('acl_key', $acl_key)
            ->first();
        ?>

        @if(!empty($table->show_toolbar['view']) && $acl_permission->view == 1)
            <button onclick="findRoute('view');" class="btn btn-sm btn-dark material-ripple" type="button"
                    data-ripple-color="#CB8962">
                <i class="fa fa-eye"></i> {{$table->show_toolbar['view']}}
            </button>
        @endif
        @if(!empty($table->show_toolbar['add']) && $acl_permission->adding == 1 )
            <button onclick="findRoute('add');" class="btn btn-sm btn-success material-ripple" type="button"
                    data-ripple-color="#CB8962">
                <i class="fa fa-plus"></i> {{$table->show_toolbar['add']}}
            </button>
        @endif
        @if(\Input::has('filter_trashed'))
            @if(!empty($table->show_toolbar['restore']) && $acl_permission->trash == 1)
                <button onclick="findAction('restore');" class="btn btn-sm btn-warning material-ripple" type="button"
                        data-ripple-color="#CB8962">
                    <i class="fa fa-backward"></i> {{$table->show_toolbar['restore']}}
                </button>
            @endif
            @if(!empty($table->show_toolbar['forcedelete']) && $acl_permission->trash == 1)
                <button onclick="findAction('forcedelete');" class="btn btn-sm btn-danger material-ripple" type="button"
                        data-ripple-color="#CB8962">
                    <i class="fa fa-trash"></i> {{$table->show_toolbar['forcedelete']}}
                </button>
            @endif
        @else
            @if(!empty($table->show_toolbar['edit']) && $acl_permission->edit == 1)
                <button onclick="findRoute('edit');" class="btn btn-sm btn-primary material-ripple" type="button"
                        data-ripple-color="#CB8962">
                    <i class="fa fa-edit"></i> {{$table->show_toolbar['edit']}}
                </button>
            @endif
            @if(!empty($table->show_toolbar['publish']) && $acl_permission->edit == 1)
                <button onclick="findAction('enable');" class="btn btn-sm btn-info material-ripple" type="button"
                        data-ripple-color="#CB8962">
                    <i class="fa fa-check"></i> {{$table->show_toolbar['publish']}}
                </button>
            @endif
            @if(!empty($table->show_toolbar['unpublish']) && $acl_permission->edit == 1)
                <button onclick="findAction('disable');" class="btn btn-sm btn-warning material-ripple" type="button"
                        data-ripple-color="#CB8962">
                    <i class="fa fa-times"></i> {{$table->show_toolbar['unpublish']}}
                </button>
            @endif
            @if(!empty($table->show_toolbar['trash']) && $acl_permission->trash == 1)
                <button onclick="findAction('remove');" class="btn btn-sm btn-danger material-ripple" type="button"
                        data-ripple-color="#CB8962">
                    <i class="fa fa-trash"></i> {{$table->show_toolbar['trash']}}
                </button>
            @endif
        @endif
        @if(!empty($table->custom_toolbar))
            @foreach($table->custom_toolbar as $custombuttons)
                <a @if(!empty($custombuttons['link'])) href="{{url($custombuttons['link'])}}" @else href="javascript:;"
                   @endif class="{{$custombuttons['class']}}"
                   @if(!empty($custombuttons['jsaction'])) onclick="{{$custombuttons['jsaction']}}" @endif
                   @if(!empty($custombuttons['customaction'])) data-action="{{$custombuttons['customaction']}}" @endif>
                    {{$custombuttons['text']}}
                </a>
            @endforeach
        @endif
    </div>
</div>
