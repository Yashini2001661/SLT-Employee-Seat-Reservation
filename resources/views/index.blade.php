<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance - Employees Seat Reservation System</title>
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css?v=1.0') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script>
        function clearFieldsAndTable() {
            
            document.getElementById('date-picker').value = '';
            document.getElementById('trainee-id').value = '';

            
            const presentTableBody = document.getElementById('present-trainees').getElementsByTagName('tbody')[0];
            presentTableBody.innerHTML = '<tr><td colspan="7">No present trainees found.</td></tr>';

            
            const absentTableBody = document.getElementById('absent-trainees').getElementsByTagName('tbody')[0];
            absentTableBody.innerHTML = '<tr><td colspan="7">No absent trainees found.</td></tr>';
        }
    </script>
</head>
<body>

<div class="container">
    <aside class="sidebar-alt">
        <div class="navbar-logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="SLT Logo" />
        </div>
        <div class="sidebar-header">
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
        <h1 class="centered-heading">View Attendance</h1>
        <form method="GET" action="{{ route('attendance.index') }}">
            @csrf
            <div class="filter-controls">
                <div class="filter-items">
                    <div class="filter-item-1">
                        <label for="date-picker">Date:</label>
                        <input type="date" id="date-picker" name="date-picker" value="{{ old('date-picker', $date_filter) }}" />
                    </div>
                    <div class="filter-item-2">
                        <label for="trainee-id">Trainee ID:</label>
                        <input type="text" id="trainee-id" name="trainee-id" value="{{ old('trainee-id', $emp_id_filter) }}" />
                    </div>
                </div>
                <div class="filter-buttons">
                    <button type="submit" class="btn">Search</button>
                    <button type="button" class="btn" onclick="clearFieldsAndTable()">Clear</button>
                </div>
            </div>
        </form>
        <div class="print" style="margin-top: 20px; text-align: right;">
            <form method="GET" action="{{ route('attendance.export') }}" style="display: inline;">
                @csrf
                <input type="hidden" name="date-picker" value="{{ old('date-picker', $date_filter) }}" />
                <input type="hidden" name="trainee-id" value="{{ old('trainee-id', $emp_id_filter) }}" />
                <button type="submit" class="btn">Download Attendance</button>
            </form>
        </div>

        <h2>Present Trainees</h2>
        <table class="reservation-table fixed-size" id="present-trainees">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Seat No</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                </tr>
            </thead>
                        <!-- Present Trainees Table -->
<tbody>
    @forelse($present_trainees as $index => $trainee)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $trainee->date }}</td>
        <td>{{ $trainee->emp_id }}</td>
        <td>{{ $trainee->bookingDetails->employee_name ?? 'N/A' }}</td>
        
        <!-- Show seat_no from attendance, but fallback to bookingDetails if needed -->
        <td>{{ $trainee->seat_no ?? $trainee->bookingDetails->seat_no ?? 'N/A' }}</td>

        <td>{{ $trainee->bookingDetails->phone_number ?? 'N/A' }}</td>
        <td>{{ $trainee->bookingDetails->email ?? 'N/A' }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="7">No present trainees found.</td>
    </tr>
    @endforelse
</tbody>
</table>

        <h2>Absent Trainees</h2>
        <table class="reservation-table fixed-size" id="absent-trainees">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Seat No</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
    @forelse($absent_trainees as $index => $trainee)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $trainee->date }}</td>
        <td>{{ $trainee->emp_id }}</td>
        <td>{{ $trainee->bookingDetails->employee_name ?? 'N/A' }}</td>
        
        <!-- Show seat_no from attendance, but fallback to bookingDetails if needed -->
        <td>{{ $trainee->seat_no ?? $trainee->bookingDetails->seat_no ?? 'N/A' }}</td>

        <td>{{ $trainee->bookingDetails->phone_number ?? 'N/A' }}</td>
        <td>{{ $trainee->bookingDetails->email ?? 'N/A' }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="7">No absent trainees found.</td>
    </tr>
    @endforelse
</tbody>
        </table>
    </main>
</div>
</body>
</html>
