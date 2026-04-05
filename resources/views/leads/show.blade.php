@extends('layouts.app')

@section('title', 'Lead Details')

@section('content')
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .lead-form-card { border: none; border-radius: 1rem; overflow: hidden; box-shadow: 0 0.5rem 1.5rem rgba(15, 23, 42, 0.08); }
        .lead-form-card .card-header-lead {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 45%, #7c3aed 100%);
            color: #fff;
            border: none;
            padding: 1.25rem 1.5rem;
        }
        .lead-details-box { background: #fff; border-radius: .5rem; padding: 1rem; border: 1px solid rgba(15,23,42,0.04); }
        .lead-details-box h5 { margin-bottom: .75rem; }
        .lead-details-box p { margin-bottom: .5rem; }
    </style>
@endsection

<div class="w-100 py-1">
    <div class="row justify-content-center g-3">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="card lead-form-card">
                <div class="card-header-lead d-flex align-items-center gap-2">
                    <span class="rounded-circle bg-white bg-opacity-25 d-inline-flex align-items-center justify-content-center" style="width:2.5rem;height:2.5rem;">
                        <i class="fas fa-id-card text-white"></i>
                    </span>
                    <div class="flex-grow-1">
                        <h1 class="h5 mb-0 text-white fw-semibold">Lead Details</h1>
                        <p class="mb-0 small text-white text-opacity-75">View contact details and status</p>
                    </div>
                    <div>
                        <a href="{{ route('leads.edit', $lead) }}" class="btn btn-light btn-sm rounded-pill me-2">
                            <i class="fas fa-pen-to-square me-1"></i>Edit
                        </a>
                        <a href="{{ route('leads.index') }}" class="btn btn-outline-light btn-sm rounded-pill">
                            <i class="fas fa-arrow-left me-1"></i>Back
                        </a>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div class="lead-details-box">
                        <h5 class="mb-3">{{ $lead->name }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="fas fa-envelope text-primary me-2"></i>Email:</strong><br>
                                    {{ $lead->email }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="fas fa-phone text-success me-2"></i>Phone:</strong><br>
                                    {{ $lead->phone }}
                                </p>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="fas fa-info-circle text-info me-2"></i>Status:</strong><br>
                                    <span class="badge
                                        @if($lead->status == 'new') bg-success
                                        @elseif($lead->status == 'in_progress') bg-warning text-dark
                                        @elseif($lead->status == 'closed') bg-danger
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="fas fa-calendar text-secondary me-2"></i>Created:</strong><br>
                                    {{ $lead->created_at->format('M d, Y \a\t H:i') }}
                                </p>
                            </div>
                        </div>

                        @if($lead->updated_at != $lead->created_at)
                        <div class="row mt-2">
                            <div class="col-12">
                                <p class="mb-0">
                                    <strong><i class="fas fa-clock text-muted me-2"></i>Last Updated:</strong><br>
                                    {{ $lead->updated_at->format('M d, Y \a\t H:i') }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
