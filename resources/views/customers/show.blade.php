@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Customer Details</h4>
                    <div>
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary btn-sm">Edit</a>
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">ID:</div>
                        <div class="col-md-9">{{ $customer->id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Name:</div>
                        <div class="col-md-9">{{ $customer->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Address:</div>
                        <div class="col-md-9">{{ $customer->address }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">GSTIN:</div>
                        <div class="col-md-9">{{ $customer->gstin ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Created At:</div>
                        <div class="col-md-9">{{ $customer->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Updated At:</div>
                        <div class="col-md-9">{{ $customer->updated_at->format('d M Y, h:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 