<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting\Role;
use App\Models\Setting\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserSeeder extends Seeder {
  /**
   * Create the initial roles and permissions.
   *
   * @return void
   */
  public function permissionCrud($paramRole, $paramSubject) {
    $paramRole->givePermissionTo("$paramSubject.show");
    $paramRole->givePermissionTo("$paramSubject.create");
    $paramRole->givePermissionTo("$paramSubject.update");
    $paramRole->givePermissionTo("$paramSubject.delete");
    $paramRole->givePermissionTo("$paramSubject.self");
  }
  public function createPermission($paramsSubject) {
    Permission::create(['name' => "$paramsSubject.show"]);
    Permission::create(['name' => "$paramsSubject.create"]);
    Permission::create(['name' => "$paramsSubject.update"]);
    Permission::create(['name' => "$paramsSubject.delete"]);
    Permission::create(['name' => "$paramsSubject.self"]);
  }
  public function run() {
    // Reset cached roles and permissions
    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    // create permissions
    Permission::create(['name' => 'dashboard.self']);
    $this->createPermission('user');
    $this->createPermission('role');
    $this->createPermission('hardware');
    $this->createPermission('maintenance');
    $this->createPermission('category');
    $this->createPermission('permission');
    $this->createPermission('setting');
    $this->createPermission('master');
    $this->createPermission('data_log');

    // create roles and assign existing permissions
    $role1 = Role::create(['name' => 'Superadmin']);
    $this->permissionCrud($role1, 'user');
    $this->permissionCrud($role1, 'role');
    $this->permissionCrud($role1, 'hardware');
    $this->permissionCrud($role1, 'category');
    $this->permissionCrud($role1, 'setting');
    $this->permissionCrud($role1, 'maintenance'); 
    $this->permissionCrud($role1, 'permission'); 
    $this->permissionCrud($role1, 'master'); 
    $this->permissionCrud($role1, 'data_log'); 

    $role2 = Role::create(['name' => 'Leader Operartor']);
    $this->permissionCrud($role2, 'maintenance'); 
    $this->permissionCrud($role2, 'data_log'); 

    $role3 = Role::create(['name' => 'Maintenance']);
    $this->permissionCrud($role3, 'maintenance'); 

    $role4 = Role::create(['name' => 'Leader Operator']);
    $this->permissionCrud($role4, 'maintenance'); 

    $role5 = Role::create(['name' => 'Operator']);
    $this->permissionCrud($role5, 'maintenance'); 

    // create demo users
    $user = User::create([
      'name'      => 'SuperAdmin',
      'username'  => 'superadmin',
      'email'     => 'superadmin@example.com',
      'password'  => Hash::make('123')
    ]);
    $user->assignRole($role1);

    $user = User::create([
      'name'      => 'Leader Maintenance',
      'username'  => 'maintainer',
      'email'     => 'leader.maintenance@example.com',
      'password'  => Hash::make('123')
    ]);
    $user->assignRole($role2);

  }
}
