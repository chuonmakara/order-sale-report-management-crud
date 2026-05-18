<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportOrderSale extends Model
{
    use HasFactory;

    protected $table = 'report_order_sales'; 

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'uid',
        'customer_name',
        'po_number',
        'tracking_number',
        'shipping_fee',
        'requested_at',
        'status'
    ];

    protected $casts = [
        'shipping_fee' => 'decimal:2',
        'requested_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getFormattedShippingFeeAttribute()
    {
        return '$' . number_format($this->shipping_fee, 2);
    }

    public function getFormattedRequestedAtAttribute()
    {
        return $this->requested_at ? date('d/m/Y H:i A', strtotime($this->requested_at)) : '-';
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? date('d/m/Y H:i A', strtotime($this->created_at)) : '-';
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at ? date('d/m/Y H:i A', strtotime($this->updated_at)) : '-';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status === 'Shipping Paid' ? 'bg-success' : 'bg-warning';
    }

    public function getStatusTextKhmerAttribute()
    {
        return $this->status === 'Shipping Paid' ? 'បានបង់ថ្លៃដឹកជញ្ជូន' : 'កំពុងរង់ចាំបង់ប្រាក់';
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('uid', 'like', "%{$search}%")
                     ->orWhere('customer_name', 'like', "%{$search}%")
                     ->orWhere('po_number', 'like', "%{$search}%");
    }

    public function scopeFilterByStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }
}
