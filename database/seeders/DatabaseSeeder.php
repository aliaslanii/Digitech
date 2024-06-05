<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Wallet;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'firstName' => 'Ali',
            'lastName' => 'Aslani',
            'mobile' => '09227659746',
            'email' => 'a@a.com',
            'password' => Hash::make('Ali_1727'),
        ]);
        $wallet = new Wallet();
        $wallet->user_id = 1;
        $wallet->inventory = 0;
        $wallet->status = true;
        $wallet->save();
        $Customer = new Customer();
        $Customer->user_id = 1;
        $Customer->save();
        $Cart = new Cart();
        $Cart->user_id = 1;
        $Cart->is_pay = 0;
        $Cart->save();
        Role::create([
            'name' => 'Admin'
        ]);
        Role::create([
            'name' => 'Read'
        ]);
        Role::create([
            'name' => 'Create'
        ]);
        Role::create([
            'name' => 'Update'
        ]);
        Role::create([
            'name' => 'Delete'
        ]);
        RoleUser::create([
            'role_id' => 1,
            'user_id' => 1
        ]);
        RoleUser::create([
            'role_id' => 2,
            'user_id' => 1
        ]);
        RoleUser::create([
            'role_id' => 3,
            'user_id' => 1
        ]);
        RoleUser::create([
            'role_id' => 4,
            'user_id' => 1
        ]);
        RoleUser::create([
            'role_id' => 5,
            'user_id' => 1
        ]);
    }
}
