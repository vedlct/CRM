<?php

namespace App\Exports;

use App\Lead;
use App\User;
use App\Workprogress;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class fredChasingLeadsExport implements FromCollection, WithHeadings
{
    protected $leads;
    protected $wp;

    public function __construct($leads, $wp)
    {
        $this->leads = $leads;
        $this->wp = $wp;
    }

    public function collection()
    {
        $leads = $this->leads;

        $leadIds = $leads->pluck('leadId')->toArray();

        $wp = Workprogress::whereIn('leadId', $leadIds)
            ->where(function ($query) {
                $query->where('comments', 'LIKE', '%TEST%')
                    ->orWhere('comments', 'LIKE', '%CLOSED%')
                    ->orWhere('comments', 'LIKE', '%CLIENT%');
            })
            ->get();

        $leads = $leads->map(function ($lead) use ($wp) {
            $matchingComments = $wp->where('leadId', $lead->leadId)
                ->pluck('comments')
                ->filter(function ($comment) {
                    return stripos($comment, 'TEST') !== false
                        || stripos($comment, 'CLOSED') !== false
                        || stripos($comment, 'CLIENT') !== false;
                })
                ->implode(' || ');

            $lead->exclusiveComment = $matchingComments;

            return $lead;
        });

        return $leads;
    }

    public function headings(): array
    {
        return [
            'Lead Id',
            'Company Name',
            'Category',
            'Website',
            'Phone No',
            'Status',
            'Country',
            'Current Marketer',
            'No of Chase',
            'Exclusive Comment',
        ];
    }
}
