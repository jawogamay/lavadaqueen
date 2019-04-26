<?php


use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        User::create([
            'name' => 'Lavada Queen',
            'type' => 'Laundry Shop',
            'email' => 'lavada@gmail.com',
            'phone' => '09472195796',
            'type' => 'Laundry Shop',
            'email_verified_at' => NOW(),
            'password' => Hash::make('admin123')
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
