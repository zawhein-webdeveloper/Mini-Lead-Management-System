<?php

namespace App\Http\Controllers;

use App\Exports\LeadsExport;
use App\Http\Requests\CreateRequestForm;
use App\Http\Requests\UpdatedRequestForm;
use App\Models\Lead;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LeadController extends Controller
{
    public function index()
    {
        return view('leads.index');
    }

    public function data(Request $request)
    {
        $query = Lead::query()->select([
            'id',
            'name',
            'email',
            'phone',
            'status',
            'created_at',
        ]);

        if ($request->filled('status_filter')) {
            $query->where('status', $request->string('status_filter'));
        }

        return DataTables::eloquent($query)
            ->editColumn('status', function (Lead $lead) {
                $label = ucfirst(str_replace('_', ' ', $lead->status));
                $class = match ($lead->status) {
                    'new' => 'bg-success',
                    'in_progress' => 'bg-warning text-dark',
                    'closed' => 'bg-danger',
                    default => 'bg-secondary',
                };

                return '<span class="badge '.$class.'">'.$label.'</span>';
            })
            ->editColumn('created_at', fn (Lead $lead) => $lead->created_at->format('M d, Y H:i'))
            ->addColumn('action', function (Lead $lead) {
                $show = route('leads.show', $lead);
                $edit = route('leads.edit', $lead);
                $destroy = route('leads.destroy', $lead);
                $token = csrf_token();

                return '<div class="btn-group flex-wrap" role="group">'
                    .'<a href="'.e($show).'" class="btn btn-sm btn-outline-info" title="View"><i class="fas fa-eye"></i></a>'
                    .'<a href="'.e($edit).'" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>'
                    .'<form action="'.e($destroy).'" method="POST" class="d-inline" onsubmit="return confirm(\'Delete this lead?\');">'
                    .'<input type="hidden" name="_token" value="'.e($token).'">'
                    .'<input type="hidden" name="_method" value="DELETE">'
                    .'<button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>'
                    .'</form></div>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(CreateRequestForm $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        Lead::create($data);

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    public function show(Lead $lead)
    {
        return view('leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        return view('leads.edit', compact('lead'));
    }

    public function update(UpdatedRequestForm $request, Lead $lead)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::id();

        $lead->update($data);

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        $status = $request->get('status');

        $query = Lead::query();

        if ($status) {
            $query->where('status', $status);
        }

        $leads = $query->get();

        switch ($format) {
            case 'excel':
                return Excel::download(new LeadsExport($leads), 'leads.xlsx');
            case 'pdf':
                $pdf = Pdf::loadView('leads.export_pdf', compact('leads'));

                return $pdf->download('leads.pdf');
            default:
                return $this->exportCsv($leads);
        }
    }

    private function exportCsv($leads)
    {
        $filename = 'leads_'.date('Y-m-d_H-i-s').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($leads) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Status', 'Created At']);

            foreach ($leads as $lead) {
                fputcsv($handle, [
                    $lead->id,
                    $lead->name,
                    $lead->email,
                    $lead->phone,
                    ucfirst(str_replace('_', ' ', $lead->status)),
                    $lead->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
