<?php

namespace Database\Seeders;

use App\Models\ReportOrderSale;
use Illuminate\Database\Seeder;

class ReportOrderSaleSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            [
                'uid' => 'ORD-001',
                'customer_name' => 'John Doe',
                'po_number' => 'PO-2024-001',
                'tracking_number' => 'TRK123456789',
                'shipping_fee' => 25.50,
                'requested_at' => now(),
                'status' => 'Shipping Paid'
            ],
            [
                'uid' => 'ORD-002',
                'customer_name' => 'Jane Smith',
                'po_number' => 'PO-2024-002',
                'tracking_number' => 'TRK987654321',
                'shipping_fee' => 15.00,
                'requested_at' => now(),
                'status' => 'Pending Shipping Payment'
            ],
            [
                'uid' => 'ORD-003',
                'customer_name' => 'Mike Johnson',
                'po_number' => 'PO-2024-003',
                'tracking_number' => null,
                'shipping_fee' => 30.75,
                'requested_at' => now(),
                'status' => 'Pending Shipping Payment'
            ],
        ];

        foreach ($orders as $order) {
            ReportOrderSale::create($order);
        }
    }
}