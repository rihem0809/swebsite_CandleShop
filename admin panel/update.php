<?php
include '../components/connect.php';

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('Location: login.php');
    exit;
}

if (isset($_POST['submit'])) {

    // Récupérer les infos actuelles
    $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE id = ? LIMIT 1");
    $select_seller->execute([$seller_id]);
    $fetch_sellers = $select_seller->fetch(PDO::FETCH_ASSOC);

    if ($fetch_sellers) {
        $prev_pass = $fetch_sellers['password'];
        $prev_image = $fetch_sellers['image'];

        $name = $_POST["name"];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST["email"];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        if (!empty($name)) {
            $update_name = $conn->prepare("UPDATE `sellers` SET name = ? WHERE id = ?");
            $update_name->execute([$name, $seller_id]);
            $success_msg[] = 'username updated successfuly';
        }

        if (!empty($email)) {
            $select_email = $conn->prepare("SELECT * FROM `sellers` WHERE id = ? AND email = ?");
            $select_email->execute([$seller_id, $email]);

            if ($select_email->rowCount() > 0) {
                $warning_msg[] = 'email already exist';
            } else {
                $update_email = $conn->prepare("UPDATE `sellers` SET email = ? WHERE id = ?");
                $update_email->execute([$email, $seller_id]);
                $success_msg[] = 'email updated successfuly';
            }
        }

        // Gestion de l'image
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $image = filter_var($image, FILTER_SANITIZE_STRING);
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            $rename = uniqid() . '.' . $ext;
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_size = $_FILES['image']['size'];
            $image_folder = '../uploaded_files/' . $rename;

            if ($image_size > 2000000) {
                $warning_msg[] = 'image size is too large';
            } else {
                $update_image = $conn->prepare("UPDATE `sellers` SET image = ? WHERE id = ?");
                $update_image->execute([$rename, $seller_id]);
                move_uploaded_file($image_tmp_name, $image_folder);

                if ($prev_image !== '' AND $prev_image != $rename) {
                    unlink('../uploaded_files/' . $prev_image);
                }

                $success_msg[] = 'Image updated successfuly';
            }
        }

        // Gestion du mot de passe
        $empty_pass = sha1('');
        $old_pass = filter_var(sha1($_POST['old_pass']), FILTER_SANITIZE_STRING);
        $new_pass = filter_var(sha1($_POST['new_pass']), FILTER_SANITIZE_STRING);
        $cpass = filter_var(sha1($_POST['cpass']), FILTER_SANITIZE_STRING);

        if ($old_pass !== $empty_pass) {
            if ($old_pass !== $prev_pass) {
                $warning_msg[] = 'old password not matched';
            } elseif ($new_pass !== $cpass) {
                $warning_msg[] = 'password not matched';
            } else {
                $update_pass = $conn->prepare("UPDATE `sellers` SET password = ? WHERE id = ?");
                $update_pass->execute([$cpass, $seller_id]);
                $success_msg[] = 'password updated successfuly';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Candle Shop - Update Profile Page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
</head> 
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?> 
        <section class="form-container"> 
            <div class="heading">
                <h1>update profile details</h1>
                <img src="../images/separator-img.png">
            </div>   
            <form action="" method="post" enctype="multipart/form-data" class="register" autocomplete="off">
                <div class="img-box">
                    <img src="../uploaded_files/<?= $fetch_profile['image']; ?>">
                </div>
                <div class="flex">
                    <div class="col">
                        <div class="input-field">
                            <p> your name <span>*</span></p>
                            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="box">
                        </div>
                        <div class="input-field">
                            <p> your email <span>*</span></p>
                            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box" autocomplete="off">
                        </div>
                        <div class="input-field">
                            <p> select pic <span>*</span></p>
                            <input type="file" name="image" accept="image/*" class="box">
                        </div>
                    </div>
                
                <div class="col">
                    <div class="input-field">
                        <p> old password <span>*</span></p>
                        <input type="password" name="old_pass" placeholder="enter your old password" class="box" autocomplete="new-password">
                    </div>
                    <div class="input-field">
                        <p> new password <span>*</span></p>
                        <input type="password" name="new_pass" placeholder="enter your new password" class="box" autocomplete="new-password">

                    </div>
                    <div class="input-field ">
                        <p> confirm password <span>*</span></p>
                        <input type="password" name="cpass" placeholder="confirm your new password" class="box" autocomplete="new-password">
                    </div>
                </div>
            </div>
            <input type="submit" name="submit" value="update profile" class="btn">
            </form>
        </section>
    </div>

    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="../js/admin_script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>
</html>
