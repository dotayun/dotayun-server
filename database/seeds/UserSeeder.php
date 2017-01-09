<?php
/**
 * Desc: 功能描述
 * Created by PhpStorm.
 * User: xuanskyer | <furthestworld@icloud.com>
 * Date: 2017-01-09 15:23
 */

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {

    public function run() {
        app('db')->table('users')->delete();

        $user   = app()->make('App\User');
        $hasher = app()->make('hash');

        $user->fill(
            [
                'name'     => 'xuanskyer',
                'email'    => 'furthestworld@icloud.com',
                'password' => $hasher->make('123456')
            ]
        );
        $user->save();
    }

}