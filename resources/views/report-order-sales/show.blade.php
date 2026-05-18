@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="mb-0">
                    <i class="fas fa-info-circle"></i> Order Details
                </h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Order ID:</div>
                    <div class="col-md-8">#{{ $order->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">UID:</div>
                    <div class="col-md-8">{{ $order->uid }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Customer Name:</div>
                    <div class="col-md-8">{{ $order->customer_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">PO Number:</div>
                    <div class="col-md-8">{{ $order->po_number ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tracking Number:</div>
                    <div class="col-md-8">{{ $order->tracking_number ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Shipping Fee:</div>
                    <div class="col-md-8">{{ $order->formatted_shipping_fee }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Requested At:</div>
                    <div class="col-md-8">{{ $order->formatted_requested_at }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Updated At:</div>
                    <div class="col-md-8">{{ $order->formatted_updated_at }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status:</div>
                    <div class="col-md-8">
                        <span class="badge {{ $order->status_badge }}">{{ $order->status }}</span>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('report-order-sales.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    <div>
                        <a href="{{ route('report-order-sales.edit', $order) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection