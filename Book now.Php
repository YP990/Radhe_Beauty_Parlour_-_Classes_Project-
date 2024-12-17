<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Now Form</title>
     <!-- swiper css link -->

     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

     <!-- font awesome cdn link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
 
     <!-- custom css file link -->
     <link rel="stylesheet" href="Style.css">
     
</head>
<body>
    
    <?php
    // Include database connection
    include 'admin penal/Connections.Php';

    // Create table if not exists
    $create_table_sql = "CREATE TABLE IF NOT EXISTS salon_bookings (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        service VARCHAR(100) NOT NULL,
        other_service VARCHAR(255),
        preferred_date DATE NOT NULL,
        preferred_time TIME NOT NULL,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($create_table_sql) === FALSE) {
        echo "Error creating table: " . $conn->error;
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $conn->real_escape_string($_POST['name']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $service = $conn->real_escape_string($_POST['service']);
        $other_service = $conn->real_escape_string($_POST['otherService']);
        $date = $conn->real_escape_string($_POST['date']);
        $time = $conn->real_escape_string($_POST['time']);
        $notes = $conn->real_escape_string($_POST['notes']);

        $insert_sql = "INSERT INTO salon_bookings (name, phone, service, other_service, preferred_date, preferred_time, notes) 
                       VALUES ('$name', '$phone', '$service', '$other_service', '$date', '$time', '$notes')";

        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>alert('Booking successful!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
    ?>

    <div class="booking-container">
        <h2>Book Your Salon Service</h2>
        <form id="salonBookingForm" method="post" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="service">Select Service:</label>
                <select id="service" name="service" required>
                    <option value="">Choose a service</option>
                    <option value="haircut">Haircut</option>
                    <option value="coloring">Hair Coloring</option>
                    <option value="facial">Facial</option>
                    <option value="manicure">Manicure</option>
                    <option value="pedicure">Pedicure</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="otherService">Specify Other Service:</label>
                <input type="text" id="otherService" name="otherService">
            </div>
            <div class="form-group">
                <label for="date">Preferred Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Preferred Time:</label>
                <input type="time" id="time" name="time" required>
            </div>
            <div class="form-group">
                <label for="notes">Additional Notes:</label>
                <textarea id="notes" name="notes" rows="3"></textarea>
            </div>
            <button type="submit" class="submit-btn">Book Appointment</button>
        </form>
    </div>

    
    

<!-- swiper js link -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!--  custem js file link  -->
<script src="script.js"></script>


</body>
</html>