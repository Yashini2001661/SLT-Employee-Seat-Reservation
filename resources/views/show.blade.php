<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Attendance Management</title>
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        /* Style for the alert box */
        .alert-box {
            padding: 15px;
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin: 10px 0;
            display: none; /* Hidden by default */
        }

        .alert-success {
            border-color: #4CAF50;
            background-color: #dff0d8;
            color: #3c763d;
        }

        .alert-error {
            border-color: #f44336;
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>

<div class="container">
    <aside class="sidebar-alt">
        <div class="sidebar-header">
            <div class="navbar-logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="SLT Logo" />
            </div>
            <h2>Dashboard</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.show') }}"><i class="fa-solid fa-calendar-check"></i> Mark Attendance</a></li>
            <li><a href="{{ route('attendance.index') }}"><i class="fa-solid fa-eye"></i> View Attendance</a></li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </aside>

   

<main class="admin-panel">
     <!-- Alert box section just below the navigation bar -->
    <div id="alert-box" class="alert-box"></div>
    <h1 class="centered-heading">Booking Details & Attendance Mark</h1>

    <form method="GET" action="{{ route('admin.show') }}">
        <div class="date-selection centered-date-selection">
            <label for="date">Select Date:</label>
            <input type="date" id="date" name="date" value="{{ $date }}" required onchange="this.form.submit()" />
        </div>
    </form>

    <form method="POST" action="{{ route('admin.store') }}">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}" />
        <table class="reservation-table fixed-size">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Seat No</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Attendance</th>
                </tr>
            </thead>
            <tbody>
                @if($bookings->isEmpty())
                    <tr>
                        <td colspan="8">No bookings found for the selected date.</td>
                    </tr>
                @else
                    @foreach($bookings as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $booking->date }}</td>
                            <td>{{ $booking->emp_id }}</td>
                            <td>{{ $booking->employee_name }}</td>
                            <td>{{ $booking->seat_no }}</td>
                            <td>{{ $booking->phone_number }}</td>
                            <td>{{ $booking->email }}</td>
                            <td>
                            
                            <input type="checkbox" name="attendance[{{ $booking->id }}]" value="1" {{ $booking->attendance_status == 1 ? 'checked' : '' }} />

                            </td>

                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="button-container">
            <div class="save-attendance">
                <form method="POST" action="{{ route('admin.store') }}">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}" />
                    <button type="submit" class="btn">Save Attendance</button>
                </form>
            </div>
            <div class="print">
                <form method="POST" action="{{ route('admin.download.excel') }}">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}" />
                    <button type="submit" class="btn">Download Booking Details</button>
                </form>
            </div>
        </div>

</main>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        @if(session('success'))
            displayAlert('success', "{{ session('success') }}");
        @endif

        
        @if($errors->any())
            let errorMessage = "";
            @foreach ($errors->all() as $error)
                errorMessage += "{{ $error }}\n";
            @endforeach
            displayAlert('error', errorMessage.trim());
        @endif
    });

    
    function displayAlert(type, message) {
        const alertBox = document.getElementById('alert-box');
        alertBox.style.display = 'block';
        alertBox.classList.add(type === 'success' ? 'alert-success' : 'alert-error');
        alertBox.innerText = message;

        
        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 5000);
    }
</script>
</body>
</html>
