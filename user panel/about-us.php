<?php
include '../components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> 
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Candle Shop - About Us page</title>
   <link rel="stylesheet" type="text/css" href="../css/user_style.css">
   <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../components/user_header.php'; ?>

    <div class="banner">
    <div class="detail">
        <h1>About Us</h1>
        <p>At Candle Shop, we handcraft each candle with love and care to brighten your world and create cozy moments.</p>
        <span>
        <a href="home.php">Home</a> 
        <i class="bx bx-right-arrow-alt"></i> About Us
        </span>
    </div>
    </div>


    <div class="chef">
    <div class="box-container">
        <div class="box">
            <div class="heading">
                <span>Duo Light</span>
                <h1>Creators of Light</h1>
                <img src="../images/separator-img.png">
            </div>
            <p>We are two passionate women crafting handmade candles to gently light up your moments with elegance and warmth.</p>
            <div class="flex-btn">
                <a href="" class="btn">discover our collection</a>
                <a href="menu.php" class="btn">visit our shop</a>
            </div>
        </div>
        <div class="box">
            <img src="../images/Créatrices.jpg" class="img">
        </div>
        </div>
    </div>

    <!-- story section -->
    <div class="story">
        <div class="heading">
            <h1>our story</h1>
            <img src="../images/separator-img.png">
        </div>
        <p>Two creative souls united by a love for light and serenity — handcrafting candles that bring calm and beauty to every space.</p>
        <a href="menu.php" class="btn">our services</a>
    </div>

    <!-- story section -->
    <div class="team">
        <div class="heading">
            <span>our team</span>
            <h1>Creativity & Passion in Every Candle</h1>
            <img src="../image/separator-img.png" alt="">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="../images/Créatrices1.jpg" alt="" class="img">
                <div class="content">
                    <img src="../images/shape-19.png" alt="" class="shap">
                    <h2>Rihab Adalet</h2>   
                </div>
            </div>
            <div class="box">
                <img src="../images/Créatrices2.jpg" alt="" class="img">
                <div class="content">
                    <img src="../images/shape-19.png" alt="" class="shap">
                    <h2>Rihem Naifar</h2>
                </div>
            </div>
        </div>
    </div>




    
    
    <?php include '../components/footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/user_script.js"></script>
    <!-- <?php include '../components/connect.php'; ?> -->
</body>
</html>
