<?php
include 'admin penal/Connections.Php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="img/Radhe Beauty Parlour & Classes Logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radhe Beauty Paler & Classes</title>

    <!-- swiper css link -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- font awesome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="Style.css">
    
    


    <!-- <img src="img/Radhe Beauty Paler & Classes.png" alt="img/Radhe Beauty Paler & Classes.png" height="10"> -->


</head>

<body class="body">

    <div class="WhatsApp">
    <a aria-label="Chat on WhatsApp" href="https://wa.me/+919913179197"><img src="img\Radhe beauty palear whatApp.png" width="50px" alt=""></a>
    </div>

    <header>
        
        <nav>
            <ul>
              <li>  <div class="logo">
                    <img src="img/Radhe Beauty Parlour & Classes Logo.png" alt="img/Radhe Beauty Paler & Classes.png">
                </div><li></li>
                <li><a href="Home.Php">Home</a></li>
                <li><a href="About Us.Php">About Us</a></li>
                <li>
                    <a href="Services.Php">Services</a>
                </li>
                <li>
                    <a href="Course.Php">Courses</a>
                </li>
                <li>
                    <a href="Franchise Buy.Php">Franchise Buy</a>
                </li>

                <li><a href="Contect Us.Php">Contec Us</a></li>

                
              

               
               
               
                


                <li><button id="lbut">Login</button></li>
               <li><button id="slbut">Sign Up</button></li>
               
               
               <a href="Book now.Php"><li><button id="bookNowBtn">Book Now</button></li></a>
     

                <div id="menu-btn" class="fas fa-bars"></div>

            </ul>

            </div>
        </nav>

        
</header>
 






<div id="loginPopup" class="popup">
    <div class="popup-content">
        <span class="close" id="closeLogin">&times;</span>
        <h2>Login</h2>
        <form id="loginForm">
            <input type="email" placeholder="Email" required>
            <input type="password" placeholder="Password" required>
            <button class="logbut" type="submit">Login</button>
        </form>
        <a href="#" id="forgotPassword">Forgot Password?</a>
        <div id="signupLink">Don't have an account? <a href="#" id="openSignupLink">Sign Up</a></div>
    </div>
</div>

<!-- Forgot Password Popup -->
<div id="forgotPasswordPopup" class="popup">
    <div class="popup-content">
        <span class="close" id="closeForgotPassword">&times;</span>
        <h2>Forgot Password</h2>
        <form id="forgotPasswordForm">
            <input type="email" placeholder="Enter your email" required>
            <button class="logbut" type="submit">Reset Password</button>
        </form>
    </div>
</div>

<!-- Popup for Signup Form -->
<div id="signupPopup" class="popup">
    <div class="popup-content">
        <span class="close" id="closeSignup">&times;</span>
        <h2>Sign Up</h2>
        <form id="signupForm">
            <input type="text" placeholder="Full Name" required>
            <input type="email" placeholder="Email" required>
            <input type="password" placeholder="Password" required>
            <button  class="logbut" type="submit">Sign Up</button>
        </form>
        <div id="loginLink">Already have an account? <a href="#" id="openLoginLink">Login</a></div>
    </div>
</div>





   
<!-- about us start -->

<h1 >Coures</h1>

<div class="body1">  
  <div class="ro1">
       <div class="imgWrapper">
         <img src="img/Radhe Beauty palor & Classes Coures img.jpeg"alt="">
        </div>
        <div class="contentWrapper">
            <div class="content">
               <p>
                A comprehensive Beauty Parlour course is designed to equip aspiring beauty professionals with the necessary skills and knowledge across various disciplines, 
                including hairdressing, skincare, nail technology, and makeup application. <br><br>
                Typically spanning 600 to 1,500 hours, the course duration varies depending on the institution and the depth of training.

                The curriculum often begins with foundational techniques in hair cutting, coloring, and styling, allowing students to master both classic and contemporary looks.<br><br>
                In skincare, students learn about skin types, facial treatments, and the effective use of products, emphasizing safety and client care.
                 
               Nail technology modules cover essential skills in manicures, pedicures, and creative nail art, with a strong focus on sanitation practices.
               <br><br>
                Makeup artistry training teaches techniques for day, evening, and special occasion looks, along with color theory and application methods.
                
                Additionally, the course includes important business management skills, covering topics such as marketing, customer service, and salon operations.
                 Hands-on practice through workshops and internships provides real-world experience, ensuring graduates are well-prepared for the job market. Upon completion, students typically receive a certification, enhancing their employability and demonstrating their qualifications in the beauty industry. This certification may be recognized by local licensing boards, allowing graduates to pursue state licensure and begin their careers in salons, spas, or as independent beauty professionals.
                
                 Contact us now to take Admission.
                
                
                 
                
                </p>
                
             </div> 
             
        </div>
    </div>
