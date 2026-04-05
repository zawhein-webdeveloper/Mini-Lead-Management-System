@extends('layouts.app')

@section('title', 'Leads Management')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" />
    <style>
        /* Toolbar: Filter by status (left), actions (right) */
        .leads-toolbar {
            width: 100%;
        }
        .leads-toolbar-filter {
            flex: 0 1 auto;
            min-width: 0;
        }
        .leads-toolbar-actions {
            flex: 0 0 auto;
        }
        #status_filter {
            width: 7.75rem;
            max-width: 100%;
            padding-left: 0.4rem;
            padding-right: 1.75rem;
        }
        @media (max-width: 575.98px) {
            .leads-toolbar {
                row-gap: 0.5rem !important;
            }
            .leads-toolbar-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }
        #leads-table_wrapper { padding: 0.25rem 0.125rem; }
        @media (min-width: 576px) {
            #leads-table_wrapper { padding: 0.5rem 0.35rem; }
        }
        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_filter { padding: 0.25rem 0; }
        @media (max-width: 575.98px) {
            div.dataTables_wrapper div.dataTables_length,
            div.dataTables_wrapper div.dataTables_filter { text-align: left; }
            div.dataTables_wrapper div.dataTables_filter input { max-width: 100%; margin-left: 0 !important; }
        }
        /* Top row: Show entries left, Search right */
        #leads-table_wrapper > .row:first-child .dataTables_length,
        #leads-table_wrapper > .row:first-child .dataTables_filter {
            float: none !important;
        }
        #leads-table_wrapper > .row:first-child .dataTables_length {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: flex-start;
        }
        #leads-table_wrapper > .row:first-child .dataTables_filter {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-left: 0 !important;
        }
        @media (max-width: 575.98px) {
            #leads-table_wrapper > .row:first-child .dataTables_filter {
                justify-content: flex-start;
            }
        }
        #leads-table_wrapper .dataTables_length {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        #leads-table_wrapper .dataTables_filter {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: 0 !important;
        }
        #leads-table_wrapper .dataTables_filter label,
        #leads-table_wrapper .dataTables_length label {
            margin-bottom: 0;
        }
        #leads-table_wrapper .dataTables_paginate {
            text-align: right;
            margin: 0 !important;
        }
        #leads-table_wrapper .dataTables_paginate ul.pagination {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            gap: 0.35rem;
            justify-content: flex-end;
            align-items: center;
            margin: 0;
            padding-left: 0;
            list-style: none;
        }
        /* Compact navbar style for DataTables control rows */
        #leads-table_wrapper > .row:first-child,
        #leads-table_wrapper > .row:last-child {
            background: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 0.25rem 0.6rem rgba(2,6,23,0.06);
            padding: 0.45rem 0.6rem;
            margin: 0.35rem 0 0.6rem;
            align-items: center;
        }
        /* Tighten spacing inside controls */
        #leads-table_wrapper .dataTables_length,
        #leads-table_wrapper .dataTables_filter {
            padding: 0 0.35rem;
            margin: 0;
        }
        #leads-table_wrapper .dataTables_filter input {
            max-width: 18rem;
        }

        /* Responsive behaviour: stack on very small screens but keep Search aligned right */
        @media (max-width: 575.98px) {
            #leads-table_wrapper > .row:first-child,
            #leads-table_wrapper > .row:last-child {
                display: flex;
                flex-direction: column;
                gap: 0.35rem;
                padding: 0.5rem;
            }
            #leads-table_wrapper .dataTables_filter {
                order: 2;
                margin-left: 0 !important;
                justify-content: flex-end;
                width: 100%;
            }
            #leads-table_wrapper .dataTables_length {
                order: 1;
                width: 100%;
            }
            #leads-table_wrapper .dataTables_info,
            #leads-table_wrapper .dataTables_paginate { width: 100%; }
            #leads-table_wrapper .dataTables_paginate ul.pagination { justify-content: center !important; }
        }
        #leads-table_wrapper .dataTables_paginate ul.pagination .page-item {
            display: inline-flex;
        }
        #leads-table_wrapper .dataTables_paginate ul.pagination .page-link {
            display: inline-flex;
            align-items: center;
            min-height: 2.25rem;
            white-space: nowrap;
        }
        #leads-table_wrapper .dataTables_info {
            padding-top: 0.35rem;
        }
        /* Bottom row: info left; pagination right */
        #leads-table_wrapper > .row:last-child {
            align-items: center;
        }
        /* Keep Prev/Next visible even on narrow widths */
        #leads-table_wrapper .dataTables_paginate .page-item.previous,
        #leads-table_wrapper .dataTables_paginate .page-item.next,
        #leads-table_wrapper .dataTables_paginate .paginate_button.previous,
        #leads-table_wrapper .dataTables_paginate .paginate_button.next {
            flex: 0 0 auto !important;
        }
    </style>
