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
            //slider
            'slider-list',
            'slider-create',
            'slider-edit',
            'slider-delete',

            //blog
            'blog-list',
            'blog-create',
            'blog-edit',
            'blog-delete',

            //service
            'service-list',
            'service-create',
            'service-edit',
            'service-delete',
            
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
            'vehicle-select',
            'seats-list',
            'seats-create',
            'seats-edit',
            'seats-delete',


            // For seat booking
            'seat-booking-list',
            'seat-booking-create',
            'seat-booking-edit',
            'seat-booking-delete',

            //For Ticket Booking
            'ticket-booking',
            'ticket-booking-list',
            'ticket-print',


            //Site Setting
            'site-setting',
            'cart-list',


            //For Booking
            'booking-list',
            'booking-create',
            'booking-edit',
            'booking-delete',


            //reset booking
            'reset-seat-list',


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

            //For Division
            'division-list',
            'division-create',
            'division-edit',
            'division-delete',

            //For District
            'district-list',
            'district-create',
            'district-edit',
            'district-delete',


            //For Place
            'place-list',
            'place-create',
            'place-edit',
            'place-delete',


            //For Counter
            'counter-list',
            'counter-create',
            'counter-edit',
            'counter-delete',


            //For employee
            'employee-list',
            'employee-create',
            'employee-edit',
            'employee-delete',


            //For route
            'route-list',
            'route-create',
            'route-edit',
            'route-delete',

            //For Trip
            'trip-list',
            'trip-create',
            'trip-edit',
            'trip-delete',

            //For Completed Trip
            'completed-trip-list',

            //setting
            'setting-list',

            //For Accounting
            'accounting-list',

            //For Expense
            'expense-list',
            'expense-create',
            'expense-edit',
            'expense-delete',
            'deleted-expense-list',

            //For Income
            'income-list',


        ];
        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
    }
}
