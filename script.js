let menu= document.querySelector('#menu-btn');      //responsiv
let nav= document.querySelector('header nav');

menu.onclick=()=>{
  menu.classList.toggle('fa-times');
  nav.classList.toggle('active');
};

window.onscroll = () => {
  menu.classList.remove('fa-times');
  navbar.classList.remove('active');
  }

  let slides = document.querySelector(".slides");  
  let slideIndex = 0;  

  function showSlide(index) {  
      slides.style.transform = `translateX(-${index * 100}%)`;  
  }  

  function nextSlide() {  
      slideIndex = (slideIndex + 1) % slides.children.length;  
      showSlide(slideIndex);  
  }  

  setInterval(nextSlide, 5000); // Change slide every 3 seconds  


  //signup and login popup
  document.getElementById('lbut').onclick = function() {
    document.getElementById('loginPopup').style.display = 'block';
}

document.getElementById('slbut').onclick = function() {
    document.getElementById('signupPopup').style.display = 'block';
}

document.getElementById('closeLogin').onclick = function() {
    document.getElementById('loginPopup').style.display = 'none';
}

document.getElementById('closeSignup').onclick = function() {
    document.getElementById('signupPopup').style.display = 'none';
}

document.getElementById('forgotPassword').onclick = function() {
    
    
    document.getElementById('forgotPasswordPopup').style.display = 'block';
}

document.getElementById('closeForgotPassword').onclick = function() {
    document.getElementById('forgotPasswordPopup').style.display = 'none';
}

document.getElementById('openSignupLink').onclick = function() {
    document.getElementById('loginPopup').style.display = 'none';
    document.getElementById('signupPopup').style.display = 'block';
}

document.getElementById('openLoginLink').onclick = function() {
    document.getElementById('signupPopup').style.display = 'none';
    document.getElementById('loginPopup').style.display = 'block';
}

// Close the popups when clicking outside of them
window.onclick = function(event) {
    if (event.target.className === 'popup') {
        event.target.style.display = 'none';
    }
}



// course form
document.getElementById('admissionButton').addEventListener('click', function() {
    const form = document.getElementById('admissionForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
});

document.getElementById('admissionForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the form from submitting

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const services = document.getElementById('services').value;
    const messageDiv = document.getElementById('message');

    // Simple validation
    if (!name || !email || !phone || !services) {
        messageDiv.textContent = "Please fill in all fields.";
        messageDiv.style.color = "red";
        return;
    }

    // Simulating form submission
    messageDiv.textContent = "Thank you for your submission, " + name + "!";
    messageDiv.style.color = "green";

    // Reset the form
    document.getElementById('admissionForm').reset();
});





// franchise buy form 

document.getElementById('franchiseBuyBtn').addEventListener('click', function() {
  document.getElementById('franchiseForm').style.display = 'block';
});

document.querySelector('.franchise-form form').addEventListener('submit', function(e) {
  e.preventDefault();
  alert('Thank you for your salon franchise application! We will review your details and contact you soon.');
  this.reset();
  document.getElementById('franchiseForm').style.display = 'none';
});

