let selectedSeat = null; // To track the currently selected seat

// Function to enable seat selection based on the selected date
function enableSeatSelection() {
    const selectedDate = document.getElementById('date-picker').value;

    if (!selectedDate) {
        document.getElementById('seat-error-message').style.display = 'block'; // Show error message if no date
        return;
    }

    document.getElementById('seat-error-message').style.display = 'none'; // Hide error message once date is selected

    // Fetch seats for the selected date via AJAX
    fetch(`/get-seats?date=${selectedDate}`)
        .then(response => response.json())
        .then(data => {
            const seatGrid = document.getElementById('seat-grid');
            seatGrid.innerHTML = ''; // Clear existing seats

            // Loop through the seats and update their status
            for (let i = 1; i <= 50; i++) {
                let seatDiv = document.createElement('div');
                seatDiv.classList.add('seat');
                seatDiv.dataset.seatNumber = String(i).padStart(2, '0');

                const seatData = data.find(seat => seat.seat_no === i);
                if (seatData && seatData.is_booked) {
                    // If the seat is booked, color it blue
                    seatDiv.classList.add('booked');
                    seatDiv.style.backgroundColor = 'blue'; // Booked seat color
                } else {
                    // Available seats for the selected date should be green
                    seatDiv.classList.add('available');
                    seatDiv.style.backgroundColor = 'green'; // Available seat color
                    seatDiv.onclick = function() {
                        selectSeat(seatDiv);
                    };
                }

                seatDiv.innerHTML = String(i).padStart(2, '0');
                seatGrid.appendChild(seatDiv);
            }
        })
        .catch(error => console.error('Error fetching seats:', error));
}



// Function to select a seat and apply appropriate color logic
function selectSeat(seat) {
    const selectedDate = document.getElementById('date-picker').value;

    // Check if a date is selected before allowing seat selection
    if (!selectedDate) {
        document.getElementById('seat-error-message').style.display = 'block'; // Show error message if no date is selected
        return;
    }

    document.getElementById('seat-error-message').style.display = 'none'; // Hide error message if date is selected

    if (selectedSeat) {
        selectedSeat.style.backgroundColor = 'green'; // Reset the previously selected seat
        selectedSeat.classList.remove('selected');
    }

    // Mark the newly selected seat as orange
    seat.classList.add('selected');
    seat.style.backgroundColor = 'orange'; // Highlight selected seat in orange

    selectedSeat = seat; // Update the selected seat
}

function confirmBooking() {
    if (!selectedSeat) {
        alert("Please select a seat before confirming."); // Alert if no seat is selected
        return;
    }

    const date = document.getElementById('date-picker').value;
    const seatNo = selectedSeat.getAttribute('data-seat-number');

    fetch('/book-seat', { // Replace with your route
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Include CSRF token
        },
        body: JSON.stringify({
            date: date,
            seat_no: seatNo
        })
    })
    .then(response => response.json()) // Parse JSON response
    .then(data => {
        if (data.success) {
            // Show success message
            alert(data.message); // Display "Booking Success."
            // Optionally, update UI or refresh page to reflect the booking
            window.location.reload(); // Refresh the page to update seat availability
        } else {
            // Show error message
            alert(data.message); // This shows validation errors or if seat is already booked
        }
    })
    .catch(error => {
        console.error('Error:', error); // Log any network or other errors
        alert('An error occurred while booking the seat.'); // Generic error message
    });

    }
