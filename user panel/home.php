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
   <title>Candle Shop - Home page</title>
   <link rel="stylesheet" type="text/css" href="../css/user_style.css">
   <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../components/user_header.php'; ?>

    <!-- slider section start -->
    <div class="slider-container">
        <div class="slider">
            <div class="slideBox active">
                <div class="textBox">
                    <h1>We craft each candle <br> with passion and purpose</h1>
                    <a href="menu.php" class="btn">Shop Now</a>
                </div>
                <div class="imgBox">
                    <img src="../images/slider.png" alt="Candle Slider">
                </div>
            </div>
        </div>
    </div>

    <!-- service section -->
    <section class="service">
        <div class="box-container">
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../images/service.png" class="img1" alt="Fast Delivery Icon">
                        <img src="../images/service (1).png" class="img2" alt="Fast Delivery Hover">
                    </div>
                </div>
                    <div class="details">
                        <h4>Fast Delivery</h4>
                        <span>100% Secure</span>
                    </div>
            </div>
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../images/services (2).png" class="img1" alt="Secure Payment Icon">
                        <img src="../images/services (3).png" class="img2" alt="Secure Payment Hover">
                    </div>
                </div>
                    <div class="details">
                        <h4>Secure Payment</h4>
                        <span>100% Secure</span>
                    </div>
                </div>
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../images/services (5).png" class="img1" alt="Easy Returns Icon">
                        <img src="../images/services (6).png" class="img2" alt="Easy Returns Hover">
                    </div>
                </div>
                    <div class="details">
                        <h4>Easy Returns</h4>
                        <span>24/7 Free Return</span>
                    </div>
            </div>
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="../images/services (7).png" class="img1" alt="Gift Service Icon">
                        <img src="../images/services (8).png" class="img2" alt="Gift Service Hover">
                    </div>
                </div>
                    <div class="details">
                        <h4>Gift Service</h4>
                        <span>Support Gift Service</span>
                    </div>
                </div>
        </div>
    </section>

    <!-- categories section -->
<section class="categories">
    <div class="heading">
        <h1>Featured Categories</h1>
        <img src="../images/separator-img.png" alt="Separator">
    </div>

    <div class="box-container">
        <div class="box">
            <img src="../images/Candle_Jars.jpg" alt="Coconut Candle">
            <a href="menu.php?category=coconut" class="btn">Coconut</a>
        </div>
        <div class="box">
            <img src="../images/Candle_Jars.jpg" alt="Chocolate Candle">
            <a href="menu.php?category=chocolate" class="btn">Chocolate</a>
        </div>
        <div class="box">
            <img src="../images/Candle_Jars.jpg" alt="Strawberry Candle">
            <a href="menu.php?category=strawberry" class="btn">Strawberry</a>
        </div>
        <div class="box">
            <img src="../images/Candle_Jars.jpg" alt="Corn Candle">
            <a href="menu.php?category=corn" class="btn">Corn</a>
        </div>
    </div>
</section>

<!-- taste section -->
<section class="taste">
    <div class="heading">
        <span>Special Offer</span>
        <h1>Buy any candle &amp; get one free</h1>
        <img src="../images/separator-img.png" alt="Separator">
    </div>
    <div class="box-container">
        <div class="box">
            <img src="../images/Candle_Jars.jpg" alt="Candle Jars">
            <div class="detail">
                <h2>Elegant & Cozy</h2>
                <h1>Jar Candle</h1>
            </div>
        </div>

        <div class="box">
            <img src="../images/Flower_Candle.jpg" alt="Flower Candle">
            <div class="detail">
                <h2>Floral Delight</h2>
                <h1>Flower Candle</h1>
            </div>
        </div>

        <div class="box">
            <img src="../images/Bear_Candle.jpg" alt="Teddy Bear Candle">
            <div class="detail">
                <h2>Adorable & Scented</h2>
                <h1>Teddy Bear Candle</h1>
            </div>
        </div>
    </div>
</section>

<!-- banner section -->
<section class="ice-container">
    <div class="overlay"></div>
    <div class="detail">
        <h1>Candles are warmer than <br> therapy for the soul</h1>
        <p>
            Discover our handcrafted candle collection. <br>
            Made with natural wax, infused with calming scents. <br>
            Light up peace and elegance in every flame.
        </p>
        <a href="menu.php" class="btn">Shop Now</a>
    </div>
</section>

<!-- usage section -->
<section class="usage">
    <div class="heading">
        <h1>How It Works</h1>
        <img src="../images/separator-img.png" alt="Separator">
    </div>
    <div class="row">
        <div class="box-container">
            <div class="box">
                <img src="../images/candles.png" alt="Step 1">
                <div class="detail">
                    <h3>Choose Your Candle</h3>
                    <p>Browse our collection of handcrafted candles and pick the scents and designs you love.</p>
                </div>
            </div>
            
            <div class="box">
                <img src="../images/shopping-bag.png" alt="Step 2">
                <div class="detail">
                    <h3>Place Your Order</h3>
                    <p>Add your favorite candles to the cart and complete your order with secure checkout.</p>
                </div>
            </div>
        </div>
            <img src="../images/Works.png" class="divider">
        <div class="box-container">
            <div class="box">
                <img src="../images/delivered.png" alt="Step 3">
                <div class="detail">
                    <h3>Get It Delivered</h3>
                    <p>Your candles are carefully packaged and delivered to your door with love and care.</p>
                </div>
            </div>

            <div class="box">
                <img src="../images/candle.png" alt="Step 4">
                <div class="detail">
                    <h3>Light & Enjoy</h3>
                    <p>Unwrap your candle, light it, and enjoy the cozy, fragrant atmosphere it brings to your space.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- pride section -->
<section class="pride">
    <div class="detail">
        <h1>We Take Pride In <br> Exceptional Fragrance</h1>
        <p>Experience the perfect blend of aroma and elegance in every candle. <br>
        Our candles are made with premium ingredients and crafted with passion.</p>
        <a href="menu.php" class="btn">Shop Now</a>
    </div>
</section>

<?php include '../components/footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../js/user_script.js"></script>
    <!-- <?php include '../components/connect.php'; ?> -->
</body>
</html>
