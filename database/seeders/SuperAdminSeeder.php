<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
/**
* Run the database seeds.
*/
public function run(): void
{
// Creating Super Admin User
$superAdmin = User::create([
'name' => 'Rivo',
'email' => 'superadmin@roles.id',
'password' => Hash::make('12345')
]);
$superAdmin->assignRole('Super Admin');

// Creating Super Admin baak
$adminbaak = User::create([
'name' => 'Elsa',
'email' => 'adminbaak@roles.id',
'password' => Hash::make('12345')
]);

$adminbaak->assignRole('admin baak');


// Creating Admin Keuangan
$adminkeuangan = User::create([
'name' => 'Lili',
'email' => 'adminkeuangan@roles.id',
'password' => Hash::make('12345')
]);

$adminkeuangan->assignRole('admin keuangan');

// Creating Product Manager User

$mahasiswa = User::create([
'name' => 'Sasa',
'email' => 'mahasiswa@roles.id',
'password' => Hash::make('12345')
]);
$mahasiswa->assignRole('mahasiswa');

}
}