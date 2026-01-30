<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $suppliers = [
            ['name' => 'Tech Distributors Ltd', 'email' => 'contact@techdist.com', 'phone' => '9876543210', 'address' => '123 Tech Street, Mumbai'],
            ['name' => 'Furniture Wholesale Co', 'email' => 'sales@furnwholesale.com', 'phone' => '9876543211', 'address' => '456 Furniture Road, Delhi'],
            ['name' => 'Office Supplies Inc', 'email' => 'info@officesupplies.com', 'phone' => '9876543212', 'address' => '789 Supply Lane, Bangalore'],
            ['name' => 'Food & Beverage Traders', 'email' => 'orders@foodtraders.com', 'phone' => '9876543213', 'address' => '321 Food Avenue, Chennai'],
            ['name' => 'Apparel Imports', 'email' => 'contact@apparelimports.com', 'phone' => '9876543214', 'address' => '654 Fashion Street, Kolkata'],
            ['name' => 'Book Publishers Direct', 'email' => 'sales@bookpub.com', 'phone' => '9876543215', 'address' => '987 Book Road, Pune'],
            ['name' => 'Sports Equipment Co', 'email' => 'info@sportsequip.com', 'phone' => '9876543216', 'address' => '147 Sports Complex, Hyderabad'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
