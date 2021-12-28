<?php

namespace App\Exports;

use App\Models\Seller;
use Maatwebsite\Excel\Concerns\FromCollection;

class SellerExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // $sellers=Seller::get();
        // $sellers->pull('HP');
        return Seller::select('HP')->get();
    }
}
