<?php
    include '../components/connect.php';
    include '../components/session.php';

    $data = checkSellerSessionAndGetProfile($conn);
    $seller_id = $data['seller_id'];
    $fetch_profile = $data['profile'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Duo Lumière - Page d'inscription vendeur</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
</head> 
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?> 

        <section class="dashboard">
            <div class="heading">
                <h1>Dashboard</h1>
                <img src="../images/separator-img.png">
            </div>

            <div class="box-container">
                <div class="box">
                    <h3>Welcome </h3>
                    <p><?= $fetch_profile['name']; ?></p>
                    <a href="update.php" class="btn">Update profile</a>
                </div>

                <div class="box">
                    <?php
                        $select_message = $conn->prepare("SELECT * FROM message");
                        $select_message->execute();
                        $number_of_msg = $select_message->rowCount();
                    ?>
                    <h3><?= $number_of_msg; ?></h3>
                    <p>Unread messages</p>
                    <a href="admin_message.php" class="btn">See messages</a>
                </div>

                <div class="box">
                    <?php
                        $select_products = $conn->prepare("SELECT * FROM products WHERE seller_id = ?");
                        $select_products->execute([$seller_id]);
                        $number_of_products = $select_products->rowCount();
                    ?>
                    <h3><?= $number_of_products; ?></h3>
                    <p>Products added</p>
                    <a href="add_product.php" class="btn">Add product</a>
                </div>

                <div class="box">
                    <?php
                        $select_active_products = $conn->prepare("SELECT * FROM products WHERE seller_id = ? AND status = ?");
                        $select_active_products->execute([$seller_id, 'active']);
                        $number_of_active_products = $select_active_products->rowCount();
                    ?>
                    <h3><?= $number_of_active_products; ?></h3>
                    <p>Total active products</p>
                    <a href="view_product.php" class="btn">Active products</a>
                </div>

                <div class="box">
                    <?php
                        $select_deactive_products = $conn->prepare("SELECT * FROM products WHERE seller_id = ? AND status = ?");
                        $select_deactive_products->execute([$seller_id, 'deactive']);
                        $number_of_deactive_products = $select_deactive_products->rowCount();
                    ?>
                    <h3><?= $number_of_deactive_products; ?></h3>
                    <p>Total deactive products</p>
                    <a href="view_product.php" class="btn">Deactive products</a>
                </div>

                <div class="box">
                    <?php
                        $select_users = $conn->prepare("SELECT * FROM users");
                        $select_users->execute();
                        $number_of_users = $select_users->rowCount();
                    ?>
                    <h3><?= $number_of_users; ?></h3>
                    <p>Users account</p>
                    <a href="user_account.php" class="btn">See users</a>
                </div>

                <div class="box">
                    <?php
                        $select_sellers = $conn->prepare("SELECT * FROM sellers");
                        $select_sellers->execute();
                        $number_of_sellers = $select_sellers->rowCount();
                    ?>
                    <h3><?= $number_of_sellers; ?></h3>
                    <p>Sellers account</p>
                    <a href="user_account.php" class="btn">See sellers</a>
                </div>

                <div class="box">
                    <?php
                        $select_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id = ?");
                        $select_orders->execute([$seller_id]);
                        $number_of_orders = $select_orders->rowCount();
                    ?>
                    <h3><?= $number_of_orders; ?></h3>
                    <p>Total orders placed</p>
                    <a href="admin_order.php" class="btn">Total orders</a>
                </div>

                <div class="box">
                    <?php
                        $select_confirm_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id = ? AND status = ?");
                        $select_confirm_orders->execute([$seller_id, 'in progress']);
                        $number_of_confirm_orders = $select_confirm_orders->rowCount();
                    ?>
                    <h3><?= $number_of_confirm_orders; ?></h3>
                    <p>Total confirmed orders</p>
                    <a href="admin_order.php" class="btn">Confirmed orders</a>
                </div>

                <div class="box">
                    <?php
                        $select_canceled_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id = ? AND status = ?");
                        $select_canceled_orders->execute([$seller_id, 'canceled']);
                        $number_of_canceled_orders = $select_canceled_orders->rowCount();
                    ?>
                    <h3><?= $number_of_canceled_orders; ?></h3>
                    <p>Total canceled orders</p>
                    <a href="admin_order.php" class="btn">Canceled orders</a>
                </div>
            </div>
        </section>
    </div>

    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="../js/admin_script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>
</html>
