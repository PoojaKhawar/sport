<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;

class AdminPermission extends AppModel
{
    protected $table = 'admin_permissions';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function handlePermissions($id, $rolePermissions)
    {
        //Delete all first
        AdminPermission::where('admin_id', $id)->delete();
        // Then Save
        foreach($rolePermissions as $r)
        {
            $relation = new AdminPermission();
            $relation->permission_id = $r->permission_id;
            $relation->admin_id = $id;
            $relation->mode = $r->mode;
            $relation->created_by = 1;
            $relation->save();
        }
    }
}