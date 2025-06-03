<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
if (isset($_POST['remove_from_wishlist'])) {
    $product_id = $_POST['product_id'];
    $delete_wishlist = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
    $delete_wishlist->execute([$user_id, $product_id]);

    echo "<script>swal('Removed!', 'Product removed from wishlist.', 'success');</script>";
}


include 'components/add_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> 
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Candle Shop - user cart page</title>
   <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
   <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
<?php include 'components/user_header.php'; ?>


<div class="banner">
    <div class="detail">
        <h1>My Wishlist</h1>
        <p>Join us and light up your world with handcrafted candles.</p>
        <span><a href="home.php">Home</a><i class="bx bx-right-arrow-alt"></i>Wishlist</span>
    </div>
</div>

<div class="products">
    <div class="heading">
        <h1>Your Favorite Candles</h1>
        <img src="images/separator-img.png">
    </div>
    <div class="box-container">
        <?php
        if ($user_id != '') {
            $select_wishlist = $conn->prepare("SELECT w.*, p.* FROM wishlist w JOIN products p ON w.product_id = p.id WHERE w.user_id = ?");
            $select_wishlist->execute([$user_id]);

            if ($select_wishlist->rowCount() > 0) {
                while ($fetch_product = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <form action="" method="POST" class="box">
            <img src="uploaded_files/<?= $fetch_product['image']; ?>" class="image">
            <?php if($fetch_product['stock'] > 9){ ?>
                <span class="stock" style="color: green;">In stock</span>
            <?php } elseif($fetch_product['stock'] == 0){ ?>
                <span class="stock" style="color: red;">Out of stock</span>
            <?php } else { ?>
                <span class="stock" style="color: red;">Hurry, only <?= $fetch_product['stock']; ?></span>
            <?php } ?>

            <div class="content">
                <img src="images/shape-19.png" alt="" class="shap">
                <div class="button">
                    <div><h3 class="name"><?= $fetch_product['name']; ?></h3></div>
                    <div>
                        <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                        <a href="view_p.php?pid=<?= $fetch_product['id']; ?>" class="bx bxs-show"></a>
                        <button type="submit" name="remove_from_wishlist" onclick="return confirm('Remove from wishlist?');">
            <i class="bx bx-trash"></i>
         </button>
                    </div>
                </div>
                <p class="price">Price $<?= $fetch_product['price']; ?></p>
                <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                <div class="flex-btn">
                    <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>" class="btn">Buy Now</a>
       
                </div>
            </div>
        </form>
        <?php
                }
            } else {
                echo '<p class="empty">Your wishlist is empty!</p>';
            }
        } else {
            echo '<p class="empty">Please login to view your wishlist.</p>';
        }
        ?>
    </div>
</div>

<!-- SweetAlert CDN link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Custom JS link -->
<script src="js/script.js"></script>
<?php include 'components/alert.php'; ?>
<?php include 'components/footer.php'; ?>
</body>
</html>
