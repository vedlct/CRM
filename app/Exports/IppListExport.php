<?php

namespace App\Exports;

use App\Lead;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class IppListExport implements FromCollection, WithHeadings
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
            'Country',
            'Phone No',
            'Process',
            'Volume',
            'Frequency',
            'Marketer',
            'Last Update',
        ];
    }
}