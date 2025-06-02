<?php
function checkSellerSessionAndGetProfile(PDO $conn) {
    session_start();

    if (!isset($_SESSION['seller_id'])) {
        header('Location: login.php');
        exit();
    }

    $seller_id = $_SESSION['seller_id'];

    $select_profile = $conn->prepare("SELECT * FROM sellers WHERE id = ?");
    $select_profile->execute([$seller_id]);
    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

    if (!$fetch_profile) {
        // Si le vendeur n'existe pas, déconnecter et rediriger
        session_destroy();
        header('Location: login.php');
        exit();
    }

    return ['seller_id' => $seller_id, 'profile' => $fetch_profile];
}
?>
