<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update roles
        $roles = [
            'superadmin' => '1',
            'akuntan' => '2',
            'direktur' => '3',
            'manager' => '4',
            'kaprodi' => '5',
            'kabeng' => '6',
            'logistik' => '7',
            'purchasing' => '8',
            'vendor' => '9',
            'support' => '10',
            'procurement' => '11',
            'staff' => '12',
            'finance' => '13',
            'officialfixaset' => '14',
            'ketuayayasan' => '15',
            'pimpinanunitkarya' => '16',
            'direkturkeuangan' => '17',
            'direkturmanagementaset' => '18',
            'manageraset' => '19',
        ];

        foreach ($roles as $roleName => $roleId) {
            Role::updateOrCreate(['name' => $roleName], ['name' => $roleName]);
        }

        // Define users with updated data
        $users = [
            [
                'username' => 'adminweb',
                'email' => 'itatmicorp@gmail.com',
                'password' => 'adminweb',
                'role' => 'superadmin',
                'id_divisi' => '1',
                'ttd' => 'admin.jpg',
            ],
            [
                'username' => 'manager',
                'email' => 'manager@gmail.com',
                'password' => 'manager',
                'role' => 'manager',
                'id_divisi' => '1',
                'ttd' => 'admin.jpg',
            ],
            [
                'username' => 'KetuaYayasan',
                'email' => 'ketuayayasan@gmail.com',
                'password' => 'ketuayayasan',
                'role' => 'ketuayayasan',
                'id_divisi' => '5',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'PimpinanUnitKarya',
                'email' => 'pimpinanunitkarya@gmail.com',
                'password' => 'pimpinanunitkarya',
                'role' => 'pimpinanunitkarya',
                'id_divisi' => '5',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'direktur',
                'email' => 'direkturpoltekatmi@gmail.com',
                'password' => 'dirpoltek',
                'role' => 'direktur',
                'id_divisi' => '5',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'logistik',
                'email' => 'logistik@gmail.com',
                'password' => 'logistik',
                'role' => 'logistik',
                'id_divisi' => '3',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'finance',
                'email' => 'financeManager@gmail.com',
                'password' => 'finance123',
                'role' => 'finance',
                'id_divisi' => '6',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'purchasing',
                'email' => 'purchasing@gmail.com',
                'password' => 'purchasing123',
                'role' => 'purchasing',
                'id_divisi' => '7',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'vendor',
                'email' => 'vendor@gmail.com',
                'password' => 'vendor123',
                'role' => 'vendor',
                'id_divisi' => '8',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'support',
                'email' => 'SupportManager@gmail.com',
                'password' => 'support123',
                'role' => 'support',
                'id_divisi' => '9',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'accountant',
                'email' => 'AccountantManager@gmail.com',
                'password' => 'Accountant123',
                'role' => 'akuntan',
                'id_divisi' => '10',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'procurement',
                'email' => 'procurement@gmail.com',
                'password' => 'procurement123',
                'role' => 'procurement',
                'id_divisi' => '11',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'karyawan',
                'email' => 'karyawan@gmail.com',
                'password' => 'karyawan123',
                'role' => 'staff',
                'id_divisi' => '2',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'kaprodiPoliteknik',
                'email' => 'kaprodipoltek@gmail.com',
                'password' => 'kaprodi123',
                'role' => 'kaprodi',
                'id_divisi' => '4',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'manageryayasan',
                'email' => 'manageryayasan@gmail.com',
                'password' => 'kaprodi123',
                'role' => 'kaprodi',
                'id_divisi' => '1',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'kukmikael',
                'email' => 'kukmikael@gmail.com',
                'password' => 'kaprodi123',
                'role' => 'kaprodi',
                'id_divisi' => '12',
                'ttd' => 'default.png',
            ]
            ,
            [
                'username' => 'kabeng',
                'email' => 'kabeng@gmail.com',
                'password' => 'kabeng123',
                'role' => 'kabeng',
                'id_divisi' => '4',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'FixAset',
                'email' => 'officialfixaset@gmail.com',
                'password' => 'ofcfixaset',
                'role' => 'officialfixaset',
                'id_divisi' => '1',
                'ttd' => 'admin.jpg',
            ],
            [
                'username' => 'DirekturKeuangan',
                'email' => 'direkturkeuangan@gmail.com',
                'password' => 'dirkeuangan',
                'role' => 'direkturkeuangan',
                'id_divisi' => '1',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'DirekturManajemenAset',
                'email' => 'dirmanaset@gmail.com',
                'password' => 'dirmanaset',
                'role' => 'direkturmanagementaset',
                'id_divisi' => '1',
                'ttd' => 'default.png',
            ],
            [
                'username' => 'ManagerAset',
                'email' => 'manageraset@gmail.com',
                'password' => 'manageraset',
                'role' => 'manageraset',
                'id_divisi' => '1',
                'ttd' => 'default.png',
            ],
        ];

        foreach ($users as $userData) {
            $role = Role::where('name', $userData['role'])->first();
            $user = User::updateOrCreate(
                ['email' => $userData['email']], // Assuming email is unique
                [
                    'username' => $userData['username'],
                    'password' => Hash::make($userData['password']),
                    'role_id' => $role ? $role->id : null,
                    'id_divisi' => $userData['id_divisi'],
                    'ttd' => $userData['ttd'],
                ]
            );

            // Assign role to user if it exists
            if ($role) {
                $user->syncRoles([$role]);
            }
        }
    }
}
