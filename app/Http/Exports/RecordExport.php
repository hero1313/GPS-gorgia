<?php

namespace App\Http\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RecordExport implements FromCollection , WithHeadings , ShouldAutoSize, WithStyles
{
    protected $data;

    const LOOP_INDEX = 2;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $rows = collect();
        
        foreach ($this->data as $record) {
                
                if($record->status == 0){
                    $status = 'დაგეგმილი';
                }
                else if($record->status == 1){
                    $status = 'დასრულებული';
                }
                else if($record->status == 2){
                    $status = 'ჩაშლილი';
                }
                $rows->push([
                    'ჩექინის ID' => $record->id,
                    'ლოკაცია' => $record->location->name,
                    'დავალება' => $record->task->name,
                    'შემსრულებელი' => $record->user->name,
                    'კომენტარი' => $record->comment,
                    'სტატუსი' => $status,
                    'ჩექინი' => $record->check_in_time, 
                    'ჩექაუთი' => $record->check_out_time,
                    'თარიღი' => $record->date,
                    'პას.პირის სახელი' => $record->responsible_name,
                    'პას.პირის ნომერი' => $record->number,
                ]);
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'ჩექინის ID',
            'ლოკაცია',
            'დავალება',
            'შემსრულებელი',
            'კომენტარი',
            'სტატუსი',
            'ჩექინი',
            'ჩექაუთი',
            'თარიღი',
            'პას.პირის სახელი',
            'პას.პირის ნომერი',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply word wrapping to the 'Products' column
        $sheet->getStyle('B')->getAlignment()->setWrapText(true);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

}
