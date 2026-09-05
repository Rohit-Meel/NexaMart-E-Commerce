<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        CategorySeeder::class,
        SubCategorySeeder::class,
        BrandSeeder::class,
        VendorSeeder::class,
        CustomerSeeder::class,
        AddressSeeder::class,
        ProductSeeder::class,
        ProductImageSeeder::class,
        CartSeeder::class,
        WishlistSeeder::class,
        CouponSeeder::class,
        OrderSeeder::class,
        OrderItemSeeder::class,
        ReviewSeeder::class,
        NotificationSeeder::class,
        BannerSeeder::class,
        ContactSeeder::class,
        SettingSeeder::class,
        AdminSeeder::class,
    ]);
}
}