@endsection

@section('content')
<div class=" py-1">
    <div class="card shadow-sm">
        <div class="card-body p-3 p-sm-4">
            {{-- <h1 class="h5 mb-3 mb-sm-4">Leads Management</h1> --}}

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="leads-toolbar d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                <div class="leads-toolbar-filter d-flex align-items-center gap-2">
                    <label for="status_filter" class="form-label small text-muted mb-0 text-nowrap">
                        Filter by status
                    </label>
                    <select id="status_filter" class="form-select form-select-sm" aria-label="Filter leads by status">
                        <option value="">All status</option>
                        <option value="new">New</option>
                        <option value="in_progress">In Progress</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <div class="leads-toolbar-actions d-flex align-items-center gap-2 flex-shrink-0">
                    <a href="{{ route('leads.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Lead
                    </a>
                    <a id="export-link-excel" href="{{ route('leads.export', ['format' => 'excel']) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-file-excel"></i> Excel
                    </a>
                    <a id="export-link-csv" href="{{ route('leads.export', ['format' => 'csv']) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-file-csv"></i> CSV
                    </a>
                    <a id="export-link-pdf" href="{{ route('leads.export', ['format' => 'pdf']) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>
                </div>
            </div>
            <div class="table-responsive rounded border px-1 px-sm-2 py-2">
                <table class="table table-striped table-hover table-sm w-100 mb-0" id="leads-table" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="text-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script>
(function () {
    const exportBase = @json(url('leads-export'));

    function syncExportLinks() {
        const status = document.getElementById('status_filter').value;
        const q = status ? ('&status=' + encodeURIComponent(status)) : '';
        ['csv', 'excel', 'pdf'].forEach(function (fmt) {
            const id = fmt === 'excel' ? 'export-link-excel' : ('export-link-' + fmt);
            const el = document.getElementById(id);
            if (el) {
                el.href = exportBase + '?format=' + fmt + q;
            }
        });
    }

    document.getElementById('status_filter').addEventListener('change', function () {
        syncExportLinks();
        if (window.leadsDataTable) {
            window.leadsDataTable.ajax.reload();
        }
    });

    syncExportLinks();

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
    });

    window.leadsDataTable = $('#leads-table').DataTable({
        dom:
            '<"row mb-1 align-items-center gy-2"<"col-12 col-sm-6"l><"col-12 col-sm-6"f>>' +
            '<"row"<"col-12"rt>>' +
            '<"row align-items-center mt-2"<"col-12 col-md-5"i><"col-12 col-md-7"p>>',
        processing: true,
        serverSide: true,
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        order: [[5, 'desc']],
        ajax: {
            url: @json(route('leads.data')),
            type: 'POST',
            data: function (d) {
                d._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                d.status_filter = document.getElementById('status_filter').value;
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'status', name: 'status', orderable: true, searchable: true },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            paginate: {
                first: '«',
                last: '»',
                next: 'Next',
                previous: 'Previous'
            }
        }
    });
})();
</script>
@endsection
