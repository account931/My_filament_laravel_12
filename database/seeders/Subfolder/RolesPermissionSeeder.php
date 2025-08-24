<?php

// create Roles, permission and assign them to some users
// Manual: create some pesrmissions -> assign them to some roles -> assign this role to some user

namespace Database\Seeders\Subfolder;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0');       //way to set auto increment back to 1 before seeding a table (instead of ->delete())
        // DB::table('roles')->truncate(); //way to set auto increment back to 1 before seeding a table
        // DB::table('permissions')->truncate();

        /*
        if (count(Role::findByName('admin')->get()) <= 0 ) {
            $role = Role::create(['name' => 'admin']);
        }
        */

        // Create Permissions ------------------------------------------------------------------------------------------------
        // Owner permission
        $permissionViewOwner = Permission::create(['name' => 'view owner']);
        $permissionViewOwners = Permission::create(['name' => 'view owners']);
        $permissionEditOwner = Permission::create(['name' => 'edit owners']);
        $permissionDeleteOwner = Permission::create(['name' => 'delete owners']);

        // Venue permissions
        $permissionViewVenue = Permission::create(['name' => 'view venue ']);
        $permissionViewVenues = Permission::create(['name' => 'view venues']);
        $permissionEditVenue = Permission::create(['name' => 'edit venue']);
        $permissionDeleteVenue = Permission::create(['name' => 'delete venue']);

        // Role permission (view my Role panel in Filament
        $permissionViewRole = Permission::create(['name' => 'view roles']);

        // Laravel audit permission
        $permissionViewAudits = Permission::create(['name' => 'view audits']);

        // create Api permission 'view owner admin quantity'
        // NB: API permission!!!!! Must have 'guard_name' => 'api', but gives an error. Fix: can run like this, then change in DB manually
        $permissionViewOwnerQauantityAdmin = Permission::create(['name' => 'view owner admin quantity', 'guard_name' => 'web']); // permission to test API route /api/owner/quantity/admin
        // fix (because it should be 'guard_name' => 'api'), but seedeing this causes the error
        $updated = DB::table('permissions')->where('name', 'view owner admin quantity')->update(['guard_name' => 'api']);
        // end create Api permission 'view owner admin quantity'

        // https://scramble.dedoc.co/
        // Scramble docs permission, used in middleware '/Middleware/CheckOneTimeToken'. Does not usual policy
        $permissionViewScrambleDocs = Permission::create(['name' => 'view scramble docs']);

        $permissionNotForAdmin = Permission::create(['name' => 'not admin permission']); // some permission for test
        // End Create Permissions --------------------------------------------------------------------------------------------

        // Create admin role, give this role same/all permissions and assign role to some user/users  --------------------------------------
        $role = Role::create(['name' => 'admin']);

        // $role->givePermissionTo($permission);
        $role = Role::findByName('admin');
        $role->syncPermissions([
            // owners permission
            $permissionViewOwner,
            $permissionViewOwners,
            $permissionEditOwner,
            $permissionDeleteOwner,

            // venues permission
            $permissionViewVenue,
            $permissionViewVenues,
            $permissionEditVenue,
            $permissionDeleteVenue,

            // Laravel audit permission
            $permissionViewAudits,

            $permissionViewRole,
            $permissionViewOwnerQauantityAdmin,

            // Scramble docs permission
            $permissionViewScrambleDocs,

        ]);  // multiple permission to role

        // End Create admin role and give him permissions  -----------------------------------------------------------------

        // Assign 'Admin' role to User 1, see who is User 1 in UserSeeder
        User::first()->assignRole('admin');

        // Create user role and give him permissions and assign role to some user/users ------------------------------------
        $role = Role::create(['name' => 'user']);
        $role = Role::findByName('user');
        $role->syncPermissions([$permissionViewOwner, $permissionViewOwners, $permissionViewVenue, $permissionViewVenues, $permissionViewAudits]);  // multiple permission to role

        // Assign 'User' role to User 2
        User::skip(1)->first()->assignRole('user');

    }
}
