<?php

namespace ExtensionsValley\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'role_type', 'status', 'created_by', 'updated_by'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public static function getRoles()
    {

        if (\Auth::user()->user_type == "SU") {
            return self::WhereNull('deleted_at')
                ->Where('status', 1)
                ->pluck('name', 'id');
        } else {
            return self::WhereNull('deleted_at')
                ->Where('status', 1)
                ->pluck('name', 'id');
        }
    }

    ##Prevent relation breaking
    public static function getRlationstatus($cid)
    {
        return 0;
    }



    public $page_title = "Manage Roles";

    public $table_name = "roles";

    public $acl_key = "extensionsvalley.dashboard.roles";

    public $namespace = 'ExtensionsValley\Dashboard\Tables\RolesTable';

    public $overrideview = "";

    public $model_name = 'ExtensionsValley\Dashboard\Models\Roles';

    public $listable = [
        'name' => 'Name'
//        , 'created_by' => 'Created By'
//        , 'updated_by' => 'Updated By'
        , 'status' => 'Status'
    ];

    public $parameter_array = [
        'acl_key' => 'extensionsvalley.dashboard.roles',
    ];

    public $show_toolbar = [
        'view' => 'Show'
        , 'add' => 'Add'
        , 'edit' => 'Edit'
        , 'publish' => 'Publish'
        , 'unpublish' => 'Unpublish'
        , 'trash' => 'Trash'
        , 'restore' => 'Restore'
        , 'forcedelete' => 'Force Delete'
    ];

    public $routes = [
        'add_route' => 'addroles'
        , 'edit_route' => 'editroles'
        , 'view_route' => 'viewroles'
    ];

    public $advanced_filter = [
        'layout' => ""
        , 'filters' => [
//            'filter_group' => 'filter_group'
//            , 'filter_status' => 'filter_status',
            'filter_trashed' => 'filter_trashed'
        ]
    ];


    public function getQuery()
    {
        $search = \Input::get('customsearch');
        $filter_trashed = \Input::get('filter_trashed');
        $roles = \DB::table('roles');

        if ($filter_trashed > 0) {
            $roles = $roles->Where('deleted_at', '<>', Null);
        } else {
            $roles = $roles->WhereNull('deleted_at');
        }
        return \DataTables::of($roles)
            ->editColumn('sl', '<input type="checkbox"  name="cid[]" value="{{$id}}" class="cid_checkbox flat"/>')
            ->editColumn('created_by', '<?php echo \DB::table("users")->Where("id",$created_by)->value("name"); ?>')
            ->editColumn('updated_by', '<?php echo \DB::table("users")->Where("id",$created_by)->value("name"); ?>')
            ->editColumn('status', '@if($status==1) <span class="glyphicon glyphicon-ok"></span> @else <span class="glyphicon glyphicon-remove"></span> @endif')
            ->rawColumns(['sl', 'status'])
            ->make(true);
    }



}
