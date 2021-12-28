<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Topik', 
            'alamat' => 'Tembesi', 
            'hp' => '085668190996', 
            'foto' => 'uploads/topik.png', 
            'email' => 'topik@kurir.test',
            'password' => bcrypt('123456')
        ]);

    
        $role = Role::create(['name' => 'Admin']);
     
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
   
        //untuk kurir
        $user_kurir = User::create([
            'name' => 'heru', 
            'alamat' => 'tg. riau', 
            'hp' => '08080808080', 
            'foto' => 'uploads/heru.jpg', 
            'email' => 'heru@kurir.test',
            'password' => bcrypt('heru123')
        ]);

        $role_kurir = Role::create(['name' => 'Kurir']);

        $permissions_trx_list=Permission::findByName('transaksi-list');
        $role_kurir->givePermissionTo($permissions_trx_list);
        $permissions_trx_list->assignRole($role_kurir);
        
        $permissions_trx_create=Permission::findByName('transaksi-create');
        $role_kurir->givePermissionTo($permissions_trx_create);
        $permissions_trx_create->assignRole($role_kurir);

        $user_kurir->assignRole([$role_kurir->id]);

    }
}
