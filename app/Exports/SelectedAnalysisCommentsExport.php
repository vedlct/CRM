<?php

namespace App\Exports;

use App\Lead;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class SelectedAnalysisCommentsExport implements FromCollection, WithHeadings
{
    protected $analysis;

    public function __construct($analysis)
    {
        $this->analysis = $analysis;
    }

    public function collection()
    {
        return $this->analysis;
    }

    public function headings(): array
    {
        return [
            'Lead Id',
            'Company Name',
            'Category',
            'Website',
            'Status',
            'Country',
            'User',
        ];
    }
}