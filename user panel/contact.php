<?php
include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../css/user_style.css">
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- box icon cdn link -->
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>
<body>

<?php include '../components/user_header.php'; ?>

<section class="contact">
   <div class="row">
      <div class="image">
         <img src="../images/contact-img.png" alt="Contact Us Image">
      </div>
      <form action="" method="POST">
         <h3>Get in Touch</h3>
         <input type="text" name="name" maxlength="50" class="box" placeholder="Enter your name" required>
         <input type="email" name="email" maxlength="50" class="box" placeholder="Enter your email" required>
         <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="Enter your number" required maxlength="10">
         <textarea name="message" class="box" required placeholder="Enter your message" maxlength="500" cols="30" rows="10"></textarea>
         <input type="submit" value="Send Message" name="send" class="btn">
      </form>
   </div>

   <div class="info">
      <div class="box">
         <i class="fas fa-phone"></i>
         <div>
            <h3>Phone Number</h3>
            <p>+216-456-7890</p>
         </div>
      </div>
      <div class="box">
         <i class="fas fa-envelope"></i>
         <div>
            <h3>Email Address</h3>
            <p>contact@bluesky.com</p>
         </div>
      </div>
      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <div>
            <h3>Office Address</h3>
            <p>123 Ice Cream Street, City</p>
         </div>
      </div>
   </div>
</section>

<?php include '../components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>