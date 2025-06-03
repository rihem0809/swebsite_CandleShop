<?php

include '../components/connect.php';

if (!isset($_COOKIE['user_id'])) {
    header('location: login.php');
    exit;
}
$user_id = $_COOKIE['user_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> 
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Candle Shop - Order page</title>
   <link rel="stylesheet" type="text/css" href="../css/user_style.css?v=<?php echo time(); ?>">
   <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>Our shop</h1>
            <p>Join us and light up your world with handcrafted candles.</p>
            <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Order</span>
        </div>
    </div>

    <div class="orders">
        <div class="heading">
            <h1>our latest candles</h1>
            <img src="../images/separator-img.png">
        </div>

        <div class="box-container">
            <?php
            $select_orders = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY date DESC");
            $select_orders->execute([$user_id]);

            if ($select_orders->rowCount() > 0) {
                while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                    $product_id = $fetch_orders['product_id'];

                    $select_products = $conn->prepare("SELECT * FROM products WHERE id = ?");
                    $select_products->execute([$product_id]);

                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
               <div class="box" <?php if ($fetch_orders['status'] == 'canceled') echo 'style="border: 2px solid red"'; ?>>
                    <a href="view_order.php?get_id=<?= $fetch_orders['id']; ?>">
                        <img src="uploaded_files/<?= $fetch_products['image'] ?>" class="image">
                        <p class="date"><i class="bx bxs-calender-alt"></i> <?= $fetch_orders['date']; ?></p>

                        <div class="content">
                            <img src="../images/shape-19.png" class="shap">

                            <div class="row">
                                <h3 class="name"><?= $fetch_products['name'] ?></h3>
                                <p class="price">Price : $<?= $fetch_products['price'] ?>/-</p>
                                <p class="status" style="color:<?php
                                    if ($fetch_orders['status'] == 'delivered') {
                                        echo "green";
                                    } elseif ($fetch_orders['status'] == 'canceled') {
                                        echo "red";
                                    } else {
                                        echo "orange";
                                    }
                                ?>"><?= $fetch_orders['status']; ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
                        }
                    }
                }
            } else {
                echo '<p>No orders have been placed yet</p>';
            }
            ?>
        </div>
    </div>
    
<!-- SweetAlert CDN link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Custom JS link -->
<script src="../js/script.js"></script>
<?php include '../components/alert.php'; ?>
<?php include '../components/footer.php'; ?>
</body>
</html>
