<?php

namespace ExtensionsValley\Dashboard\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{

    use Authenticatable, CanResetPassword;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

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
    protected $fillable = ['name', 'email', 'user_type', 'status', 'groups', 'phone', 'password', 'is_corp'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function groups()
    {
        return $this->belongsTo('ExtensionsValley\Dashboard\Models\Group', 'groups');
    }

    public static function getUsers()
    {

        return self::WhereNull('deleted_at')
            ->Where('status', 1)
            ->Where('id', '<>', 1)
            ->pluck('name', 'id');
    }

    public static function getAllUsers()
    {
        //return self::WhereNull('deleted_at')->Where('status', 1)->pluck('student_id', 'student_first_name','id');
        return self::WhereNull('deleted_at')->Where('status', 1)->pluck('name', 'id');

    }


    ##Prevent relation breaking
    public static function getRlationstatus($cid)
    {

        return 0;
    }


    public $page_title = "Manage Users";

    public $table_name = "users";

    public $acl_key = "extensionsvalley.dashboard.users";

    public $namespace = 'ExtensionsValley\Dashboard\Tables\UsersTable';

    public $overrideview = "";

    public $model_name = 'ExtensionsValley\Dashboard\Models\User';

    public $listable = [
        'name' => 'Name'
        , 'role_name' => 'Role'
        , 'email' => 'Email'
        , 'status' => 'Status'
        , 'created_at' => 'Date'
    ];

    public $parameter_array = [
        'acl_key' => 'extensionsvalley.dashboard.users',
    ];

    public $show_toolbar = ['view' => 'Show'
        , 'add' => 'Add'
        , 'edit' => 'Edit'
        , 'publish' => 'Publish'
        , 'unpublish' => 'Unpublish'
        , 'trash' => 'Trash'
        , 'restore' => 'Restore'
        , 'forcedelete' => 'Force Delete'
    ];

    public $routes = ['add_route' => 'adduser'
        , 'edit_route' => 'edituser'
        , 'view_route' => 'viewuser'
    ];

    public $advanced_filter = [
        'layout' => "Dashboard::user.advancedfilters.usersfilter"
        , 'filters' => [
            'filter_role' => 'filter_role'
            , 'filter_status' => 'filter_status'
            , 'filter_trashed' => 'filter_trashed'
        ]
    ];


    public function getQuery()
    {

        $search = \Input::get('customsearch');
        $filter_trashed = \Input::get('filter_trashed');
        $filter_status = \Input::has('filter_status') ? \Input::get('filter_status') : '-1';

        $users = \DB::table('users as u')
            ->leftjoin('user_role as ur','ur.user_id','=','u.id')
            ->leftjoin('roles as r','r.id','=','ur.role_id')
            ->select(['u.name','r.name as role_name' ,'u.email', 'u.status', 'u.created_at', 'u.id'])
            ->Where('u.id', '<>', 1);

        if ($filter_trashed == 1) {
            $users = $users->where('u.deleted_at', '<>', NULL);
        } else {
            $users = $users->where('u.deleted_at', NULL);
        }

        if ($filter_status != -1) {
            $users = $users->Where('u.status', $filter_status);
        }


        return \DataTables::of($users)
            ->editColumn('sl', '<input type="checkbox"  name="cid[]" value="{{$id}}" class="cid_checkbox flat"/>')
            ->editColumn('status', '@if($status==1) <span class="glyphicon glyphicon-ok"></span> @else <span class="glyphicon glyphicon-remove"></span> @endif')
            ->editColumn('created_at', '{{date("M-j-Y",strtotime($created_at))}}')
            ->filter(function ($query) use ($search, $filter_status, $filter_trashed) {
                $query->where('u.name', 'like', $search . '%')
                    ->orwhere('u.email', 'like', $search . '%')
                    ->Where('u.id', '<>', 1);

                if ($filter_trashed == 1) {
                    $query->where('u.deleted_at', '<>', NULL);
                } else {
                    $query->where('u.deleted_at', NULL);
                }
                if ($filter_status != -1) {
                    $query->Where('u.status', $filter_status);
                }

            })
            ->rawColumns(['sl', 'status'])
            ->make(true);
    }

}
