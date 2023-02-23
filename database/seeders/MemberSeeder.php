<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Member::create([
            'nip' => 'NM10201010',
            'nama' => 'Pandu',
            'jk' => 'Pria',
            'alamat' => 'Perum Suko, Sidoarjo.',
        ]);

        Member::create([
            'nip' => 'NM10201011',
            'nama' => 'Gugus P.',
            'jk' => 'Pria',
            'alamat' => 'Perumtas 3, Wonoayu -  Sidoarjo.',
        ]);

        Member::create([
            'nip' => 'NM10201012',
            'nama' => 'Betty C.',
            'jk' => 'Wanita',
            'alamat' => 'Tanggulangin, Sidoarjo.',
        ]);
    }
}
