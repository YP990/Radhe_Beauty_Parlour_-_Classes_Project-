<?php
include 'admin penal/Connections.Php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Franchise Buy Form</title>
  <!-- swiper css link -->

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- font awesome cdn link-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <!-- custom css file link -->
  <link rel="stylesheet" href="Style.css">


</head>
<body>
   




<?php
// Create table if not exists
$create_table_sql = "CREATE TABLE IF NOT EXISTS franchise_applications (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    zip VARCHAR(20) NOT NULL,
    investment VARCHAR(50) NOT NULL,
    shop_size VARCHAR(50) NOT NULL,
    experience TEXT,
    why_franchise TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($create_table_sql) === FALSE) {
    echo "Error creating table: " . $conn->error;
}

// Check if shop_size column exists, if not, add it
$check_column_sql = "SHOW COLUMNS FROM franchise_applications LIKE 'shop_size'";
$result = $conn->query($check_column_sql);

if ($result->num_rows == 0) {
    $add_column_sql = "ALTER TABLE franchise_applications ADD COLUMN shop_size VARCHAR(50) NOT NULL";
    if ($conn->query($add_column_sql) === FALSE) {
        echo "Error adding shop_size column: " . $conn->error;
    }
}

if ($conn->query($create_table_sql) === FALSE) {
    echo "Error creating table: " . $conn->error;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $zip = $conn->real_escape_string($_POST['zip']);
    $investment = $conn->real_escape_string($_POST['investment']);
    $shop_size = $conn->real_escape_string($_POST['shop-size']);
    $experience = $conn->real_escape_string($_POST['experience']);
    $why_franchise = $conn->real_escape_string($_POST['why-franchise']);

    if (isset($_POST['id'])) {
        // Update existing record
        $id = $conn->real_escape_string($_POST['id']);
        $update_sql = "UPDATE franchise_applications SET 
                       name=?, email=?, phone=?, address=?, city=?, state=?, zip=?, 
                       investment=?, shop_size=?, experience=?, why_franchise=? 
                       WHERE id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssssssssssi", $name, $email, $phone, $address, $city, $state, $zip, $investment, $shop_size, $experience, $why_franchise, $id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Application updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating application: " . $stmt->error . "');</script>";
        }
    } else {
        // Check if 'experience' column exists in the table
        $check_experience_column = "SHOW COLUMNS FROM franchise_applications LIKE 'experience'";
        $experience_result = $conn->query($check_experience_column);
        
        if ($experience_result->num_rows == 0) {
            // If 'experience' column doesn't exist, add it
            $add_experience_column = "ALTER TABLE franchise_applications ADD COLUMN experience TEXT";
            $conn->query($add_experience_column);
        }

        // Check if 'why_franchise' column exists in the table
        $check_why_franchise_column = "SHOW COLUMNS FROM franchise_applications LIKE 'why_franchise'";
        $why_franchise_result = $conn->query($check_why_franchise_column);
        
        if ($why_franchise_result->num_rows == 0) {
            // If 'why_franchise' column doesn't exist, add it
            $add_why_franchise_column = "ALTER TABLE franchise_applications ADD COLUMN why_franchise TEXT";
            $conn->query($add_why_franchise_column);
        }

        // Insert new record
        $insert_sql = "INSERT INTO franchise_applications (name, email, phone, address, city, state, zip, investment, shop_size, experience, why_franchise) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("sssssssssss", $name, $email, $phone, $address, $city, $state, $zip, $investment, $shop_size, $experience, $why_franchise);
        
        if ($stmt->execute()) {
            echo "<script>alert('Application submitted successfully!');</script>";
        } else {
            echo "<script>alert('Error submitting application: " . $stmt->error . "');</script>";
        }
    }
    
    $stmt->close();
}

// Fetch existing application if ID is provided
$application = null;
if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $select_sql = "SELECT * FROM franchise_applications WHERE id = ?";
    $stmt = $conn->prepare($select_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $application = $result->fetch_assoc();
    }
    $stmt->close();
}
?>

<div class="form-container">
    <form class="franchise-form" method="post" action="">
        <h1><?php echo $application ? 'Update' : 'Submit'; ?> Salon Franchise Application</h1>
        
        <?php if ($application): ?>
            <input type="hidden" name="id" value="<?php echo $application['id']; ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required value="<?php echo $application ? $application['name'] : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required value="<?php echo $application ? $application['email'] : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" required value="<?php echo $application ? $application['phone'] : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="address">Address</label>
            <textarea id="address" name="address" required><?php echo $application ? $application['address'] : ''; ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" id="city" name="city" required value="<?php echo $application ? $application['city'] : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="state">State</label>
            <input type="text" id="state" name="state" required value="<?php echo $application ? $application['state'] : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="zip">ZIP Code</label>
            <input type="text" id="zip" name="zip" required value="<?php echo $application ? $application['zip'] : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="investment">Available Investment (INR)</label>
            <select id="investment" name="investment" required>
                <option value="">Select range</option>
                <option value="0-10lakh" <?php echo ($application && $application['investment'] == '0-10lakh') ? 'selected' : ''; ?>>0 - 10 Lakh</option>
                <option value="10-20lakh" <?php echo ($application && $application['investment'] == '10-20lakh') ? 'selected' : ''; ?>>10 - 20 Lakh</option>
                <option value="20-30lakh" <?php echo ($application && $application['investment'] == '20-30lakh') ? 'selected' : ''; ?>>20 - 30 Lakh</option>
                <option value="30lakh+" <?php echo ($application && $application['investment'] == '30lakh+') ? 'selected' : ''; ?>>30 Lakh+</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="shop-size">Preferred Shop Size</label>
            <select id="shop-size" name="shop-size" required>
                <option value="">Select shop size</option>
                <option value="small" <?php echo ($application && $application['shop_size'] == 'small') ? 'selected' : ''; ?>>Small Shop</option>
                <option value="big" <?php echo ($application && $application['shop_size'] == 'big') ? 'selected' : ''; ?>>Big Shop</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="experience">Previous Business Experience</label>
            <textarea id="experience" name="experience"><?php echo $application ? $application['experience'] : ''; ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="why-franchise">Why do you want to open a Radhe Beauty Parlour franchise?</label>
            <textarea id="why-franchise" name="why-franchise" required><?php echo $application ? $application['why_franchise'] : ''; ?></textarea>
        </div>
        
        <div class="button-container">
            <button class="submit-button" type="submit"><?php echo $application ? 'Update' : 'Submit'; ?> Application</button>
        </div>
    </form>
</div>
    
    
</body>
</html>