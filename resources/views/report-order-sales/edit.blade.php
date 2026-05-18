@extends('layouts.app')

@section('title', 'Edit Order')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="mb-0">Edit Order Sale</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('report-order-sales.update', $order->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="uid" class="form-label">UID</label>
                        <input type="text" class="form-control @error('uid') is-invalid @enderror" 
                               id="uid" name="uid" value="{{ old('uid', $order->uid) }}">
                        @error('uid')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Customer Name</label>
                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                               id="customer_name" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}">
                        @error('customer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="po_number" class="form-label">PO Number</label>
                            <input type="text" class="form-control @error('po_number') is-invalid @enderror" 
                                   id="po_number" name="po_number" value="{{ old('po_number', $order->po_number) }}">
                            @error('po_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tracking_number" class="form-label">Tracking Number</label>
                            <input type="text" class="form-control @error('tracking_number') is-invalid @enderror" 
                                   id="tracking_number" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}">
                            @error('tracking_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="shipping_fee" class="form-label">Shipping Fee ($)</label>
                            <input type="number" step="0.01" class="form-control @error('shipping_fee') is-invalid @enderror" 
                                   id="shipping_fee" name="shipping_fee" value="{{ old('shipping_fee', $order->shipping_fee) }}">
                            @error('shipping_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="requested_at" class="form-label">Requested At</label>
                            <input type="datetime-local" class="form-control @error('requested_at') is-invalid @enderror" 
                                   id="requested_at" name="requested_at" 
                                   value="{{ old('requested_at', $order->requested_at ? date('Y-m-d\TH:i', strtotime($order->requested_at)) : '') }}">
                            @error('requested_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status">
                                <option value="Pending Shipping Payment" {{ old('status', $order->status) == 'Pending Shipping Payment' ? 'selected' : '' }}>
                                    Pending Shipping Payment
                                </option>
                                <option value="Shipping Paid" {{ old('status', $order->status) == 'Shipping Paid' ? 'selected' : '' }}>
                                    Shipping Paid
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('report-order-sales.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection