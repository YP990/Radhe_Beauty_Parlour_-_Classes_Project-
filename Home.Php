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

   









 <!-- slide str. -->

 
 <div class="slider">  
    <div class="slides">  
        <div class="slide"><img src="img/Radhe Beauty Parlour & Classes Slider.png" alt="Image 1"></div>  
        <div class="slide"><img src="img/eyebrow Services Radhe Beauty Parlour  & classes slider 2.jpg" alt="Image 2"></div>  
        <div class="slide"><video controls autoplay loop>
            <source src="img/Radhe Beauty Parlour  & Classes Services.mp4" type="video/mp4">
            
          </div>
    
    
     </div>  
</div>  
 
 







<!-- services -->
<div class="gridhead"><a href="Services.Php">Services</div></a>
<div class="gallbox">
	<div class="gall">
			<a href="Services.Php"><img src="img/Radhe_Beauty_Palor___Classes_Skin_1.png" class="catimg"></a>
			<h2>skin</h2>
	</div>
	
	<div class="gall">
		<a href="Services.Php"><img src="img/Radhe_Beauty_Palor___Classes_Eyebrows_2.png" class="catimg"></a>
		<h2>Eyebrows</h2>
	</div>

	<div class="gall">
		<a href="Services.Php"><img src="img/Radhe_Beauty_Palor___Classes_Hair_cut_3.png" class="catimg"></a>
		<h2>Hair Cut</h2>
	</div>

	<div class="gall">
		<a href="Services.Php"><img src="img/Radhe_Beauty_Palor___Classes_Face_4.png" class="catimg"></a>
		<h2>Face</h2>
	</div>

	<div class="gall">
		<a href="Services.Php"><img src="img/Radhe_Beauty_Palor___Classes_Makeup_5.png" class="catimg"></a>
		<h2>Makeup</h2>
	</div>
 </div>
 <!-- <a href="Services.html"><button class="btn">Other Services</button></a> -->


<!-- end services -->


<!-- about us home start -->
<div class="body1">  
  <div class="row">
       <div class="imgWrapper">
         <img src="img/Radhe Beauty paler & Classes About Us2.jpeg" alt="">
        </div>
        <div class="contentWrapper">
            <div class="content">
                <h2 class="tx2">About Us</h2>
                <p>Welcome to Radhe Beauty Paler & Classes, where beauty meets excellence. Established in 2001, <br>
                    our salon has been a cherished haven for those seeking exceptional hair and beauty services in Junagadh. <br><br>
                     Our mission is simple: to enhance your natural beauty while providing an unparalleled salon experience.

                    At Radhe Beauty Paler & Classes, we believe that every client deserves personalized attention and care. <br><br>
                    Our team of highly skilled and passionate stylists and beauty experts are dedicated to understanding your unique needs and delivering results that exceed your expectations.
                    Whether you're looking for a fresh haircut, a vibrant color transformation, or a relaxing spa treatment, we have the expertise and creativity to make it happen.
                    
                    
                </p>
            </div>
        </div>
   </div>
</div>

   
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
