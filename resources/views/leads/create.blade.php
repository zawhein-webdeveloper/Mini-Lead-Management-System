@extends('layouts.app')

@section('title', 'Create Lead')

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
        .lead-form-card .form-control:focus,
        .lead-form-card .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.18);
        }
        .lead-form-card .form-floating > label { color: #64748b; }
        .lead-form-card .form-floating > .form-control:focus ~ label,
        .lead-form-card .form-floating > .form-control:not(:placeholder-shown) ~ label,
        .lead-form-card .form-floating > .form-select ~ label {
            color: #4f46e5;
        }
    </style>
@endsection

@section('content')
<div class="w-100 py-1">
    <div class="row justify-content-center g-3">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="card lead-form-card">
                <div class="card-header-lead d-flex align-items-center gap-2">
                    <span class="rounded-circle bg-white bg-opacity-25 d-inline-flex align-items-center justify-content-center" style="width:2.5rem;height:2.5rem;">
                        <i class="fas fa-user-plus text-white"></i>
                    </span>
                    <div>
                        <h1 class="h5 mb-0 text-white fw-semibold">Create New Lead</h1>
                        <p class="mb-0 small text-white text-opacity-75">Add contact details and pipeline status</p>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('leads.store') }}" class="lead-form">
                        @csrf

                        <div class="row g-3 g-md-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" placeholder=" " required autocomplete="name">
                                    <label for="name">Full name <span class="text-danger">*</span></label>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" placeholder=" " required autocomplete="email">
                                    <label for="email">Email address <span class="text-danger">*</span></label>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control rounded-3 @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone') }}" placeholder=" " required inputmode="numeric" autocomplete="tel">
                                    <label for="phone">Phone <span class="text-danger">*</span></label>
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select rounded-3 @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="" disabled {{ old('status') ? '' : 'selected' }}>Choose status</option>
                                        <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    @error('status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="d-flex flex-column flex-sm-row gap-2 gap-sm-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm">
                                <i class="fas fa-check me-2"></i>Create lead
                            </button>
                            <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                                <i class="fas fa-arrow-left me-2"></i>Back to list
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
@endsection
