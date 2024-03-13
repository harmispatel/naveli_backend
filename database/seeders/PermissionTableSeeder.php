<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'roles',
            'roles.create',
            'roles.edit',
            'roles.destroy',
            'users',
            'users.create',
            'users.edit',
            'users.destroy',
            'age.index',
            'age.create',
            'age.edit',
            'age.destroy',
            'question.index',
            'question.create',
            'question.edit',
            'question.destroy',
            'question.optionView',
            'news.index',
            'news.create',
            'news.edit',
            'news.destroy',
            'healthMix.index',
            'healthMix.create',
            'healthMix.edit',
            'healthMix.destroy',
            'posts.index',
            'posts.create',
            'posts.edit',
            'posts.destroy',
            'medicine.index',
            'medicine.create',
            'medicine.edit',
            'medicine.destroy',
            'ailments.index',
            'ailments.create',
            'ailments.edit',
            'ailments.destroy',

         ];

         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
