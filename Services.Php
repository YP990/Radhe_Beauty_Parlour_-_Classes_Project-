<?php
include 'admin penal/Connections.Php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="img/Radhe Beauty Parlour & Classes Logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radhe Beauty Parlour & Classes</title>

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
// include 'admin panel/Connections.Php';       

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



<h1>Services</h1>

  

   


<!-- us end -->
    <div class="cont">
  <h1><a href="skin"></a>Skin</h1>
</div>


<div class="con1">
  
  <div class="container">
    <div class="card">
      <div class="front">
        <div class="card-top">
          <p class="card-top-para">Eyebrows</p>
        </div>
         <img src="img/Radhe Beauty Palor & Classes Services Eyebrow.jpeg" alt="">
      </div>
      <div class="back">
        <p class="heading">Transform your look with our expert eyebrow services!<br>
           Our skilled professionals enhance your beauty with perfectly sculpted brows.<br> 
          Enjoy a relaxing atmosphere and personalized consultations. Book today for stunning brows that turn heads!</p>
        <!-- <button class="btn-12"><span>Book Now</span></button> -->
        <div data-tooltip="₹50" class="button">
          <div class="button-wrapper">
          <div class="book">Book Now</div>
          <a href="Book now.Php"><span class="icon">
                <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
          </svg>
              </span></a>
            </div>
          </div>
       
        </div>
      </div>
    </div>
  
    
      <div class="container">
        <div class="card">
          <div class="front">
            <div class="card-top">
              <p class="card-top-para">Face Thrading</p>
            </div>
             <img src="img/Radhe Beauty Paler & Classes Services threading.webp" alt="">
          </div>
          <div class="back">
            <p class="heading">Achieve a flawlessly defined look with our expert face threading! Our skilled technicians shape your features beautifully, providing a gentle, effective treatment in a soothing environment. Say goodbye to irritation and hello to smooth, radiant skin! Book your appointment today!</p>
            <div data-tooltip="₹100" class="button">
              <div class="button-wrapper">
                <div class="book">Book Now</div>
                <a href="Book now.Php">  <span class="icon">
                    <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
              </svg>
                  </span></a>
                </div>
              </div>
          
            </div>
          </div>
        </div>


        <div class="container">
          <div class="card">
            <div class="front">
              <div class="card-top">
                <p class="card-top-para">Upper Lip</p>
              </div>
               <img src="img/Radhe Beaut Paler & Classes Uper Lipes Threading.jpg" alt="">
            </div>
            <div class="back">
              <p class="heading">Transform your look with our Upper Lip Luxe Service! Enjoy personalized treatments for a flawless, radiant finish that enhances your natural beauty. Perfectly groomed lips await!</p>
               <div data-tooltip="₹20" class="button">
                <div class="button-wrapper">
                  <div class="book">Book Now</div>
                  <a href="Book now.Php">  <span class="icon">
                      <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
                  <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
                </svg>
                    </span></a>
                  </div>
                </div>
             
              </div>
            </div>
          </div>


      
          <div class="container">
            <div class="card">
              <div class="front">
                <div class="card-top">
                  <p class="card-top-para">Hand Wax</p>
                </div>
                 <img src="img/Radhe Beauty Paler & Classes Han Wax Services.jpeg" alt="">
              </div>
              <div class="back">
                <p class="heading">Revitalize your hands with our Luxurious Hand Wax Service ! Enjoy silky smoothness and deep hydration.Book now for a pampering experience!</p>
                <div data-tooltip="₹150 start." class="button">
                  <div class="button-wrapper">
                    <div class="book">Book Now</div>
                    <a href="Book now.Php"> <span class="icon">
                        <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
                    <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
                  </svg>
                      </span></a>
                    </div>
                  </div>


               </div>
              </div>
            </div>  

            <div class="container">
              <div class="card">
                <div class="front">
                  <div class="card-top">
                    <p class="card-top-para">Lag Wax</p>
                  </div>
                   <img src="img/Radhe Beauty Palor & Classes lag Wax Services.jpeg" alt="">
                </div>
                <div class="back">
                  <p class="heading">Get smooth, stunning legs with our Silky Leg Wax Service! Book now for soft, flawless skin!



                  </p>
                  <div data-tooltip="₹150 to start" class="button">
                    <div class="button-wrapper">
                      <div class="book">Book Now</div>
                      <a href="Book now.Php"> <span class="icon">
                          <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
                      <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
                    </svg>
                        </span></a>
                      </div>
                    </div>


                 </div>
                </div>
              </div>  

              <div class="container">
                <div class="card">
                  <div class="front">
                    <div class="card-top">
                      <p class="card-top-para">Full Body Wax</p>
                    </div>
                     <img src="img/Radhe Beauty palor & Classes Full Body Wax.jpg" alt="">
                  </div>
                  <div class="back">
                    <p class="heading">Experience ultimate smoothness with our Revitalizing Body Wax Service! Enjoy gentle hair removal for silky, radiant skin. Book now for a pampering treat!</p>
                    <div data-tooltip="₹1000 start" class="button">
                      <div class="button-wrapper">
                        <div class="book">Book Now</div>
                        <a href="Book now.Php">  <span class="icon">
                            <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
                        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
                      </svg>
                          </span></a>
                        </div>
                      </div>



                   </div>
                  </div>
                </div>  



                <div class="container">
                  <div class="card">
                    <div class="front">
                      <div class="card-top">
                        <p class="card-top-para">Facial</p>
                      </div>
                       <img src="img/Radhe Beauty Palor & Classes facial Services.jpg" alt="">
                    </div>
                    <div class="back">
                      <p class="heading">Revitalize your glow with our Luxury Facial Service! Enjoy personalized treatments that cleanse, nourish, and rejuvenate your skin. Book now for a radiant transformation!</p>
                     
                      <div data-tooltip="₹300 strat" class="button">
                        <div class="button-wrapper">
                          <div class="book">Book Now</div>
                          <a href="Book now.Php">  <span class="icon">
                              <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
                          <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
                        </svg>
                            </span></a>
                          </div>
                        </div>

                     </div>
                    </div>
                  </div>  

                  <div class="container">
                    <div class="card">
                      <div class="front">
                        <div class="card-top">
                          <p class="card-top-para">Shiner</p>
                        </div>
                         <img src="img/Radhe Beauty Palor & Classes shiner Services.jpg" alt="">
                      </div>
                      <div class="back">
                        <p class="heading">Elevate your look with our Shiner Service! Experience vibrant, glossy results that enhance your natural beauty. Book now for a dazzling transformation!</p>
                        <div data-tooltip="₹250 start" class="button">
                          <div class="button-wrapper">
                            <div class="book">Book Now</div>
                            <a href="Book now.Php">   <span class="icon">
                                <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
                            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
                          </svg>
                              </span></a>
                            </div>
                          </div>
                       
                        </div>
                      </div>
                    </div>  


                    <div class="container">
                      <div class="card">
                        <div class="front">
                          <div class="card-top">
                            <p class="card-top-para">Baleach</p>
                          </div>
                           <img src="img/Radhe Beauty Paler & Classes Baleach Services.jpeg" alt="">
                        </div>
                        <div class="back">
                          <p class="heading">Achieve a luminous glow with our Bleach Service! Experience gentle, effective brightening for a refreshed, radiant complexion. Book now for stunning results!</p>
                          
                          <div data-tooltip="₹150 start" class="button">
                            <div class="button-wrapper">
                              <div class="book">Book Now</div>
                              <a href="Book now.Php">   <span class="icon">
                                  <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
                              <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
                            </svg>
                                </span></a>
                              </div>
                            </div>


                         </div>
                        </div>
                      </div>  

                      
