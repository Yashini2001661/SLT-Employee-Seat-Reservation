<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date_filter = $request->input('date-picker', '');  
        $emp_id_filter = $request->input('trainee-id', ''); 

        $present_trainees = [];
        $absent_trainees = [];

        // Only run the query if a filter is provided
        if (!empty($date_filter) || !empty($emp_id_filter)) {
            $query = Attendance::with('bookingDetails');

            if (!empty($date_filter)) {
                $query->where('date', $date_filter);
            }

            if (!empty($emp_id_filter)) {
                $query->where('emp_id', $emp_id_filter);
            }

            // Fetch attendance records
            $attendances = $query->get();

            // Separate present and absent trainees based on attendance status
            foreach ($attendances as $attendance) {
                if ($attendance->attendance_status == 1) {
                    $present_trainees[] = $attendance;
                } else {
                    $absent_trainees[] = $attendance;
                }
            }
        }

        // Return the view with empty fields or filtered trainees
        return view('index', compact('present_trainees', 'absent_trainees', 'date_filter', 'emp_id_filter'));
    }

    public function export(Request $request)
    {
        $date_filter = $request->input('date-picker');
        $emp_id_filter = $request->input('trainee-id');

        return Excel::download(new AttendanceExport($date_filter, $emp_id_filter), 'attendance.xlsx');
    }

    public function mark(Request $request)
    {
        $request->validate([
            'trainee_id' => 'required|exists:bookings,emp_id', 
            'date' => 'required|date',
        ]);

        return redirect()->route('attendance.index')->with('success', 'Attendance marked successfully!');
    }
}
