<?php

namespace App\Exports;

use App\Models\ClientData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ClientData::all()->map(function ($client) {
            return [
                $client->id,
                $client->first_name . ' ' . $client->last_name, // Combine first and last names
                $client->email,
                $client->phone_number,
                $client->company_name,
                $client->address,
            ];
        });
    }
    public function headings(): array
    {
        return [
            '#',
            'Full Name', // Update heading to "Full Name"
            'Email',
            'Phone Number',
            'Company Name',
            'Address',
        ];
    }
}
