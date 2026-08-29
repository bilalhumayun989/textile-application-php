
@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: var(--primary-purple);">Welcome to Textile Management</h2>
            <p class="text-muted">Select a module to get started</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Costing Card -->
        <div class="col-md-4">
            <a href="{{ route('costing.index') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm hover-card" style="border-radius: 20px; transition: all 0.3s ease;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="icon-circle mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #7c3aed, #a855f7); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-invoice-dollar" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #1a202c;">Costing</h4>
                        <p class="text-muted text-center mb-0">Manage fabric costing and pricing calculations</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Cover Factor Card -->
        <div class="col-md-4">
            <a href="{{ route('factor.index') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm hover-card" style="border-radius: 20px; transition: all 0.3s ease;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="icon-circle mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #059669, #10b981); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-layer-group" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #1a202c;">Cover Factor</h4>
                        <p class="text-muted text-center mb-0">Calculate cover factor for fabric analysis</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Blending Ratio Card -->
        <div class="col-md-4">
            <a href="{{ route('blend.index') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm hover-card" style="border-radius: 20px; transition: all 0.3s ease;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="icon-circle mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #dc2626, #f87171); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-blender" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: #1a202c;">Blending Ratio</h4>
                        <p class="text-muted text-center mb-0">Configure fabric blending ratios</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(124, 58, 237, 0.15) !important;
    }
    
    .hover-card:hover .icon-circle {
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }
</style>
@endsection
