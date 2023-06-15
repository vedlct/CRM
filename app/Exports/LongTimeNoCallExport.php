<?php

namespace App\Exports;

use App\Lead;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class LongTimeNoCallExport implements FromCollection, WithHeadings
{
    protected $leads;

    public function __construct($leads)
    {
        $this->leads = $leads;
    }

    public function collection()
    {
        return $this->leads;
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