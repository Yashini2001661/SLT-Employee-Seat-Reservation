document.addEventListener('DOMContentLoaded', function () {
    const datePicker = document.getElementById('date-picker');
    const today = new Date();
    
    // Get tomorrow's date
    const tomorrow = new Date();
    tomorrow.setDate(today.getDate() + 1);

    // Get next Monday
    const nextMonday = new Date();
    nextMonday.setDate(tomorrow.getDate() + ((8 - tomorrow.getDay()) % 7));

    // Friday next week
    const endDate = new Date(nextMonday);
    endDate.setDate(endDate.getDate() + 4); 

    // Disable from tomorrow onward
    datePicker.setAttribute('min', formatDate(tomorrow));
    // Allow only until Friday next week
    datePicker.setAttribute('max', formatDate(endDate));

    // Function to format date in 'YYYY-MM-DD'
    function formatDate(date) {
        let month = '' + (date.getMonth() + 1),
            day = '' + date.getDate(),
            year = date.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    // Prevent selection of Saturdays and Sundays
    datePicker.addEventListener('input', function () {
        const selectedDate = new Date(this.value);
        const day = selectedDate.getDay();

        // Check if it's a weekend (Saturday=6, Sunday=0)
        if (day === 6 || day === 0) {
            this.value = ''; // Clear the selection
            alert('Weekends are not allowed. Please select a weekday.');
        }
    });
});