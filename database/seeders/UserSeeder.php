<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Traits\ReferenceTrait;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserAccount;
use App\Classes\Table;

class UserSeeder extends Seeder
{
    use ReferenceTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    for ($i=0; $i < 10; $i++) { 
        $uuid=ReferenceTrait::generateReferenceNumber();
        $name=ReferenceTrait::fakename();
        $email=ReferenceTrait::fakename()."@callphone.com";
        $phonenumber=ReferenceTrait::generateReferenceNumber();
       User::create( [
        'uuid' => $uuid,
        'name'=>$name,
        'email' => $email,
        'phone_number' => $phonenumber,
        'password'=>bcrypt('admin123')
    ]);
    $lastUser=table::users()->latest('created_at')->first();
        UserDetail::create( [
            'name'=>$name,
            'address'=>"Demo address",
            'state'=>"FCT",
            'dob'=>"1989-12-30",
            'user_id'=>$lastUser->id
        ]);

        UserAccount::create( [
            'bank_name'=>"UBA",
            'account_number'=>$uuid,
            'account_name'=>$name,
            'user_id'=>$lastUser->id
        ]);
    } 
   
    }
}
