<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'creator'])
            ->latest()
            ->paginate(15);

        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::active()->get();
        $products = Product::active()->get();
        $invoiceNumber = Purchase::generateInvoiceNumber();

        return view('purchases.create', compact('suppliers', 'products', 'invoiceNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_number' => 'required|unique:purchases,invoice_number',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.cost_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Create purchase record
            $purchase = Purchase::create([
                'supplier_id' => $validated['supplier_id'],
                'invoice_number' => $validated['invoice_number'],
                'purchase_date' => $validated['purchase_date'],
                'total_amount' => 0,
                'created_by' => Auth::id(),
            ]);

            $totalAmount = 0;

            // Create purchase items and update stock
            foreach ($validated['items'] as $item) {
                $subtotal = $item['quantity'] * $item['cost_price'];
                $totalAmount += $subtotal;

                // Create purchase item
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'cost_price' => $item['cost_price'],
                    'subtotal' => $subtotal,
                ]);

                // Update product stock
                $product = Product::find($item['product_id']);
                $product->increment('quantity', $item['quantity']);
                $product->update(['cost_price' => $item['cost_price']]);

                // Create stock log
                StockLog::create([
                    'product_id' => $item['product_id'],
                    'type' => 'in',
                    'quantity' => $item['quantity'],
                    'reference_type' => 'purchase',
                    'reference_id' => $purchase->id,
                    'created_by' => Auth::id(),
                ]);
            }

            // Update purchase total
            $purchase->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Purchase created successfully. Stock updated.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                ->withErrors(['error' => 'Purchase failed: ' . $e->getMessage()]);
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'purchaseItems.product', 'creator']);
        return view('purchases.show', compact('purchase'));
    }
}
