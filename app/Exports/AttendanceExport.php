<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    protected $date_filter;
    protected $emp_id_filter;

    public function __construct($date_filter, $emp_id_filter)
    {
        $this->date_filter = $date_filter;
        $this->emp_id_filter = $emp_id_filter;
    }

    // Fetch the attendance records based on filters
    public function collection()
    {
        $query = Attendance::with('bookingDetails');
        
        if ($this->date_filter) {
            $query->where('date', $this->date_filter);
        }

        if ($this->emp_id_filter) {
            $query->where('emp_id', $this->emp_id_filter);
        }

        return $query->get();
    }

    // Define the headings for the Excel export
    public function headings(): array
    {
        $heading = [];
        
        if ($this->date_filter && $this->emp_id_filter) {
            $heading[] = "Attendance for date: {$this->date_filter} and Employee ID: {$this->emp_id_filter}";
        } elseif ($this->date_filter) {
            $heading[] = "Attendance for date: {$this->date_filter}";
        } elseif ($this->emp_id_filter) {
            $heading[] = "Attendance for Employee ID: {$this->emp_id_filter}";
        } else {
            $heading[] = "Attendance Report";
        }

        return [
            [$heading[0]], // First heading row (merged cells)
            ['No.', 'Date', 'Employee ID', 'Employee Name', 'Seat No', 'Phone Number', 'Email', 'Attendance Status'] // Updated to include "Attendance Status"
        ];
    }

    // Define the styles for the worksheet
    public function styles(Worksheet $sheet)
    {
        // Merge the first heading row
        $sheet->mergeCells('A1:H1');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(10); // No.
        $sheet->getColumnDimension('B')->setWidth(15); // Date
        $sheet->getColumnDimension('C')->setWidth(15); // Employee ID
        $sheet->getColumnDimension('D')->setWidth(30); // Employee Name
        $sheet->getColumnDimension('E')->setWidth(15); // Seat No
        $sheet->getColumnDimension('F')->setWidth(20); // Phone Number
        $sheet->getColumnDimension('G')->setWidth(30); // Email
        $sheet->getColumnDimension('H')->setWidth(20); // Attendance Status

        // Apply borders to all cells
        $rowCount = $sheet->getHighestRow(); // Get the total number of rows
        $columnCount = $sheet->getHighestColumn(); // Get the last column
        
        $sheet->getStyle('A1:' . $columnCount . $rowCount)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Style the heading row (bold and centered)
        return [
            1 => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => 'center']],
            2 => ['font' => ['bold' => true]], // Table column headers bold
            'A' => ['alignment' => ['horizontal' => 'center']], // Center align the "No." column
        ];
    }

    // Map the data to the Excel columns
    public function map($attendance): array
    {
        return [
            $attendance->id,
            $attendance->date,
            $attendance->emp_id,
            $attendance->bookingDetails->employee_name ?? 'N/A',
            $attendance->bookingDetails->seat_no ?? 'N/A',
            $attendance->bookingDetails->phone_number ?? 'N/A',
            $attendance->bookingDetails->email ?? 'N/A',
            // Display "Present" if attendance_status is 1, otherwise "Absent"
            $attendance->attendance_status == 1 ? 'Present' : 'Absent'
        ];
    }
}
