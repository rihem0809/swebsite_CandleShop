<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {

    // Récupérer les infos actuelles
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
    $select_user->execute([$user_id]);
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($fetch_user) {
        $prev_pass = $fetch_user['password'];
        $prev_image = $fetch_user['image'];

        $name = $_POST["name"];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST["email"];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        if (!empty($name)) {
            $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
            $update_name->execute([$name, $user_id]);
            $success_msg[] = 'username updated successfuly';
        }

        if (!empty($email)) {
            $select_email = $conn->prepare("SELECT * FROM `users` WHERE id = ? AND email = ?");
            $select_email->execute([$user_id, $email]);

            if ($select_email->rowCount() > 0) {
                $warning_msg[] = 'email already exist';
            } else {
                $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
                $update_email->execute([$email, $users_id]);
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
            $image_folder = 'uploaded_files/' . $rename;

            if ($image_size > 2000000) {
                $warning_msg[] = 'image size is too large';
            } else {
                $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
                $update_image->execute([$rename, $users_id]);
                move_uploaded_file($image_tmp_name, $image_folder);

                if ($prev_image !== '' AND $prev_image != $rename) {
                    unlink('uploaded_files/' . $prev_image);
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
                $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                $update_pass->execute([$cpass, $user_id]);
                $success_msg[] = 'password updated successfuly';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> 
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Candle Shop - Update Profile page</title>
   <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
   <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'components/user_header.php'; ?>
       <div class="banner">
        <div class="detail">
            <h1>register</h1>
            <p>Join us and light up your world with handcrafted candles.</p>
            <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>Update Profile</span>
        </div>
    </div>

     <section class="form-container"> 
            <div class="heading">
                <h1>update profile</h1>
                <img src="images/separator-img.png">
            </div>   
            <form action="" method="post" enctype="multipart/form-data" class="register" autocomplete="off">
                <div class="img-box">
                    <img src="uploaded_files/<?= $fetch_profile['image']; ?>">
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

  <!-- SweetAlert CDN link -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Custom JS link -->
  <script src="js/script.js"></script>
  <?php include 'components/alert.php'; ?>
  <?php include 'components/footer.php'; ?>
</body>
</html>
