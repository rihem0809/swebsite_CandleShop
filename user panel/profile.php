<?php
include '../components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    header('Location: login.php');
    exit;
}

$select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
$select_orders->execute([$user_id]);
$total_orders = $select_orders->rowCount();

$select_message = $conn->prepare("SELECT * FROM `message` WHERE user_id = ?");
$select_message->execute([$user_id]);
$total_message = $select_message->rowCount();

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> 
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Candle Shop - User Profile page</title>
   <link rel="stylesheet" type="text/css" href="../css/user_style.css?v=<?php echo time(); ?>">
   <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>register</h1>
            <p>Join us and light up your world with handcrafted candles.</p>
            <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>profile</span>
        </div>
    </div>

    <section class="profile">
        <div class="heading">
            <h1>profile detail</h1>
            <img src="../images/separator-img.png">
        </div>
                <div class="details">
            <div class="user">
                <img src="../uploaded_files/<?= $fetch_profile['image']; ?>">
                <h3><?= $fetch_profile['name']; ?></h3>
                <p>user</p>
                <a href="update.php" class="btn">update profile</a>
            </div>
            <div class="box-container"><!-- Correction ici -->
                <div class="box">
                    <div class="flex">
                        <i class="bx bxs-folder-minus"></i>
                        <h3><?= $total_orders; ?></h3>
                    </div>
                    <a href="order.php" class="btn">view orders</a>
                </div>
                <div class="box">
                    <div class="flex">
                        <i class="bx bxs-chat"></i>
                        <h3><?= $total_message; ?></h3>
                    </div>
                    <a href="messages.php" class="btn">view message</a>
                </div>
            </div>
        </div>
    </section> 


        <!-- SweetAlert CDN link -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

        <!-- Custom JS link -->
        <script src="../js/script.js"></script>
        <?php include '../components/alert.php'; ?>
        <?php include '../components/footer.php'; ?>
</body>
</html>
