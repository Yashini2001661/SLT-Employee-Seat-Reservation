<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\BookingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel; // Import the Excel facade
use App\Exports\BookingDetailsExport; // Import your export class


class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin-login');
    }

public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $username = $request->input('username');
    $password = $request->input('password');

    // Retrieve admin from the database
    $admin = DB::table('admin')->where('username', $username)->first();

    if ($admin && Hash::check($password, $admin->password)) {
        // Authentication successful, store session and redirect
        Session::put('admin_username', $username);
        return redirect()->route('admin.show');
    } else {
        // Authentication failed
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
}

      public function logout(Request $request)
   {
         
        $request->session()->flush(); 
        
        
        return redirect()->route('admin-login')->with('success', 'Successfully logged out.');
    }

    public function show(Request $request)
    {
        $date = $request->input('date') ?? now()->toDateString();
    
        $bookings = BookingDetail::leftJoin('attendance', function ($join) use ($date) {
            $join->on('booking_details.emp_id', '=', 'attendance.emp_id')
                 ->where('attendance.date', '=', $date);
        })
        ->select('booking_details.*', 'attendance.attendance_status')
        ->where('booking_details.date', $date)
        ->get();
    
        // Update this line
        return view('show', compact('bookings', 'date'));
    }
    
    public function store(Request $request)
    {
        $date = $request->input('date');
        $attendance = $request->input('attendance', []); 
    
        
        $bookings = BookingDetail::where('date', $date)->get();
    
      
        foreach ($bookings as $booking) {
            
            $isPresent = isset($attendance[$booking->id]) && $attendance[$booking->id] == '1' ? 1 : 0;
    
           
            $existingAttendance = Attendance::where('emp_id', $booking->emp_id)
                                             ->where('date', $date)
                                             ->first();
    
            if ($existingAttendance) {
               
                $existingAttendance->attendance_status = $isPresent;
                $existingAttendance->seat_no = $booking->seat_no; 
                $existingAttendance->updated_at = now(); 
                $existingAttendance->save();
            } else {
                
                Attendance::create([
                    'emp_id' => $booking->emp_id,
                    'date' => $date,
                    'attendance_status' => $isPresent, 
                    'seat_no' => $booking->seat_no,
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'Attendance saved successfully.');
    }

        public function downloadExcel(Request $request)
    {
        $date = $request->input('date'); // Get the date from the request
        return Excel::download(new BookingDetailsExport($date), 'booking_details_' . $date . '.xlsx');
    }   


    }
    
