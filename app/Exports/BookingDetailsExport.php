<?php

namespace App\Exports;

use App\Models\BookingDetail;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BookingDetailsExport implements WithEvents
{
    protected $date;

    // Define the table headings in a variable
    protected $headings = [
        'Employee ID',
        'Employee Name',
        'Seat No',
        'Phone Number',
        'Email',
    ];

    public function __construct($date)
    {
        $this->date = $date;
    }

    // Register events for custom data, styling, and column width
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Add the title "Booking Details for {{ $date }}" to the first row
                $sheet->setCellValue('A1', 'Booking Details for ' . $this->date);

                // Merge cells A1 to D1 for the title
                $sheet->mergeCells('A1:E1');

                // Style the title (bold, center alignment, larger font size)
                $sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Set the headings manually
                $sheet->fromArray($this->headings, null, 'A2', false, false);

                // Style the headings (A2:D2)
                $sheet->getStyle('A2:E2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Retrieve and set the collection data
                $bookingDetails = BookingDetail::where('date', $this->date)
                    ->get(['emp_id', 'employee_name', 'seat_no', 'phone_number', 'email'])
                    ->toArray();

                // Set data from row 3 onwards
                $sheet->fromArray($bookingDetails, null, 'A3', false, false);

                // Count the number of rows (to apply border style correctly)
                $rowCount = count($bookingDetails) + 2; // Including headings

                // Add borders to all the data rows (starting from A3 onwards)
                $sheet->getStyle('A3:E' . ($rowCount + 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Adjust column widths
                $sheet->getColumnDimension('A')->setWidth(15); // Employee ID
                $sheet->getColumnDimension('B')->setWidth(25); // Employee Name
                $sheet->getColumnDimension('C')->setWidth(15); // Seat No
                $sheet->getColumnDimension('D')->setWidth(20); // Phone Number
                $sheet->getColumnDimension('E')->setWidth(30); // Phone Number

                // Optionally, you can set auto-size (but it cannot be mixed with fixed-width in PhpSpreadsheet)
                // $sheet->getColumnDimension('B')->setAutoSize(true);
            },
        ];
    }
}
