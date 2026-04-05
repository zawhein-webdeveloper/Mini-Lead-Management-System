<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadsExport implements FromCollection, WithHeadings
{
    protected $leads;

    public function __construct($leads = null)
    {
        $this->leads = $leads ?: Lead::all();
    }

    public function collection()
    {
        return $this->leads->map(function ($lead) {
            return [
                'ID' => $lead->id,
                'Name' => $lead->name,
                'Email' => $lead->email,
                'Phone' => $lead->phone,
                'Status' => ucfirst(str_replace('_', ' ', $lead->status)),
                'Created At' => $lead->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Status',
            'Created At',
        ];
    }
}
