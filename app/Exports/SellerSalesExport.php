<?php

namespace App\Exports;

use App\Exports\Sheets\EventSalesDetailsSheet;
use App\Exports\Sheets\EventSalesSummarySheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SellerSalesExport implements WithMultipleSheets
{
    /**
     * @return array<int, \Maatwebsite\Excel\Concerns\FromCollection>
     */
    public function sheets(): array
    {
        return [
            new EventSalesSummarySheet(),
            new EventSalesDetailsSheet(),
        ];
    }
}
