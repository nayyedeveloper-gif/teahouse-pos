<?php

namespace Database\Seeders;

use App\Models\Printer;
use Illuminate\Database\Seeder;

class PrinterSeeder extends Seeder
{
    public function run(): void
    {
        $printers = [
            [
                'name' => 'Kitchen Printer',
                'type' => 'kitchen',
                'ip_address' => env('KITCHEN_PRINTER_IP', '192.168.1.100'),
                'port' => env('KITCHEN_PRINTER_PORT', 9100),
                'is_active' => false, // Disabled by default until configured
                'paper_width' => 80,
            ],
            [
                'name' => 'Bar Printer',
                'type' => 'bar',
                'ip_address' => env('BAR_PRINTER_IP', '192.168.1.101'),
                'port' => env('BAR_PRINTER_PORT', 9100),
                'is_active' => false, // Disabled by default until configured
                'paper_width' => 80,
            ],
            [
                'name' => 'Receipt Printer',
                'type' => 'receipt',
                'ip_address' => env('RECEIPT_PRINTER_IP', '192.168.1.102'),
                'port' => env('RECEIPT_PRINTER_PORT', 9100),
                'is_active' => false, // Disabled by default until configured
                'paper_width' => 80,
            ],
        ];

        foreach ($printers as $printer) {
            Printer::create($printer);
        }
    }
}
