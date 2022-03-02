<?php

namespace App\Imports;

use App\Models\Inventory;
use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class InventoryImport implements ToCollection, WithHeadingRow, WithValidation
{

    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach ($rows as $row) 
        {   
            Inventory::where('id', $row['unique_id'])->update(['quantity' => $row['new_stock'] ] ); 
        }
    }

    public function rules(): array
    {
        return [
            'new_stock' => ['required', 'numeric', 'bail'],
            
             // Above is alias for as it always validates in batches
            //  '*.new_stock' => Rule::in(['patrick@maatwebsite.nl']),
        ];
    }
}
