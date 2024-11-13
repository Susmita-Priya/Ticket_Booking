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


            //For Journey Type
            'journey_type-list',
            'journey_type-create',
            'journey_type-edit',
            'journey_type-delete',


            //For Amenities
            'amenities-list',
            'amenities-create',
            'amenities-edit',
            'amenities-delete',


            //For Vehicle
            'vehicle-list',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-delete',


            //For Country
            'country-list',
            'country-create',
            'country-edit',
            'country-delete',


            //For Location
            'location-list',
            'location-create',
            'location-edit',
            'location-delete',


            //For Seats
            'seats-list',
            'seats-create',
            'seats-edit',
            'seats-delete',


            //Site Setting
            'site-setting',
            'cart-list',


            //For Booking
            'booking-list',
            'booking-create',
            'booking-edit',
            'booking-delete',


            //For Cupon
            'cupon-list',
            'cupon-create',
            'cupon-edit',
            'cupon-delete',


            //For Plane
            'plane-list',
            'plane-create',
            'plane-edit',
            'plane-delete',

            
            //For Plane Journey
            'plane-journey-list',
            'plane-journey-create',
            'plane-journey-edit',
            'plane-journey-delete',


            //Dashboard
            'login-log-list',
            'admin-menu-list',
            'menu-list-for-bus',
            'menu-list-for-plane',


        ];
        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
    }
}
