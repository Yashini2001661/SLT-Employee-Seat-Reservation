<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Google Seat Booking</title>
    <link rel="stylesheet" href="{{ asset('assets/css/system.css') }}">
    <script src="https://kit.fontawesome.com/78191ce747.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="{{ asset('assets/js/reservation.js') }}"></script>
    <script src="{{ asset('assets/js/seats.js') }}"></script>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="container text-center">
            <div class="position-absolute top-0 end-0 p-3">
                <a class="btn btn-light" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout <i class="fas fa-sign-out-alt"></i></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            
            <div id="custom-alert" class="alert alert-danger" style="display: none;"></div>
            <div id="custom-confirm" class="alert alert-primary text-center" style="display: none;">
                <p>Booking is not allowed for Google login users. Do you want to log in with your user account to book a seat?</p>
                <button id="confirm-yes" class="btn btn-success me-2">Yes</button>
                <button id="confirm-no" class="btn btn-danger">No</button>
            </div>

            <!-- Center the title and status -->
            <h1 class="mb-4">Welcome to Seat Booking System</h1>
            
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="col-md-6 mx-auto">
                <h5><b>Select Date</b></h5>
                <input type="date" class="form-control mb-3" id="date-picker" onchange="enableSeatSelection();">
                <div class="error-message" id="seat-error-message" style="display: none;">Please select a date first.</div>

                <h5><b>Select Seat</b></h5>
                <div class="seat-grid" id="seat-grid">
                    @for($i = 1; $i <= 50; $i++)
                        <div class="seat available" 
                            data-seat-number="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" 
                            style="background-color: green;"
                            onclick="selectSeat(this);">
                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                        </div>
                    @endfor
                </div>

                <h5 class="mt-4"><b>Seat Status</b></h5>
                <div class="d-flex justify-content-center mb-4">
                    <div class="status-label me-3">
                        <b>Available Seat</b>
                        <div class="available"></div>
                    </div>
                    <div class="status-label me-3">
                        <b>Booked Seat</b>
                        <div class="booked"></div>
                    </div>
                    <div class="status-label">
                        <b>Selected Seat</b>
                        <div class="selected"></div>
                    </div>
                </div>

                <button class="btn btn-danger mt-4" id="confirm-btn">Confirm Booking</button>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('confirm-btn').addEventListener('click', function(event) {
        event.preventDefault();

        let customAlert = document.getElementById('custom-alert');
        let customConfirm = document.getElementById('custom-confirm');

        customAlert.style.display = 'none'; // Hide any previous alert
        customConfirm.style.display = 'block'; // Show the custom confirmation box
    });

    document.getElementById('confirm-yes').addEventListener('click', function() {
        window.location.href = '{{ route('login.view') }}'; // Redirect to login
    });

    document.getElementById('confirm-no').addEventListener('click', function() {
        let customAlert = document.getElementById('custom-alert');
        let customConfirm = document.getElementById('custom-confirm');

        customConfirm.style.display = 'none'; // Hide the custom confirmation box
        customAlert.innerHTML = 'You will remain logged in with Google. Booking will not proceed.';
        customAlert.style.display = 'block'; // Show the message
        customAlert.classList.remove('alert-success');
        customAlert.classList.add('alert-danger');

        // Auto-hide after 5 seconds
        setTimeout(function() {
            customAlert.style.display = 'none';
        }, 5000);
    });
    </script>
</body>
</html>
