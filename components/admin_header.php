<header>
    <div class="logo">
        <img src="../images/logo.png" width="150" alt="Logo">
    </div>
    <div class="right">
        <div class="bx bxs-user" id="user-btn"></div>
        <div class="toggle-btn"><i class="bx bx-menu"></i></div>
    </div>

    <div class="profile-detail">
        <?php
            $select_profile = $conn->prepare("SELECT * FROM `sellers` WHERE id = ?");
            $select_profile->execute([$seller_id]);

            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="profile">
            <img src="../uploaded_files/<?= htmlspecialchars($fetch_profile['image']); ?>" class="logo-img" width="100" alt="Photo de profil">
            <p><?= htmlspecialchars($fetch_profile['name']); ?></p>
            <div class="flex-btn">
                <a href="profile.php" class="btn">Profil</a>
                <a href="../components/admin_logout.php" onclick="return confirm('Se déconnecter de ce site ?');" class="btn">Déconnexion</a>
            </div>
        </div>
        <?php } ?>
    </div>
</header>

<div class="sidebar-container">
    <div class="sidebar">
        <?php if (!empty($fetch_profile)) { ?>
        <div class="profile">
            <img src="../uploaded_files/<?= htmlspecialchars($fetch_profile['image']); ?>" class="logo-img" width="100" alt="Photo de profil">
            <p><?= htmlspecialchars($fetch_profile['name']); ?></p>
        </div>
        <?php } ?>

        <h5>Menu</h5>
        <div class="navbar">
            <ul>
                <li><a href="dashboard.php"><i class="bx bxs-home-smile"></i>Tableau de bord</a></li>
                <li><a href="add_product.php"><i class="bx bxs-shopping-bags"></i>Ajouter un produit</a></li>
                <li><a href="view_product.php"><i class="bx bxs-food-menu"></i>Voir les produits</a></li>
                <li><a href="user_accounts.php"><i class="bx bxs-user-detail"></i>Comptes utilisateurs</a></li>
                <li>
                    <a href="../components/admin_logout.php" onclick="return confirm('Se déconnecter du site ?');">
                        <i class="bx bx-log-out"></i>Déconnexion
                    </a>
                </li>
            </ul>
        </div>

        <h3>Suivez-nous</h3>
        <div class="social-links">
            <i class="bx bxl-facebook"></i>
            <i class="bx bxl-instagram-alt"></i>
            <i class="bx bxl-linkedin"></i>
            <i class="bx bxl-twitter"></i>
            <i class="bx bxl-pinterest-alt"></i>
        </div>
    </div>
</div>
