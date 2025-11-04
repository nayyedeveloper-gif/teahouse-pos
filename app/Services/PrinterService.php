<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Printer;
use App\Models\Setting;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer as EscposPrinter;
use Mike42\Escpos\EscposImage;
use Exception;

class PrinterService
{
    /**
     * Initialize printer with Myanmar Unicode support
     */
    private function initializePrinter($connector)
    {
        $escposPrinter = new EscposPrinter($connector);
        // Nippon 808UE has built-in Myanmar font
        // No codepage change needed - use default
        return $escposPrinter;
    }
    /**
     * Print kitchen order items
     */
    public function printKitchenOrder(Order $order, array $items = null)
    {
        $printer = Printer::active()->kitchen()->first();
        
        if (!$printer) {
            logger()->warning('Kitchen printer not configured or not active');
            return; // Don't throw exception, just log and return
        }

        if ($items !== null) {
            // Filter items for kitchen
            $orderItems = collect($items)->filter(function ($item) {
                return $item->item->category->printer_type === 'kitchen' && !$item->is_printed;
            });
        } else {
            $orderItems = $order->items()
                ->whereHas('item.category', function ($query) {
                    $query->where('printer_type', 'kitchen');
                })
                ->unprinted()
                ->get();
        }

        if ($orderItems->isEmpty()) {
            logger()->info('No kitchen items to print for order: ' . $order->order_number);
            return;
        }

        logger()->info('Attempting to print ' . $orderItems->count() . ' kitchen items for order: ' . $order->order_number);

        try {
            $connector = new NetworkPrintConnector($printer->ip_address, $printer->port, 2);
            $escposPrinter = $this->initializePrinter($connector);

            // Header
            $escposPrinter->setJustification(EscposPrinter::JUSTIFY_CENTER);
            $escposPrinter->setEmphasis(true);
            $escposPrinter->setTextSize(2, 2);
            $escposPrinter->text(__('printer.kitchen') . "\n");
            $escposPrinter->text(__('printer.kitchen_header') . "\n");
            $escposPrinter->setTextSize(1, 1);
            $escposPrinter->setEmphasis(false);
            $escposPrinter->text(str_repeat("-", 48) . "\n");

            // Order info
            $escposPrinter->setJustification(EscposPrinter::JUSTIFY_LEFT);
            $escposPrinter->setEmphasis(true);
            $escposPrinter->text(__('printer.order_number') . " / " . __('printer.order') . ": " . $order->order_number . "\n");
            
            if ($order->table) {
                $tableName = $order->table->name_mm ?? $order->table->name;
                $escposPrinter->text(__('printer.table') . " / " . __('printer.table_en') . ": " . $tableName . "\n");
            } else {
                $escposPrinter->text(__('printer.type') . " / " . __('printer.type_en') . ": " . __('printer.takeaway') . "\n");
            }
            
            $escposPrinter->text(__('printer.time') . " / " . __('printer.time_en') . ": " . now()->format('H:i') . "\n");
            $escposPrinter->setEmphasis(false);
            $escposPrinter->text(str_repeat("-", 48) . "\n");

            // Items
            foreach ($orderItems as $orderItem) {
                $itemName = $orderItem->item->name_mm ?? $orderItem->item->name;
                
                $escposPrinter->setEmphasis(true);
                $escposPrinter->setTextSize(1, 1);
                $escposPrinter->text(sprintf("x%d  %s\n", $orderItem->quantity, $itemName));
                $escposPrinter->setTextSize(1, 1);
                $escposPrinter->setEmphasis(false);
                
                if ($orderItem->notes) {
                    $escposPrinter->text("   " . __('printer.notes') . ": " . $orderItem->notes . "\n");
                }
                
                if ($orderItem->is_foc) {
                    $escposPrinter->text("   ** " . __('printer.foc') . " **\n");
                }
                
                $escposPrinter->text("\n");
            }

            $escposPrinter->text(str_repeat("-", 48) . "\n");
            $escposPrinter->feed(2);
            $escposPrinter->cut();
            $escposPrinter->close();

            // Mark items as printed
            foreach ($orderItems as $orderItem) {
                $orderItem->update([
                    'is_printed' => true,
                    'printed_at' => now(),
                ]);
            }

        } catch (Exception $e) {
            logger()->error('Kitchen printer error: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'printer_ip' => $printer->ip_address,
                'printer_port' => $printer->port,
            ]);
            throw new Exception('Kitchen printer error: ' . $e->getMessage());
        }
    }

    /**
     * Print bar order items
     */
    public function printBarOrder(Order $order, array $items = null)
    {
        $printer = Printer::active()->bar()->first();
        
        if (!$printer) {
            logger()->warning('Bar printer not configured or not active');
            return; // Don't throw exception, just log and return
        }

        if ($items !== null) {
            // Filter items for bar
            $orderItems = collect($items)->filter(function ($item) {
                return $item->item->category->printer_type === 'bar' && !$item->is_printed;
            });
        } else {
            $orderItems = $order->items()
                ->whereHas('item.category', function ($query) {
                    $query->where('printer_type', 'bar');
                })
                ->unprinted()
                ->get();
        }

        if ($orderItems->isEmpty()) {
            logger()->info('No bar items to print for order: ' . $order->order_number);
            return;
        }

        logger()->info('Attempting to print ' . $orderItems->count() . ' bar items for order: ' . $order->order_number);

        try {
            $connector = new NetworkPrintConnector($printer->ip_address, $printer->port, 2);
            $escposPrinter = $this->initializePrinter($connector);

            // Header
            $escposPrinter->setJustification(EscposPrinter::JUSTIFY_CENTER);
            $escposPrinter->setEmphasis(true);
            $escposPrinter->setTextSize(2, 2);
            $escposPrinter->text(__('printer.bar') . "\n");
            $escposPrinter->text(__('printer.bar_header') . "\n");
            $escposPrinter->setTextSize(1, 1);
            $escposPrinter->setEmphasis(false);
            $escposPrinter->text(str_repeat("-", 48) . "\n");

            // Order info
            $escposPrinter->setJustification(EscposPrinter::JUSTIFY_LEFT);
            $escposPrinter->setEmphasis(true);
            $escposPrinter->text(__('printer.order_number') . " / " . __('printer.order') . ": " . $order->order_number . "\n");
            
            if ($order->table) {
                $tableName = $order->table->name_mm ?? $order->table->name;
                $escposPrinter->text(__('printer.table') . " / " . __('printer.table_en') . ": " . $tableName . "\n");
            } else {
                $escposPrinter->text(__('printer.type') . " / " . __('printer.type_en') . ": " . __('printer.takeaway') . "\n");
            }
            
            $escposPrinter->text(__('printer.time') . " / " . __('printer.time_en') . ": " . now()->format('H:i') . "\n");
            $escposPrinter->setEmphasis(false);
            $escposPrinter->text(str_repeat("-", 48) . "\n");

            // Items
            foreach ($orderItems as $orderItem) {
                $itemName = $orderItem->item->name_mm ?? $orderItem->item->name;
                
                $escposPrinter->setEmphasis(true);
                $escposPrinter->setTextSize(1, 1);
                $escposPrinter->text(sprintf("x%d  %s\n", $orderItem->quantity, $itemName));
                $escposPrinter->setTextSize(1, 1);
                $escposPrinter->setEmphasis(false);
                
                if ($orderItem->notes) {
                    $escposPrinter->text("   " . __('printer.notes') . ": " . $orderItem->notes . "\n");
                }
                
                if ($orderItem->is_foc) {
                    $escposPrinter->text("   ** " . __('printer.foc') . " **\n");
                }
                
                $escposPrinter->text("\n");
            }

            $escposPrinter->text(str_repeat("-", 48) . "\n");
            $escposPrinter->feed(2);
            $escposPrinter->cut();
            $escposPrinter->close();

            // Mark items as printed
            foreach ($orderItems as $orderItem) {
                $orderItem->update([
                    'is_printed' => true,
                    'printed_at' => now(),
                ]);
            }

        } catch (Exception $e) {
            logger()->error('Bar printer error: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'printer_ip' => $printer->ip_address,
                'printer_port' => $printer->port,
            ]);
            throw new Exception('Bar printer error: ' . $e->getMessage());
        }
    }

    /**
     * Print customer receipt
     */
    public function printReceipt(Order $order)
    {
        $printer = Printer::active()->receipt()->first();
        
        if (!$printer) {
            logger()->warning('Receipt printer not configured or not active');
            return; // Don't throw exception, just log and return
        }

        logger()->info('Attempting to print receipt for order: ' . $order->order_number);

        try {
            $connector = new NetworkPrintConnector($printer->ip_address, $printer->port);
            $escposPrinter = $this->initializePrinter($connector);

            // Print logo if available
            $escposPrinter->setJustification(EscposPrinter::JUSTIFY_CENTER);
            $logo = Setting::get('app_logo');
            $showLogo = Setting::get('show_logo_on_receipt', false);
            
            if ($logo && $showLogo) {
                try {
                    $logoPath = storage_path('app/public/' . $logo);
                    if (file_exists($logoPath)) {
                        $img = EscposImage::load($logoPath);
                        $escposPrinter->bitImage($img);
                        $escposPrinter->feed();
                    }
                } catch (\Exception $e) {
                    logger()->warning('Failed to print logo: ' . $e->getMessage());
                }
            }

            // Business header
            $businessName = Setting::get('business_name', config('app.name'));
            $businessNameMm = Setting::get('business_name_mm', 'သာချိုကော်ဖီဆိုင်');
            $businessAddress = Setting::get('business_address', '');
            $businessPhone = Setting::get('business_phone', '');
            
            $escposPrinter->setEmphasis(true);
            $escposPrinter->setTextSize(2, 2);
            $escposPrinter->text($businessNameMm . "\n");
            $escposPrinter->setTextSize(1, 1);
            $escposPrinter->text($businessName . "\n");
            $escposPrinter->setEmphasis(false);
            if ($businessAddress) {
                $escposPrinter->text($businessAddress . "\n");
            }
            if ($businessPhone) {
                $escposPrinter->text($businessPhone . "\n");
            }
            $escposPrinter->text(str_repeat("=", 48) . "\n");

            // Order info
            $escposPrinter->setJustification(EscposPrinter::JUSTIFY_LEFT);
            $escposPrinter->text(__('printer.order_number') . " / " . __('printer.order') . ": " . $order->order_number . "\n");
            $escposPrinter->text(__('printer.date') . " / " . __('printer.date_en') . ": " . $order->created_at->format('d/m/Y H:i') . "\n");
            
            if ($order->table) {
                $tableName = $order->table->name_mm ?? $order->table->name;
                $escposPrinter->text(__('printer.table') . " / " . __('printer.table_en') . ": " . $tableName . "\n");
            }
            
            if ($order->waiter) {
                $escposPrinter->text(__('printer.waiter') . " / " . __('printer.waiter_en') . ": " . $order->waiter->name . "\n");
            }
            
            $escposPrinter->text(str_repeat("-", 48) . "\n");

            // Items header
            $escposPrinter->text(sprintf("%-25s %5s %10s\n", __('printer.item') . "/" . __('printer.item_en'), __('printer.quantity'), __('printer.amount') . "/" . __('printer.amount_en')));
            $escposPrinter->text(str_repeat("-", 48) . "\n");

            // Items
            foreach ($order->items as $orderItem) {
                $itemName = $orderItem->item->name_mm ?? $orderItem->item->name;
                
                // Truncate long names
                if (mb_strlen($itemName) > 25) {
                    $itemName = mb_substr($itemName, 0, 22) . '...';
                }
                
                $qty = "x" . $orderItem->quantity;
                $amount = number_format($orderItem->subtotal, 0);
                
                $escposPrinter->text(sprintf("%-25s %5s %10s\n", $itemName, $qty, $amount));
                
                if ($orderItem->notes) {
                    $escposPrinter->text("  " . __('printer.notes') . ": " . $orderItem->notes . "\n");
                }
                
                if ($orderItem->is_foc) {
                    $escposPrinter->setEmphasis(true);
                    $escposPrinter->text("  ** " . __('printer.foc') . " - " . __('printer.foc_mm') . " **\n");
                    $escposPrinter->setEmphasis(false);
                }
            }

            $escposPrinter->text(str_repeat("-", 48) . "\n");

            // Totals
            $escposPrinter->setJustification(EscposPrinter::JUSTIFY_RIGHT);
            $escposPrinter->text(sprintf(__('printer.subtotal') . " / " . __('printer.subtotal_en') . ": %s Ks\n", number_format($order->subtotal, 0)));
            
            if ($order->tax_amount > 0) {
                $escposPrinter->text(sprintf(__('printer.tax') . " / " . __('printer.tax_en') . " (%s%%): %s Ks\n", 
                    number_format($order->tax_percentage, 0),
                    number_format($order->tax_amount, 0)
                ));
            }
            
            if ($order->discount_amount > 0) {
                $escposPrinter->text(sprintf(__('printer.discount') . " / " . __('printer.discount_en') . " (%s%%): -%s Ks\n", 
                    number_format($order->discount_percentage, 0),
                    number_format($order->discount_amount, 0)
                ));
            }
            
            if ($order->service_charge > 0) {
                $escposPrinter->text(sprintf(__('printer.service_charge') . " / " . __('printer.service_charge_en') . ": %s Ks\n", 
                    number_format($order->service_charge, 0)
                ));
            }
            
            $escposPrinter->text(str_repeat("=", 48) . "\n");
            $escposPrinter->setEmphasis(true);
            $escposPrinter->setTextSize(2, 1);
            $escposPrinter->text(sprintf(__('printer.total') . " / " . __('printer.total_en') . ": %s Ks\n", number_format($order->total, 0)));
            $escposPrinter->setTextSize(1, 1);
            $escposPrinter->setEmphasis(false);
            $escposPrinter->text(str_repeat("=", 48) . "\n");

            // Footer
            $escposPrinter->setJustification(EscposPrinter::JUSTIFY_CENTER);
            $escposPrinter->text("\n");
            $escposPrinter->text(__('printer.thank_you') . " / " . __('printer.thank_you_en') . "\n");
            $escposPrinter->text(__('printer.visit_again') . "\n");
            $escposPrinter->text(__('printer.visit_again_en') . "\n");
            $escposPrinter->text("\n");

            $escposPrinter->feed(3);
            $escposPrinter->cut();
            $escposPrinter->close();

        } catch (Exception $e) {
            logger()->error('Receipt printer error: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'printer_ip' => $printer->ip_address,
                'printer_port' => $printer->port,
            ]);
            throw new Exception('Receipt printer error: ' . $e->getMessage());
        }
    }

    /**
     * Print order to kitchen and bar based on categories
     */
    public function printOrderToKitchenAndBar(Order $order, array $newItems = null)
    {
        // Print to kitchen
        try {
            $this->printKitchenOrder($order, $newItems);
        } catch (Exception $e) {
            // Log error but don't stop the process
            logger()->error('Kitchen print failed: ' . $e->getMessage());
        }

        // Print to bar
        try {
            $this->printBarOrder($order, $newItems);
        } catch (Exception $e) {
            // Log error but don't stop the process
            logger()->error('Bar print failed: ' . $e->getMessage());
        }
    }
}
