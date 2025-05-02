<?php

namespace Database\Seeders;

use App\Const\GenderConst;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->admin();
        $this->user();
    }

    protected function admin(): void
    {
        $now = Carbon::now();
        $data = [
            'user' => [
                'name' => 'Solaris Admin',
                'email' => 'admin@solaris.com',
                'password' => Hash::make('admin@solaris.com')
            ],
            'profile' => [
                'name' => 'Solaris Admin',
                'email' => 'admin@solaris.com',
                'phone_number' => '081234567890',
                'gender_id' => GenderConst::Male,
                'birthdate' => $now,
                'birthplace' => $now,
                'address' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"
            ]
        ];

        $user = User::create($data['user']);
        $user->markEmailAsVerified();
        $user->assignRole('Admin');

        $data['profile']['user_id'] = $user->id;
        Profile::create($data['profile']);
    }

    protected function user(): void
    {
        $now = Carbon::now();
        $data = [
            [
                'user' => [
                    'name' => 'Solaris User 1',
                    'email' => 'user1@solaris.com',
                    'password' => Hash::make('user1@solaris.com')
                ],
                'profile' => [
                    'name' => 'Solaris User 1',
                    'email' => 'user1@solaris.com',
                    'phone_number' => '081234567890',
                    'gender_id' => GenderConst::Male,
                    'birthdate' => $now,
                    'birthplace' => $now,
                    'address' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"
                ]
            ],
            [
                'user' => [
                    'name' => 'Solaris User 2',
                    'email' => 'user2@solaris.com',
                    'password' => Hash::make('user2@solaris.com')
                ],
                'profile' => [
                    'name' => 'Solaris User 2',
                    'email' => 'user2@solaris.com',
                    'phone_number' => '081234567890',
                    'gender_id' => GenderConst::Male,
                    'birthdate' => $now,
                    'birthplace' => $now,
                    'address' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"
                ]
            ]
        ];

        foreach ($data as $value) {
            $user = User::create($value['user']);
            $user->markEmailAsVerified();
            $user->assignRole('User');

            $value['profile']['user_id'] = $user->id;
            Profile::create($value['profile']);
        }
    }
}
