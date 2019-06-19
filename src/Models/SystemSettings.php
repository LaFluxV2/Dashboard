<?php

namespace ExtensionsValley\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemSettings extends Model
{
    use SoftDeletes;

    protected $table = 'system_settings';

    protected $dates = ['deleted_at'];

    protected $fillable = ['key', 'value', 'status'];

    public static function getSystemSettings()
    {
        return self::WhereNull('deleted_at')
            ->Where('status', 1)
            ->get();
    }

    ##Prevent relation breaking
    public static function getRlationstatus($cid)
    {
        return 0;
    }
}
