<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('creator')
            ->latest()
            ->paginate(15);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::active()->where('quantity', '>', 0)->get();
        $invoiceNumber = Sale::generateInvoiceNumber();

        return view('sales.create', compact('products', 'invoiceNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'invoice_number' => 'required|unique:sales,invoice_number',
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.selling_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Validate stock availability
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                if ($product->quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}. Available: {$product->quantity}");
                }
            }

            // Create sale record
            $sale = Sale::create([
                'customer_name' => $validated['customer_name'],
                'invoice_number' => $validated['invoice_number'],
                'sale_date' => $validated['sale_date'],
                'total_amount' => 0,
                'created_by' => Auth::id(),
            ]);

            $totalAmount = 0;

            // Create sale items and update stock
            foreach ($validated['items'] as $item) {
                $subtotal = $item['quantity'] * $item['selling_price'];
                $totalAmount += $subtotal;

                // Create sale item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'selling_price' => $item['selling_price'],
                    'subtotal' => $subtotal,
                ]);

                // Update product stock (decrease)
                $product = Product::find($item['product_id']);
                $product->decrement('quantity', $item['quantity']);

                // Create stock log
                StockLog::create([
                    'product_id' => $item['product_id'],
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'reference_type' => 'sale',
                    'reference_id' => $sale->id,
                    'created_by' => Auth::id(),
                ]);
            }

            // Update sale total
            $sale->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Sale created successfully. Stock updated.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                ->withErrors(['error' => 'Sale failed: ' . $e->getMessage()]);
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['saleItems.product', 'creator']);
        return view('sales.show', compact('sale'));
    }
}
