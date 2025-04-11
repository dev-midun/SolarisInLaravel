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
        $this->supervisor();
        $this->admin();
        $this->user();
    }

    protected function supervisor(): void
    {
        $user = User::create([
            'name' => 'Supervisor',
            'email' => 'supervisor@sunny.co.id',
            'password' => Hash::make('Supervisor')
        ]);
        $user->assignRole('Supervisor');
    }

    protected function admin(): void
    {
        $now = Carbon::now();
        $data = [
            'user' => [
                'name' => 'Test Admin 1',
                'email' => 'test_admin@test.com',
                'password' => Hash::make('test_admin@test.com')
            ],
            'profile' => [
                'name' => 'Test Admin 1',
                'email' => 'test_admin@test.com',
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
        $owner = User::select('id')->where('email', 'test_admin@test.com')->first();
        $now = Carbon::now();
        $data = [
            [
                'user' => [
                    'name' => 'Test user 1',
                    'email' => 'test_user_1@test.com',
                    'password' => Hash::make('test_user_1@test.com'),
                    'owner_id' => $owner->id
                ],
                'profile' => [
                    'name' => 'Test user 1',
                    'email' => 'test_user_1@test.com',
                    'phone_number' => '081234567890',
                    'gender_id' => GenderConst::Male,
                    'birthdate' => $now,
                    'birthplace' => $now,
                    'address' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"
                ]
            ],
            [
                'user' => [
                    'name' => 'Test user 2',
                    'email' => 'test_user_2@test.com',
                    'password' => Hash::make('test_user_2@test.com'),
                    'owner_id' => $owner->id
                ],
                'profile' => [
                    'name' => 'Test user 2',
                    'email' => 'test_user_2@test.com',
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