</div>



<div class="cont3">
    <button id="admissionButton">Admission Now</button>
    <form id="admissionForm" style="display: none;">
        <h1>Admission in Courses</h1>

        <label for="name">Name:</label>
        <input type="text" id="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" required>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" required>

        <label for="services">Select Services:</label>
        <select id="services" required>
            <option value="">--Please choose an option--</option>
            <option value="haircut">Haircut</option>
            <option value="color">Coloring</option>
            <option value="manicure">Manicure</option>
            <option value="facial">Facial</option>
        </select>

        <button type="submit">Submit</button>
        <div id="message" class="message"></div>
    </form>
</div>

<?php

// Create table if not exists
$create_table_sql = "CREATE TABLE IF NOT EXISTS course_admissions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    service VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($create_table_sql) === FALSE) {
    echo "<script>console.error('Error creating table: " . $conn->error . "');</script>";
} else {
    echo "<script>console.log('Table created successfully or already exists');</script>";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $service = $conn->real_escape_string($_POST['services']);

    $insert_sql = "INSERT INTO course_admissions (name, email, phone, service) 
                   VALUES ('$name', '$email', '$phone', '$service')";

                   
    
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("ssss", $name, $email, $phone, $service);

    if ($stmt->execute()) {
        echo "<script>
            document.getElementById('message').innerHTML = 'Admission request submitted successfully!';
            document.getElementById('message').style.color = 'green';
        </script>";
    } else {
        echo "<script>
            document.getElementById('message').innerHTML = 'Error: " . $stmt->error . "';
            document.getElementById('message').style.color = 'red';
        </script>";
    }

    $stmt->close();
}
?>

<script>
document.getElementById('admissionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    var formData = new FormData(this);
    
    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.body.innerHTML += data;
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>



<!-- about us end -->



<!-- footer section starts  -->



 
<footer>  
    <div class="row1">
        
              <img src="img/Radhe Beauty Parlour & Classes Logo.png" class="logo1">
            
     <div class="col">
         <h3>Address<div class="underline"><span></span></div></h3>
         <p>Nandavanmain Road,</p>
         <p>Near Aditay Shak Market</p>
         <p>Junagadh, PIN 362001, India</p>
         <p class="email-id">radhebeautypalor@gmail.com</p>
         <h4>+91-9904991136</h4>
    </div>
         <div class="col">
            <h3>Link <div class="underline"><span></span></div></h3>
            <ul>
                <li><a href="Home.Php">Home</a></li>
                <li><a href="About Us.Php">About Us</a></li>
                <li><a href="Services.Php">Services</a></li>
                <li><a href="Course.Php">Course</a></li>
                <li><a href="Franchise Buy.Php">Franchise Buy</a></li>
                <li><a href="Contect Us.Php">Contec Us</a></li>
            </ul>
         </div>

         <div class="col">
        <div class="social-icons">
            <h3>Social Medie<div class="underline"><span></span></div></h3>
            <i class="fa-brands fa-facebook"></i>
            <i class="fa-brands fa-whatsapp"></i>
            <i class="fa-brands fa-twitter"></i>
            <i class="fa-brands fa-instagram"></i>
        </div>
     </div>
     </div>
     <hr>
     <p class="myweb">created by Mr. yash kachhadiya</p>

     </div>

</footer>



    
 <!-- swiper js link -->
 <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

 <!--  custem js file link  -->
 <script src="script.js"></script>

</body>

</html>
