<?php

namespace App\Exports;

use App\Models\MstCustomer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCustomer implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $customers;
    public function __construct($customers)
    {
        $this->customers=$customers;
    }
    public function collection()
    {
        return $this->customers;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'TelNum',
            'Address',
        ];
    }
    public function columnWidths(): array
    {
        return [
            'Name' => 50,
            'Email' => 70,
            'TelNum' => 50,
            'Address' => 100,
        ];
    }
}
