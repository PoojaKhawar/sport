<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin\Admin;
use App\Models\Admin\AdminPermission;
use App\Models\Admin\RolePermissions;

class Permission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $where[] = 'admins.role IS NOT NULL';
        $admin =  Admin::getAll([],$where);

        foreach ($admin as $k => $v) 
        {
            $checkRolePermissions['roles_permissions.role_id'] = $v->role;
            $rolePermissions = RolePermissions::getAll([],$checkRolePermissions);

            if(!empty($rolePermissions))
            {
               $p = AdminPermission::handlePermissions($v->id, $rolePermissions);
            }
            else 
            {
                echo 'Role Permissions Not Found.';
            }
        }        

        return Command::SUCCESS;
    }
}
