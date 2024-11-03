<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
</head>
<body>
    <h2>Seat Booking Confirmation</h2>
    <p>Dear {{ $bookingDetails['employee_name'] }},</p>
    <p>We are pleased to confirm your seat booking:</p>
    <ul>
        <li>Date: {{ $bookingDetails['date'] }}</li>
        <li>Seat Number: {{ $bookingDetails['seat_no'] }}</li>
    </ul>
    <p>If you have any questions, feel free to contact us.</p>
    <p>Thank you!</p>
</body>
</html>
