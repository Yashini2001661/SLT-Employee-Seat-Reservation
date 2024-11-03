<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/78191ce747.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Seat Booking</title>
    <link rel="stylesheet" href="{{ asset('assets/css/system.css') }}">
    <script src="{{ asset('assets/js/reservation.js') }}"></script>
    <script src="{{ asset('assets/js/seats.js') }}"></script>
    <script src="{{ asset('assets/js/cancel.js') }}"></script>
</head>
<body>

<!-- Logout Button -->
<div class="position-absolute top-0 end-0 p-3">
    <a href='/homeRoute' class="btn btn-light" title="Logout">
        Logout <i class="fas fa-sign-out-alt"></i>
    </a>
</div>

    <div class="container mt-4">
    <div class="d-flex justify-content-between mb-4 mt-5">
        <h1><b>WELCOME TO THE SEAT BOOKING</h1></b>
        <form class="d-flex align-items-center">
            <label for="internId" class="me-2"><b>Intern ID:</label></b>
            <input type="text" class="form-control me-2" value="{{ Auth::user()->emp_id }}" readonly style="width: 150px; border-radius: 5px;">
        </form>
    </div>

    <div class="row">
        <!-- Change col-md-4 to col-md-5 to make it take up 40% -->
        <div class="col-md-5">
            <h5><b>My Bookings</b></h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Seat</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="booking-table-body">
                    @foreach($userBookings as $booking)
                        <tr>
                            <td>{{ $booking->date }}</td>
                            <td>{{ str_pad($booking->seat_no, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                @if (now()->diffInDays($booking->date) > 0)
                                    <button class="btn btn-danger btn-sm" onclick="cancelBooking({{ $booking->id }})">Cancel</button>
                                @else
                                    <button class="btn btn-danger btn-sm" disabled>Cancel</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-1 d-flex justify-content-center align-items-center">
            <div class="vertical-line"></div>
        </div>

        <!-- Change col-md-7 to col-md-6 to make it take up 60% -->
        <div class="col-md-6">
            <h5><b>Select Date</b></h5>
            <input type="date" class="form-control mb-3" id="date-picker" onchange="enableSeatSelection();">
            <div class="error-message" id="seat-error-message" style="display: none;">Please select a date first.</div>

            <h5><b>Select Seat</b></h5>
            <div class="seat-grid" id="seat-grid">
                <!-- Initial rendering of seats, all available (green) -->
                @for($i = 1; $i <= 50; $i++)
                    <div class="seat available" 
                        data-seat-number="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" 
                        style="background-color: green;"
                        onclick="selectSeat(this);">
                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                    </div>
                @endfor
            </div>

            <div class="d-flex">
                <div class="status-label">
                    <b>Available Seat</b>
                    <div class="available"></div>
                </div>
                <div class="status-label">
                    <b>Booked Seat</b>
                    <div class="booked"></div>
                </div>
                <div class="status-label">
                    <b>Selected Seat</b>
                    <div class="selected"></div>
                </div>
            </div>
            <button class="btn btn-success mt-4" id="confirm-button" onclick="confirmBooking()">Confirm</button>    
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-DfXdz0Bq1Z5b9U73rZPRgYPXFR2h6G3jT5QXcZ9P/qohzS8ht29p5E8sF3vW1qBQ" crossorigin="anonymous"></script> 

</body>
</html>