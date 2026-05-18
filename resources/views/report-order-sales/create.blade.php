@extends('layouts.app')
@section('title', 'Add New Order')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h4 class="mb-0">
                    <i class="fas fa-plus-circle"></i> Add New Order
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('report-order-sales.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="uid" class="form-label">UID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('uid') is-invalid @enderror" 
                               id="uid" name="uid" value="{{ old('uid') }}" required>
                        @error('uid')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                               id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                        @error('customer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="po_number" class="form-label">PO Number</label>
                        <input type="text" class="form-control @error('po_number') is-invalid @enderror" 
                               id="po_number" name="po_number" value="{{ old('po_number') }}">
                        @error('po_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="tracking_number" class="form-label">Tracking Number</label>
                        <input type="text" class="form-control @error('tracking_number') is-invalid @enderror" 
                               id="tracking_number" name="tracking_number" value="{{ old('tracking_number') }}">
                        @error('tracking_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="shipping_fee" class="form-label">Shipping Fee ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('shipping_fee') is-invalid @enderror" 
                               id="shipping_fee" name="shipping_fee" value="{{ old('shipping_fee', 0.00) }}" required>
                        @error('shipping_fee')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="Pending Shipping Payment" {{ old('status') == 'Pending Shipping Payment' ? 'selected' : '' }}>
                                Pending Shipping Payment
                            </option>
                            <option value="Shipping Paid" {{ old('status') == 'Shipping Paid' ? 'selected' : '' }}>
                                Shipping Paid
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('report-order-sales.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection