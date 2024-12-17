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






<?php
// Database connection
include 'admin penal/Connections.Php';

// Function to debug
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    
    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

// Sign Up Form Submission
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Check if email already exists
    $check_email = "SELECT * FROM sign_up WHERE email=?";
    $stmt = mysqli_prepare($conn, $check_email);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){
        echo "<script>alert('Email already exists');</script>";
    } else {
        if($password == $cpassword){
            // Check if 'name' column exists in the sign_up table
            $check_column = "SHOW COLUMNS FROM sign_up LIKE 'name'";
            $column_result = mysqli_query($conn, $check_column);
            
            if(mysqli_num_rows($column_result) > 0) {
                // If 'name' column exists, use it in the query
                $sql = "INSERT INTO sign_up (name, email, password) VALUES ('$name', '$email', '$password')";
                mysqli_query($conn, $sql);
            } else {
                // If 'name' column doesn't exist, omit it from the query
                $sql = "INSERT INTO sign_up (email, password) VALUES ('$email', '$password')";
                mysqli_query($conn, $sql);
            }
            
            if(mysqli_query($conn, $sql)){
                echo "<script>alert('Sign up successful');</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Passwords do not match');</script>";
        }
    }
}

// Login Form Submission
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM sign_up WHERE email=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($result)){
        if(isset($row['password']) && $row['password'] !== ''){
            if($password === $row['password']){
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_email'] = $row['email'];

                // Store login data in login_data table
                $user_id = $row['id'];
                $login_time = date('Y-m-d H:i:s');
                $insert_login_data = "INSERT INTO login_data (user_id, email, login_time) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $insert_login_data);
                mysqli_stmt_bind_param($stmt, "iss", $user_id, $email, $login_time);
                
                if(mysqli_stmt_execute($stmt)){
                    echo "<script>alert('Login successful');</script>";
                    echo "<script>window.location.href = 'dashboard.php';</script>";
                } else {
                    echo "<script>alert('Login failed. Please try again.');</script>";
                }
            } else {
                echo "<script>alert('Invalid password');</script>";
            }
        } else {
            echo "<script>alert('Password not set for this account. Please use the forgot password feature or contact support.');</script>";
        }
    } else {
        echo "<script>alert('User not found. Please sign up.');</script>";
    }
}
?>

<div id="loginPopup" class="popup">
<div class="popup-content">
            <span class="close" id="closeLogin">&times;</span>
            <h2>Login</h2>
            <form id="loginForm" action="" method="post">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button class="logbut" type="submit" name="login">Login</button>
            </form>
            <a href="#" id="forgotPassword"></a>
            <div id="signupLink">Don't have an account? <a href="#" id="openSignupLink">Sign Up</a></div>
        </div>
    </div>
    
    <!-- Popup for Signup Form -->
    <div id="signupPopup" class="popup">
        <div class="popup-content">
            <span class="close" id="closeSignup">&times;</span>
            <h2>Sign Up</h2>
            <form id="signupForm" action="" method="post">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="cpassword" placeholder="Confirm Password" required>
                <button class="logbut" type="submit" name="submit">Sign Up</button>
            </form>
            <div id="loginLink">Already have an account? <a href="#" id="openLoginLink">Login</a></div>
        </div>
    </div>





<h1 >Franchise Buy</h1>





 <div class="fimg">
    <img src="img/Radhe Beauty Parlour & Classes Franchise Buy.png" alt="">
 </div>

 <p class="pr">Investing in a Radhe Beauty Parlour & Classes franchise is your gateway to a rewarding business venture in the thriving beauty industry.
     With a strong brand reputation and a loyal customer base, our franchise offers you the opportunity to step into a proven business model that
     emphasizes quality, creativity, and customer satisfaction.As a franchisee, you’ll receive comprehensive training that covers everything from
     salon management to customer service, ensuring you have the skills and knowledge to succeed. Our dedicated support team will be with you every 
     step of the way, providing marketing strategies, operational guidance, and ongoing assistance tailored to your needs. By joining the Radhe Beauty
    Parlour & Classes family, you’re not just buying a franchise you’re investing in a fulfilling career that allows you to inspire confidence and beauty
    in your community. Embrace the chance to build a thriving business while doing what you love. Let’s create a brighter, more beautiful future together!

 </p>







<div class="title">Franchise Support & Benefit</div>

<div class="Frcard-container">
    <div class="fcard">
        <i class="fas fa-hand-holding-usd"></i>
        <h3>Financial Support</h3>
        <p>Business Loan Upto INR 30 to 40 lakhs</p>
    </div>
    <div class="fcard">
        <i class="fas fa-chart-line"></i>
        <h3>Proven return on investment</h3>
        <p>Starting a franchise with Radhe Beauty Palour & Classes offers a great opportunity for systematic growth, with a return on investment (ROI) expected in 30 to 48 months. With strong brand support and proven strategies, you can build a sustainable business and achieve your financial goals with confidence.</p>
    </div>
    <div class="fcard">
        <i class="fas fa-cogs"></i>
        <h3>Continues Operations support</h3>
        <p>We provide ongoing operational support to ensure your franchise runs smoothly. Our dedicated team offers resources and guidance to help you navigate challenges and achieve consistent success.</p>
    </div>
    <div class="fcard">
        <i class="fas fa-bullhorn"></i>
        <h3>Marketing & Creative Support</h3>
        <p>We provide expert digital marketing support, public relations assistance, and customized IT and POS billing software solutions tailored to your business needs, helping you enhance your online presence and streamline operations for growth.        </p>
    </div>
    <div class="fcard">
        <i class="fas fa-gem"></i>
        <h3>Brand Value</h3>
        <p>Radhe Beauty Parlour & Classes has established itself as a leading brand over the past 21 years. We invite you to join us on this success journey as a franchise partner, benefiting from our experience and support while contributing to our continued growth in the beauty industry.</p>
    </div>
    <div class="fcard">
        <i class="fas fa-chalkboard-teacher"></i>
        <h3>Expert Training</h3>
        <p>Our expert training program offers in-depth knowledge and practical skills for success in the beauty industry. Led by experienced professionals, it includes hands-on learning and personalized guidance, empowering you to meet client needs and excel in your career.</p>
    </div>
</div>
   
 
<a href="Franchise Buy Form.Php"><button class="btn">Franchise Buy Now</button></a>














   

 
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
            <h3>Hourse<div class="underline"><span></span></div></h3>
            <p>Monday to saturday</p>
            <p>Morning 10pm to 1pm</p>
            <p>Evening 4pm to 10pm</p>
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
