<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'invoice_number',
        'total_amount',
        'sale_date',
        'created_by'
    ];

    protected $casts = [
        'sale_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get sale items
     */
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Get the user who created this sale
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Generate unique invoice number
     */
    public static function generateInvoiceNumber()
    {
        $prefix = 'SAL-';
        $date = date('Ymd');
        $latest = self::whereDate('created_at', today())->count() + 1;
        return $prefix . $date . '-' . str_pad($latest, 4, '0', STR_PAD_LEFT);
    }
}
