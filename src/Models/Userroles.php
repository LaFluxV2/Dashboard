<?php

namespace ExtensionsValley\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Userroles extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_role';

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
    protected $fillable = ['user_id', 'group_id', 'role_id', 'name', 'status',
        'created_by', 'updated_by'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public static function getRoles()
    {
        return self::WhereNull('deleted_at')->Where('status', 1)->pluck('name', 'id');
    }

    public static function getRole($id){
        return self::Where('id',$id)->WhereNull('deleted_at')->first();
    }

    public static function getUserRoleType($user_id){
        $user_role_type = \DB::select("    SELECT CASE
                                                   WHEN r.id = 1
                                                     THEN 'SU'
                                                   WHEN r.id = 2
                                                     THEN 'A'
                                                   ELSE 'Unknown'
                                                   END user_role_type
                                            FROM roles as r
                                              LEFT JOIN user_role AS ur ON ur.role_id = r.id
                                              LEFT JOIN users AS u ON u.id = ur.user_id
                                            WHERE u.id = {$user_id} AND u.deleted_at IS NULL GROUP  BY 1
        ");

        return $user_role_type[0]->user_role_type;
    }

    ##Prevent relation breaking
    public static function getRlationstatus($cid)
    {
        return 0;
    }



    public $page_title = "User - Role Mapping";

    public $table_name = "user_role";

    public $acl_key = "extensionsvalley.dashboard.Userrole";

    public $namespace = 'ExtensionsValley\Dashboard\Tables\UserroleTable';

    public $overrideview = "";

    public $model_name = 'ExtensionsValley\Dashboard\Models\Userrole';

    public $listable = [
        'user_id' => 'User',
//        'group_id' => 'Group',
        'role_id' => 'Role',
        'status' => 'Status',
//        , 'created_by' => 'Created By'
//        , 'updated_by' => 'Updated By',
        'remove' => 'Remove'
    ];

    public $parameter_array = [
        'acl_key' => 'extensionsvalley.dashboard.userrole',
    ];

    public $show_toolbar = [
//        'view' => 'Show'
//        , 'add' => 'Add'
//        , 'edit' => 'Edit'
//        'publish' => 'Publish'
//        , 'unpublish' => 'Unpublish'
//        , 'trash' => 'Trash'
//        , 'restore' => 'Restore'
//        , 'forcedelete' => 'Force Delete'
    ];

    public $routes = [
        'add_route' => 'addUserrole'
        , 'edit_route' => 'editUserrole'
        , 'view_route' => 'viewUserrole'
    ];

    public $advanced_filter = [
        'layout' => "Dashboard::userrole.advancedfilters.AssignUserrole",
        'filters' => [
            'filter_user' => 'filter_user',
            'filter_role' => 'filter_role'
            , 'filter_trashed' => 'filter_trashed'
        ]
    ];


    public function getQuery()
    {
        $search = \Input::get('customsearch');
        $filter_user = \Input::get('filter_user');
        $filter_role = \Input::get('filter_role');
        $filter_trashed = \Input::get('filter_trashed');

        if ($filter_user > 0 && $filter_role > 0) {
            $users = \DB::table('user_role')
                ->leftjoin('users', 'users.id', '=', 'user_role.user_id')
                ->leftjoin('roles', 'roles.id', '=', 'user_role.role_id')
                ->select([
                    'users.id as id',
                    'users.id as user_id',
                    'roles.id as role_id',
                    'user_role.status as status',
                    'user_role.created_by as created_by',
                    'user_role.updated_by as updated_by',
                    'users.id as remove'
                ])
                ->Where('users.id', $filter_user)
                ->Where('user_role.role_id', $filter_role);
        } else if ($filter_role > 0 && $filter_user == 0) {
            $users = \DB::table('user_role')
                ->leftjoin('users', 'users.id', '=', 'user_role.user_id')
                ->leftjoin('roles', 'roles.id', '=', 'user_role.role_id')
                ->select([
                    'users.id as id',
                    'users.id as user_id',
                    'roles.id as role_id',
                    'user_role.status as status',
                    'user_role.created_by as created_by',
                    'user_role.updated_by as updated_by',
                    'users.id as remove'
                ])
                ->Where('user_role.role_id', $filter_role);
        } else if ($filter_user > 0 && $filter_role == 0) {
            $users = \DB::table('user_role')
                ->leftjoin('users', 'users.id', '=', 'user_role.user_id')
                ->leftjoin('roles', 'roles.id', '=', 'user_role.role_id')
                ->select([
                    'users.id as id',
                    'users.id as user_id',
                    'roles.id as role_id',
                    'user_role.status as status',
                    'user_role.created_by as created_by',
                    'user_role.updated_by as updated_by',
                    'users.id as remove'
                ])
                ->Where('users.id', $filter_user);
        } else {
            $users = \DB::table('user_role')
                ->leftjoin('users', 'users.id', '=', 'user_role.user_id')
                ->leftjoin('roles', 'roles.id', '=', 'user_role.role_id')
                ->select([
                    'users.id as id',
                    'users.id as user_id',
                    'roles.id as role_id',
                    'user_role.status as status',
                    'user_role.created_by as created_by',
                    'user_role.updated_by as updated_by',
                    'users.id as remove'
                ])
                ->Where('users.id', '<>', 1);
        }


        if ($filter_trashed == 1) {
            $users = $users->Where('user_role.deleted_at', '<>', NULL);
        } else {
            $users = $users->WhereNull('user_role.deleted_at');

        }


        return \DataTables::of($users)
            ->editColumn('sl', '<input type="checkbox"  name="cid[]" value="{{$id}}" class="cid_checkbox flat"/>')
            ->editColumn('user_id', '<?php echo \DB::table("users")->Where("id",$user_id)->value("name"); ?>')
            ->editColumn('role_id', '<?php echo \DB::table("roles")->Where("id",$role_id)->value("name"); ?>')
            ->editColumn('created_by', '<?php echo \DB::table("users")->Where("id",$created_by)->value("name"); ?>')
            ->editColumn('updated_by', '<?php echo \DB::table("users")->Where("id",$updated_by)->value("name"); ?>')
            ->editColumn('remove', '
                                    {!!Form::open(array("route" => "extensionsvalley.admin.removeuser", "method" => "get")) !!}
                                    <input type="hidden" id="user_id" name="user_id" value="{{$user_id}}" />
                                    <input type="hidden" id="role_id" name="role_id" value="{{$role_id}}" />
                                    {!! Form::submit("Remove", ["class" => "btn btn-danger"]) !!}
                                    {!! Form::close() !!}
                                     ')
            ->editColumn('status', '@if($status==1) <span class="glyphicon glyphicon-ok"></span> 
                                    @else <span class="glyphicon glyphicon-remove"></span> 
                                    @endif')
            ->rawColumns(['sl', 'status', 'remove'])
            ->make(true);
    }
}
