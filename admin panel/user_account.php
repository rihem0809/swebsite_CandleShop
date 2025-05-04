<?php
    include '../componements/connect.php';

    if (isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    } else {
        $seller_id = '';
        header('Location: login.php');
        exit(); // Ajouté pour arrêter l'exécution après redirection
    }

    if (isset($_POST['delete_msg'])){
        $delete_id = $_POST['delete_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_delete = $conn->prepare("SELECT * FROM `message` WHERE id=?");
        $verify_delete->execute([$delete_id]);
        if ($verify_delete->rowCount() > 0){
            $delete_msg = $conn->prepare("DELETE FROM `message` WHERE id=?");
            $delete_msg->execute([$delete_id]);
            $success_msg[] = 'message deleted successfully';
        } else {
            $warning_msg[] = 'message already deleted';
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Duo lumière - Registred users page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
</head> 
<body>
    <div class="main-container">
        <?php include '../componements/admin_header.php'; ?>
        <section class="message-container">
            <div class="heading">
                <h1>registered user</h1>
                <img src="../images/separator-img.png">
            </div>
            <div class="box-container">
                <?php
                    $select_users = $conn->prepare("SELECT * FROM `user`");
                    $select_users->execute();

                    if($select_users->rowCount() > 0){
                        while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)) {
                            $user_id = $fetch_users['id'];
                ?>
                    <div class="box">
                        <img src="../uploaded_files/<?= $fetch_users['image']; ?>" alt="user image">
                        <p> user id : <span><?= $user_id; ?></span></p>
                        <p> user name : <span><?= $fetch_users['name']; ?></span></p>
                        <p> user email : <span><?= $fetch_users['email']; ?></span></p>
                        <p> registered on : <span><?= $fetch_users['date']; ?></span></p>
                        <p> user number : <span><?= $fetch_users['number']; ?></span></p>
                    </div>
                <?php
                        }
                    } else {
                        echo '
                        <div class="empty">
                            <p> no user registered yet!</p>
                        </div>';
                    }
                ?>
            </div>
        </section>
    </div>

    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script src="../js/admin_script.js"></script>

    <?php include '../componements/alert.php'; ?>
</body>
</html>
