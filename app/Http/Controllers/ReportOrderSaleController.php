<?php

namespace App\Http\Controllers;

use App\Models\ReportOrderSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportOrderSaleController extends Controller
{
    public function index(Request $request)
    {
        $query = ReportOrderSale::query();

        // Apply search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->filterByStatus($request->status);
        }

        $orders = $query->orderBy('id', 'ASC')->paginate(15);

        // Statistics
        $totalOrders = ReportOrderSale::count();
        $shippingPaid = ReportOrderSale::where('status', 'Shipping Paid')->count();
        $pendingPayment = ReportOrderSale::where('status', 'Pending Shipping Payment')->count();
        $totalRevenue = ReportOrderSale::sum('shipping_fee');

        return view('report-order-sales.index', compact('orders', 'totalOrders', 'shippingPaid', 'pendingPayment', 'totalRevenue'));
    }

    public function create()
    {
        return view('report-order-sales.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'uid' => 'required|string|max:50',
            'customer_name' => 'required|string|max:100',
            'po_number' => 'nullable|string|max:50',
            'tracking_number' => 'nullable|string|max:100',
            'shipping_fee' => 'required|numeric|min:0',
            'status' => 'required|in:Shipping Paid,Pending Shipping Payment'
        ]);

        try {
            DB::beginTransaction();

            $validated['requested_at'] = now();

            ReportOrderSale::create($validated);

            DB::commit();

            return redirect()
                ->route('report-order-sales.index')
                ->with('success', 'បានបន្ថែម Order ថ្មីដោយជោគជ័យ!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'មិនអាចបន្ថែម Order បានទេ: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $order = ReportOrderSale::findOrFail($id);
        return view('report-order-sales.show', compact('order'));
    }

    public function edit($id)
    {
        $order = ReportOrderSale::findOrFail($id);
        return view('report-order-sales.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = ReportOrderSale::findOrFail($id);

        $validated = $request->validate([
            'uid' => 'required|string|max:50',
            'customer_name' => 'required|string|max:100',
            'po_number' => 'nullable|string|max:50',
            'tracking_number' => 'nullable|string|max:100',
            'shipping_fee' => 'required|numeric|min:0',
            'requested_at' => 'nullable|date',
            'status' => 'required|in:Shipping Paid,Pending Shipping Payment'
        ]);

        try {
            DB::beginTransaction();

            $order->update($validated);

            DB::commit();

            return redirect()
                ->route('report-order-sales.index')
                ->with('success', 'បានកែប្រែ Order ដោយជោគជ័យ!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'មិនអាចកែប្រែ Order បានទេ!');
        }
    }

    public function destroy($id)
    {
        try {
            $order = ReportOrderSale::findOrFail($id);
            $order->delete();

            return redirect()
                ->route('report-order-sales.index')
                ->with('success', 'បានលុប Order ដោយជោគជ័យ!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'មិនអាចលុប Order បានទេ!');
        }
    }

    // Export to CSV
    public function export()
    {
        $orders = ReportOrderSale::orderBy('id', 'ASC')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="orders_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            // Add headers (Khmer and English)
            fputcsv($file, ['ID', 'UID', 'ឈ្មោះអតិថិជន', 'PO លេខ', 'Tracking លេខ', 'ថ្លៃដឹកជញ្ជូន', 'កាលបរិច្ឆេទស្នើសុំ', 'ស្ថានភាព', 'បង្កើតកាលបរិច្ឆេទ', 'កែប្រែកាលបរិច្ឆេទ']);

            // Add data rows
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->uid,
                    $order->customer_name,
                    $order->po_number,
                    $order->tracking_number,
                    $order->shipping_fee,
                    $order->requested_at,
                    $order->status,
                    $order->created_at,
                    $order->updated_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
