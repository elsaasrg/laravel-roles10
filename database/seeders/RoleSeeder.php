<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
 {
 /**
 * Run the database seeds.
 */
 public function run(): void
 {
     $adminbaak = Role::create(['name' => 'admin baak']);
     $adminkeuangan = Role::create(['name' => 'admin keuangan']);
     $mahasiswa = Role::create(['name' => 'mahasiswa']);
 Role::create(['name' => 'Super Admin']);
//  $admin = Role::create(['name' => 'Admin']);
//  $Operator = Role::create(['name' => 'Operator']);
 $adminbaak->givePermissionTo([
 'create-mahasiswa',
 'edit-mahasiswa',
 'delete-mahasiswa',
 'show-mahasiswa'
 ]);

 
 $adminkeuangan->givePermissionTo([
 'show-mahasiswa'
 ]);

 
 $mahasiswa->givePermissionTo([
 'edit-mahasiswa',
 'show-mahasiswa'
 ]);

}

 }