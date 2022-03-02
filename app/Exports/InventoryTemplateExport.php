<?php
namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class InventoryTemplateExport implements FromCollection,  WithMapping, ShouldAutoSize, WithHeadings, WithStyles, WithEvents
{
    protected $results;

    protected $index = 0;

    protected $branchId;

    function __construct($branchId)
    {
        $this->branchId = $branchId;
    }

    public function collection()
    {
        $this->results = Inventory::select('*', \DB::raw('(SELECT @row := 0)'),  \DB::raw('@row := @row + 1 AS SrNo'),)
                        ->with('branch', 'sku', 'sku.product', 'sku.details')
                        ->where('branch_id', $this->branchId)
                        ->orderBy('branch_id')->get()->sortBy('sku.product.name');

        
        return $this->results;
    }

    public function map($inventory): array
    {
       
        return [
            ++$this->index,
            $inventory->id,
            $inventory->branch->name,
            $inventory->sku->product->name . "(" . $inventory->sku->details->title . ")",
            $inventory->quantity
        ];
    }

    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->freezePane('B2');
                // $event->sheet->protectCells('A1', 'PHP');

                // $event->sheet->getProtection()->protectCells('A1', 'PHP');
                // $event->sheet->getStyle('B1')->getProtection()->setHidden("A1");
                // $event->sheet->getStyle('B1')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                // $event->sheet->getStyle('A1')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);




                // get layout counts (add 1 to rows for heading row)
                $row_count = $this->results->count() + 1;
                $column_count = count($this->results[0]->toArray());

                // set dropdown column
                $drop_column = 'A';

                // set dropdown options
                $options = [
                    'option 1',
                    'option 2',
                    'option 3',
                ];
                

                // set dropdown list for first data row
                $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();

                // dd($event->sheet->getCell("{$drop_column}2")->getValue());
                $options = [
                    $event->sheet->getCell("{$drop_column}2")->getValue()
                ];

                $validation->setType(DataValidation::TYPE_LIST );
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                // $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input error');
                // $validation->setError('Value is not in list.');
                // $validation->setPromptTitle('Pick from list');
                // $validation->setPrompt('Please pick a value from the drop-down list.');
                // $validation->setFormula1(sprintf('"%s"',implode(',',$options)));
                
                
                // clone validation to remaining rows
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                }

                // $event->sheet->freezeFirstRow();

                // set columns to autosize
                for ($i = 1; $i <= $column_count; $i++) {
                    $column = Coordinate::stringFromColumnIndex($i);
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
    
    public function headings(): array
    {
        return [
            'Index',
            'unique_id',
            'Branch Name',
            'SKU name',
            'Current Stock',
            'New Stock'
        ];
    }

    public function styles(Worksheet $sheet) : array
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }

}