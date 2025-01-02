<?php

namespace Database\Seeders;

use App\Models\Userdetail;
use Illuminate\Database\Seeder;

class UserDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Userdetail::updateOrCreate([
            'id_user' => '1'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0001',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '2'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0002',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '3'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0005',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '4'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0006',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '5'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0007',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '6'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0008',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '7'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0011',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '8'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0012',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '9'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0013',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '10'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0014',
           
        ]);

    

        Userdetail::updateOrCreate([
            'id_user' => '13'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0018',
           
        ]);


        Userdetail::updateOrCreate([
            'id_user' => '16'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0019',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '11'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0020',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '12'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0021',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '14'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0022',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '13'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0023',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '18'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0024',
           
        ]);

        Userdetail::updateOrCreate([
            'id_user' => '17'
        ], [
            'nama_lengkap' => 'Default',
            'jenis_kelamin' => null,
            'no_induk_karyawan' => '0025',
           
        ]);
    }
}

