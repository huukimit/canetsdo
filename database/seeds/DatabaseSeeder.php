<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call('InsertWorkerSeeder');
        $this->call('InsertCustomerSeeder');
    }

}

class InsertCustomerSeeder extends Seeder {

    public function run() {
        $save = array();
        $j = 1;
        for ($i = 1; $i < 11; $i++) {
            $save[] = array(
                'fullname' => 'Customer ' . $i,
                'type_customer' => 2,
                'email' => 'chithanh101' . $i . '@gmail.com',
                'birthday' => '1992-12-10',
                'phone_number' => '09145242' . $i,
                'password' => sha1(123123),
                'lat' => '105.12533',
                'long' => '105.6526',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
        }
        DB::table('customers')->insert($save);
    }

}

class InsertWorkerSeeder extends Seeder {

    public function run() {
        $save = array();
        for ($i = 1; $i < 10; $i++) {
            $save[] = array(
                'fullname' => 'Nhan vien ' . $i,
                'type_customer' => 1,
                'email' => 'chithanh101' . $i . '@gmail.com',
                'birthday' => '1992-12-10',
                'phone_number' => '09145242' . $i,
                'password' => sha1(123123),
                'lat' => '105.12533',
                'long' => '105.6526',
                'manv' => 'CANETS000' . $i,
                'avatar' => 'default.jpg',
                'anhsv_truoc' => 'default.jpg',
                'anhsv_sau' => 'default.jpg',
                'anhcmtnd_truoc' => 'default.jpg',
                'anhcmtnd_sau' => 'default.jpg',
                'vi_tien' => 1000000,
                'vi_taikhoan' => 10000,
                'quequan' => 'Que quan ' . $i,
                'school' => 'School ' . $i,
                'anhcmtnd_sau' => 'default.jpg',
                'year_exp' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
        }
        DB::table('customers')->insert($save);
    }

}
