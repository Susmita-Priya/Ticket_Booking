<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //For roll and permission
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            //For Role and permission
            'role-and-permission-list',

            //For Resource
            'resource-list',

            //For User
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',


            //For About
            'about-list',
            'about-create',
            'about-edit',
            'about-delete',

            //For Faq
            'faq-list',
            'faq-create',
            'faq-edit',
            'faq-delete',

            //For Offer
            'offer-list',
            'offer-create',
            'offer-edit',
            'offer-delete',

            //For Terms
            'terms-list',
            'terms-create',
            'terms-edit',
            'terms-delete',

            //For Category
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',

            //For Type
            'type-list',
            'type-create',
            'type-edit',
            'type-delete',


            //For Amenities
            'amenities-list',
            'amenities-create',
            'amenities-edit',
            'amenities-delete',


            //Site Setting
            'site-setting',
            'cart-list',

            //Dashboard
            'login-log-list',


        ];
        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
    }
}
