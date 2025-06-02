<?php
    include '../components/connect.php';
    session_start(); // Démarrage de la session

    if(isset($_POST['submit'])){

        // Récupération et nettoyage de l'email
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Récupération et nettoyage du mot de passe
        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        // Vérification des identifiants dans la base de données
        $select_seller = $conn->prepare("SELECT * FROM sellers WHERE email = ? AND password = ?"); 
        $select_seller->execute([$email, $pass]);
        $row = $select_seller->fetch(PDO::FETCH_ASSOC);

        if($select_seller->rowCount() > 0){
            $_SESSION['seller_id'] = $row['id']; // Stockage de l'ID dans la session
            header('Location: dashboard.php'); 
            exit;
        } else {
            $warning_msg[] = 'Email ou mot de passe incorrect';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Duo lumière - seller login page</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head> 
<body>
  <div class="form-container">
    <form action="" method="post" enctype="multipart/form-data" class="login"   autocomplete="new-password">
        <h3>Login Now</h3>

        <div class="input-field">
            <p>Your email <span>*</span></p>
            <input type="email" name="email" placeholder="Entrez votre email" maxlength="50" required class="box"  autocomplete="new-password">
        </div>

        <div class="input-field">
            <p>Your password <span>*</span></p>
            <input type="password" name="pass" placeholder="Entrez votre mot de passe" maxlength="50" required class="box"  autocomplete="new-password">
        </div>

        <p class="link">Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous</a></p>
        <input type="submit" name="submit" value="Se connecter" class="btn">
    </form>
  </div>

  <!-- SweetAlert CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="../js/script.js"></script>

  <?php include '../components/alert.php'; ?>
</body>
</html>
