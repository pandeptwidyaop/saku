<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Periode;
use App\Profile;
use App\Member;
use App\Administrator;
use App\Fund;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
      $user = User::create([
        'username' => 'pande',
        'password' => bcrypt(123456),
        'role' => 'admin',
        'access' => 'granted',
        'picture' => 'users/user.png'
      ]);


      $periode = Periode::create([
        'periode' => '2015/2016',
        'config' => json_encode([
          'theme' => 'skin-red',
        ])
      ]);

      $profile = Profile::create([
        'nim' => '150030003',
        'name' => 'Pande Putu Widya Oktapratama',
        'email' => 'widya.oktapratama@gmail.com',
        'handphone' => '085737484960',
        'address' => 'Jalan Gunung Agung Gang Bumi Ayu G No 17 Denpasar',
        'birthday' => '1997-10-19',
        'sex' => 'male'
      ]);

      $member = Member::create([
        'periode_id' => $periode->id,
        'profile_id' => $profile->id,
      ]);

      $admin = Administrator::create([
        'member_id' => $member->id,
        'user_id' => $user->id,
        'position' => 'sekretaris'
      ]);

      $fund = Fund::create([
        'periode_id' => $periode->id,
        'fund' => 0
      ]);
    }
}
