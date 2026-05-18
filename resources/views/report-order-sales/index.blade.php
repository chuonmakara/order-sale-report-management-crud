@extends('layouts.app')

@section('title', 'បញ្ជី Order Sale')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-shopping-cart me-2"></i> Order Sale - List
        </h5>
        <div>
            <a href="{{ route('report-order-sales.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Order
            </a>
            <a href="{{ route('report-order-sales.export') }}" class="btn btn-success btn-sm">
                <i class="fas fa-download"></i> Download CSV
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-2">Total Order</h6>
                            <h3 class="mb-0">{{ $totalOrders }}</h3>
                        </div>
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-2">Shipping Paid</h6>
                            <h3 class="mb-0">{{ $shippingPaid }}</h3>
                        </div>
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-2">Pending Payment</h6>
                            <h3 class="mb-0">{{ $pendingPayment }}</h3>
                        </div>
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-2">Amount:</h6>
                            <h3 class="mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                        </div>
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- DataTable will handle search - no need for manual filter form -->
        <div class="table-responsive">
            <table id="orderTable" class="table table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>UID</th>
                        <th>Name</th>
                        <th>PO Number</th>
                        <th>Tracking Number</th>
                        <th>Shipping Fee</th>
                        <th>Requested At</th>
                        <th>Updated Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $order->uid }}</strong></td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->po_number ?? '-' }}</td>
                        <td>{{ $order->tracking_number ?? '-' }}</td>
                        <td>${{ number_format($order->shipping_fee, 2) }}</td>
                        <td>{{ date('d/m/Y H:i A', strtotime($order->requested_at)) }}</td>
                        <td>{{ $order->updated_at ? date('d/m/Y H:i A', strtotime($order->updated_at)) : '-' }}</td>
                        <td>
                            @if($order->status == 'Shipping Paid')
                                <span class="badge bg-success">Shipping Paid</span>
                            @else
                                <span class="badge bg-warning">Pending Payment</span>
                            @endif
                         </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('report-order-sales.edit', $order->id) }}"
                                    class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('report-order-sales.destroy', $order->id) }}"
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                         </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#orderTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [10, 25, 50, 100],
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "paginate": {
                    "previous": "Previous",
                    "next": "Next"
                },
                "zeroRecords": "No data available in table"
            },
            "order": [[0, 'asc']]  // Sort by No. column
        });
    });
</script>
@endpush