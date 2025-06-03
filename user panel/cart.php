<?php

include '../components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

// update qty in cart
if (isset($_POST['update_cart'])) {
    $cart_id = filter_var($_POST['cart_id'], FILTER_SANITIZE_STRING);
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_STRING);

    // Ensure the cart belongs to the current user
    $verify_cart = $conn->prepare("SELECT * FROM cart WHERE id = ? AND user_id = ?");
    $verify_cart->execute([$cart_id, $user_id]);

    if ($verify_cart->rowCount() > 0) {
        $update_qty = $conn->prepare("UPDATE cart SET qty = ? WHERE id = ?");
        $update_qty->execute([$qty, $cart_id]);
        $success_msg[] = 'cart quantity updated successfully';
    } else {
        $warning_msg[] = 'unauthorized action';
    }
}

// delete product from cart
if (isset($_POST['delete_item'])) {
    $cart_id = filter_var($_POST['cart_id'], FILTER_SANITIZE_STRING);

    $verify_delete_item = $conn->prepare("SELECT * FROM cart WHERE id = ? AND user_id = ?");
    $verify_delete_item->execute([$cart_id, $user_id]);

    if ($verify_delete_item->rowCount() > 0) {
        $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE id = ?");
        $delete_cart_id->execute([$cart_id]);
        $success_msg[] = 'cart item deleted successfully';
    } else {
        $warning_msg[] = 'cart item already deleted';
    }
}

// empty cart
if (isset($_POST['empty_cart'])) {
    $verify_empty_item = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $verify_empty_item->execute([$user_id]);

    if ($verify_empty_item->rowCount() > 0) {
        $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $delete_cart_id->execute([$user_id]);
        $success_msg[] = 'empty cart successfully';
    } else {
        $warning_msg[] = 'your cart is already empty';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> 
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Candle Shop - user cart page</title>
   <link rel="stylesheet" type="text/css" href="../css/user_style.css?v=<?php echo time(); ?>">
   <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
<?php include '../components/user_header.php'; ?>

<div class="banner">
    <div class="detail">
        <h1>Cart</h1>
        <p>Join us and light up your world with handcrafted candles.</p>
        <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Cart</span>
    </div>
</div>

<div class="products">
    <div class="heading">
        <h1>my cart</h1>
        <img src="../images/separator-img.png">
    </div>

    <div class="box-container">
        <?php 
        $grand_total = 0;
        $select_cart = $conn->prepare("
            SELECT c.id AS cart_id, c.qty, p.*
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?
        ");
        $select_cart->execute([$user_id]);

        if ($select_cart->rowCount() > 0) {
            while ($row = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                $sub_total = $row['qty'] * $row['price'];
                $grand_total += $sub_total;
        ?>
        <form action="" method="post" class="box <?php if ($row['stock'] == 0) echo 'disabled'; ?>">
            <input type="hidden" name="cart_id" value="<?= $row['cart_id']; ?>">
            <img src="uploaded_files/<?= $row['image']; ?>" class="image">
            <?php if ($row['stock'] > 9): ?>
                <span class="stock" style="color: green;">In stock</span>
            <?php elseif ($row['stock'] == 0): ?>
                <span class="stock" style="color: red;">Out of stock</span>
            <?php else: ?>
                <span class="stock" style="color: red;">Hurry only <?= $row['stock']; ?> left</span>
            <?php endif; ?>

            <div class="content">
                <img src="../images/shape-19.png" class="shap">
                <h3 class="name"><?= $row['name']; ?></h3>

                <div class="flex-btn">
                    <p class="price">price $<?= $row['price']; ?>/-</p>
                    <input type="number" name="qty" required min="1" value="<?= $row['qty']; ?>" max="99" maxlength="2" class="box qty" <?php if ($row['stock'] == 0) echo 'disabled'; ?>>
                    <button type="submit" name="update_cart" class="bx bxs-edit fa-edit box" <?php if ($row['stock'] == 0) echo 'disabled'; ?>></button>
                </div>

                <div class="flex-btn">
                    <p class="sub-total">sub total : <span>$<?= $sub_total; ?></span></p>
                    <button type="submit" name="delete_item" class="btn" onclick="return confirm('remove from cart');">delete</button>
                </div>
            </div>
        </form>
        <?php 
            } 
        } else {
            echo '<div class="empty"><p>no products added yet!</p></div>';
        }
        ?>
    </div>

    <?php if ($grand_total > 0): ?>
    <div class="cart-total">
        <p>total amount payable : <span>$<?= $grand_total; ?>/-</span></p>
        <div class="button">
            <form action="" method="post">
                <button type="submit" name="empty_cart" class="btn" onclick="return confirm('are you sure to empty your cart');">empty cart</button>
            </form>
            <a href="checkout.php" class="btn">proceed to checkout</a>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include '../components/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>
<?php include '../components/alert.php'; ?>
</body>
</html>