</div>
 
  
<div class="cont">
  <h1 class="center">Hair</h1>
  <img src="img/Radhe Beauty Paler & Classes Hair Services.png" alt="">
  
</div>



<div class="con1">
  
  <div class="container">
    <div class="card">
      <div class="front">
        <div class="card-top">
          <p class="card-top-para">Hair Cutinges</p>
        </div>
         <img src="img/Radhe Beauty Plaor & Classes hair Cut  Services.jpeg" alt="">
      </div>
      <div class="back">
        <p class="heading">Transform your look at our salon! Enjoy chic cuts, vibrant colors, and luxurious treatments tailored just for you. Book now and experience the stunning results today!</p>
        <div data-tooltip="₹50 starting" class="button">
          <div class="button-wrapper">
            <div class="book">Book Now</div>
            <a href="Book now.Php"> <span class="icon">
             <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
          </svg>
              </span></a>
            </div>
          </div>
       
        </div>
      </div>
    </div>
  
    
      <div class="container">
        <div class="card">
          <div class="front">
            <div class="card-top">
              <p class="card-top-para">Hair Colores</p>
            </div>
             <img src="img/Radhe Beauty Palor & Classes hair color services.jpg" alt="">
          </div>
          <div class="back">
            <p class="heading">Unlock your hair’s potential with our stunning color services! From bold hues to soft balayage, our expert stylists craft vibrant looks tailored to you. Book now for a radiant transformation!



            </p>
            <div data-tooltip="₹100 stasting" class="button">
              <div class="button-wrapper">
                <div class="book">Book Now</div>
                <a href="Book now.Php"><span class="icon">
                    <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
              </svg>
                  </span></a>
                </div>
              </div>

           </div>
          </div>
        </div>


        <div class="container">
          <div class="card">
            <div class="front">
              <div class="card-top">
                <p class="card-top-para">Highlightes</p>
              </div>
               <img src="img/Radhe Beauty Palor & Classes Hair highlightes Services.jpg" alt="">
            </div>
            <div class="back">
              <p class="heading">lluminate your look with our stunning highlights! Our expert stylists create natural or bold highlights that add depth and dimension. Book now for a radiant, fresh style!



              </p>
              
              <div data-tooltip="₹500 Strting" class="button">
                <div class="button-wrapper">
                  <div class="book">Book Now</div>
                  <a href="Book now.Php">  <span class="icon">
                      <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
                  <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
                </svg>
                    </span></a>
                  </div>
                </div>
             
              </div>
            </div>
          </div>


      
          <div class="container">
            <div class="card">
              <div class="front">
                <div class="card-top">
                  <p class="card-top-para">Smoothing</p>
                </div>
                 <img src="img/Radhe Beauty paler & Classes hair Smoothing Services.webp" alt="">
              </div>
              <div class="back">
                <p class="heading">Achieve sleek, frizz-free hair with our smoothing treatments! Our expert stylists use advanced techniques to transform your locks, leaving them shiny and manageable. Enjoy a luxurious experience tailored to your hair type and texture. Book now for smooth, stunning results! <p>
                <div data-tooltip="₹1000" class="button">
                  <div class="button-wrapper">
                    <div class="book">Book Now</div>
                    <a href="Book now.Php">  <span class="icon">
                        <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
                    <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
                  </svg>
                      </span></a>
                    </div>
                  </div>
               
                </div>
              </div>
            </div>  

            <div class="container">
              <div class="card">
                <div class="front">
                  <div class="card-top">
                    <p class="card-top-para">Hair Spa</p>
                  </div>
                   <img src="img/Radhe Beaut Paler & Classes Hair Spa Services.jpg" alt="">
                </div>
                <div class="back">
                  <p class="heading">Indulge in our luxurious spa hair services! Enjoy revitalizing scalp massages and nourishing treatments that leave your hair refreshed and radiant. Book now for the ultimate pampering experience!</p>
                  <div data-tooltip="₹1500" class="button">
                    <div class="button-wrapper">
                      <div class="book">Book Now</div>
                      <a href="Book now.Php"> <span class="icon">
                          <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
                      <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
                    </svg>
                        </span></a>
                      </div>
                    </div>


                 </div>
                </div>
              </div>  

              <div class="container">
                <div class="card">
                  <div class="front">
                    <div class="card-top">
                      <p class="card-top-para">Hair Style</p>
                    </div>
                     <img src="img/Radhe Beauty paler Hair Style Services.png" alt="">
                  </div>
                  <div class="back">
                    <p class="heading">Transform your look with our expert hairstyling services! From elegant updos to trendy braids, our talented stylists create stunning styles tailored to you. Book now to elevate your style!</p>
                    
                    <div data-tooltip="₹400 string" class="button">
                      <div class="button-wrapper">
                        <div class="book">Book Now</div>
                        <a href="Book now.Php"> <span class="icon">
                            <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
                        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
                      </svg>
                          </span></a>
                        </div>
                      </div>

                   </div>
                  </div>
                </div>  



` 

                      
</div>
 

<div class="cont">
  <h1 class="center">Makeup</h1>
  <img src="img/Radhe Beauty Paler & Classes Baleach Services Makeup.png" alt="">
  
</div>


<div class="con1">
  
  <div class="container">
    <div class="card">
      <div class="front">
        <div class="card-top">
          <p class="card-top-para">Brideal Makup</p>
        </div>
         <img src="img/Radhe Beaut Paler & Classes Makeup Services.jpg" alt="">
      </div>
      <div class="back">
        <p class="heading">Achieve your dream look on your special day with our bridal makeup services! Our expert artists create flawless, timeless beauty tailored to you. Book now to shine beautifully on your big day!



        </p>
        
        <div data-tooltip="₹10000 start" class="button">
          <div class="button-wrapper">
            <div class="book">Book Now</div>
            <a href="Book now.Php"> <span class="icon">
                <svg viewBox="0 0 16 16" class="bi bi-cart2" fill="currentColor" height="16" width="16">
            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"></path>
          </svg>
              </span></a>
            </div>
          </div>

       </div>
      </div>
    </div>

</div>
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
